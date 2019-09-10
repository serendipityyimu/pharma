<?php

//***********bsc_fns.php**************
//Created by Philippe Nong
//Contact: philippe.nong@efc2-consulting.com
//Created: 22/11/2017
//Last modified: 29/11/2017
//Outils de pilotage



//Fonction pour afficher le suivi de CA: fichier suivi_CA.php
function suivi_CA($civil){
	//
	if($civil==1){
		$agreg_year = 'CIVIL_YEAR';
		$begin_month = "01";
		$end_month = "12";
		$end_day = "31";
	}
	else {
		$agreg_year = 'ACCOUNTING_YEAR';
		$begin_month = "05";
		$end_month = "04";
		$end_day = "30";
	}
	$query_max_min = "SELECT MAX(DATE_CA) AS MAX_DATE, MIN(DATE_CA) AS MIN_DATE FROM SUIVI_CA_MENSUEL";
	$result_max_min = execute_query($query_max_min);
	if($result_max_min){
		$row_max_min = next_line($result_max_min);
		$date_max = $row_max_min['MAX_DATE'];
		$date_min = $row_max_min['MIN_DATE'];
		$query = "SELECT " . $agreg_year. " AS YEAR, SUM(FREQUENTATION) AS FREQUENTATION, SUM(CA_HT) AS CA_HT FROM SUIVI_CA_MENSUEL, REF_DATE WHERE DATE_CA = FULL_DATE GROUP BY " . $agreg_year . " ORDER BY DATE_CA DESC";

		$result = execute_query($query);
		if($result){
			display_suivi_CA_head();
			$suivi_CA = array_result($result);
			
//Initialisation des variables
			$annee_N = array();
			$annee_N_1 = array();
			$nbAnnees = sizeof($suivi_CA);
			
//Itération spécifique pour la dernière année
			if ($civil==1) {
				$date_debut = $suivi_CA[0]['YEAR'] . '/' . $begin_month . '/01';
				$date_fin = $suivi_CA[0]['YEAR'] . '/' . $end_month . '/' . $end_day;
			}
			else if ($civil<>1 && month($date_max)>$end_month) {
				$date_debut = $suivi_CA[0]['YEAR'] . '/' . $begin_month . '/01';
				$date_fin = $suivi_CA[0]['YEAR']+1 . '/' . $end_month . '/' . $end_day;
			}
			else {
				$date_debut = $suivi_CA[0]['YEAR']-1 . '/' . $begin_month . '/01';
				$date_fin = $suivi_CA[0]['YEAR'] . '/' . $end_month . '/' . $end_day;
			}

			$annee_N[] = array('CA_detail'=> $suivi_CA[0]['YEAR'], 'FREQUENTATION' => $suivi_CA[0]['FREQUENTATION'], 'CA_HT' => $suivi_CA[0]['CA_HT'], 'DATE_DEBUT' => $date_debut, 'DATE_FIN' => $date_fin);
			$date_fin = date('Y/m/d', strtotime($date_debut.' - 1 DAY'));
			$date_debut = date('Y/m/d', strtotime($date_debut.' - 1 YEAR'));
			$annee_N_1[] = array('CA_detail'=> $suivi_CA[1]['YEAR'], 'FREQUENTATION' => $suivi_CA[1]['FREQUENTATION'], 'CA_HT' => $suivi_CA[1]['CA_HT'], 'DATE_DEBUT' => $date_debut, 'DATE_FIN' => $date_fin);

//Itérations pour les autres années
			for ($i=1; $i < $nbAnnees-1; $i++) { 
				$annee_N[] = array('CA_detail'=> $suivi_CA[$i]['YEAR'], 'FREQUENTATION' => $suivi_CA[$i]['FREQUENTATION'], 'CA_HT' => $suivi_CA[$i]['CA_HT'], 'DATE_DEBUT' => $date_debut, 'DATE_FIN' => $date_fin);
				$date_fin = date('Y/m/d', strtotime($date_debut.' - 1 DAY'));
				$date_debut = date('Y/m/d', strtotime($date_debut.' - 1 YEAR'));
				$annee_N_1[] = array('CA_detail'=> $suivi_CA[$i+1]['YEAR'], 'FREQUENTATION' => $suivi_CA[$i+1]['FREQUENTATION'], 'CA_HT' => $suivi_CA[$i+1]['CA_HT'], 'DATE_DEBUT' => $date_debut, 'DATE_FIN' => $date_fin);
			}

			for ($i=0; $i < sizeof($annee_N); $i++) { 
				display_table_suivi_CA($annee_N[$i]['CA_detail'], 
										annee($annee_N[$i]['DATE_DEBUT']),
										formatDateFR($annee_N[$i]['DATE_DEBUT']), 
										formatDateFR($annee_N[$i]['DATE_FIN']), 
										number_format($annee_N[$i]['CA_HT'], 2, ".", " "), 
										number_format($annee_N_1[$i]['CA_HT'], 2, ".", " "),
										number_format(($annee_N[$i]['CA_HT']-$annee_N_1[$i]['CA_HT'])/$annee_N_1[$i]['CA_HT']*100, 2, ".", " "), 
										number_format($annee_N[$i]['FREQUENTATION'], 0, ".", " "), 
										number_format($annee_N_1[$i]['FREQUENTATION'], 0, ".", " "), 
										number_format(($annee_N[$i]['FREQUENTATION']-$annee_N_1[$i]['FREQUENTATION'])/$annee_N_1[$i]['FREQUENTATION']*100, 2, ".", " ")
									);
				suivi_CA_detail($annee_N[$i]['CA_detail'], 'table_CA_detail_' . $annee_N[$i]['CA_detail'], $agreg_year);
			}

			if ($civil<>1){
				$lastRow = sizeof($annee_N)-1;
				display_table_suivi_CA($annee_N_1[$lastRow]['CA_detail'], 
										annee($annee_N_1[$lastRow]['DATE_DEBUT']),
										formatDateFR($annee_N_1[$lastRow]['DATE_DEBUT']), 
										formatDateFR($annee_N_1[$lastRow]['DATE_FIN']),
										number_format($annee_N_1[$lastRow]['CA_HT'], 2, ".", " "), 
										'N/A',
										'N/A', 
										number_format($annee_N_1[$lastRow]['FREQUENTATION'], 0, ".", " "),
										'N/A','N/A');
				 suivi_CA_detail($annee_N_1[$lastRow]['CA_detail'], 'table_CA_detail_' . $annee_N_1[$lastRow]['CA_detail'], $agreg_year);
			}
			display_suivi_CA_footer();
		}
		else return 0;
	}
	else return 0;
}

//
function suivi_CA_detail($annee, $suivi_CA_detail, $agreg_year){
	$query = 'SELECT MONTH(DATE_CA) AS MONTH, ' . $agreg_year . ' AS YEAR, FREQUENTATION, CA_HT FROM SUIVI_CA_MENSUEL, REF_DATE WHERE DATE_CA=FULL_DATE AND (' . $agreg_year . '=' . $annee . ' OR ' . $agreg_year . '=' . ($annee-1) . ') ORDER BY DATE_CA DESC';
	// echo $query . "<br><br>";
	$result = execute_query($query);
	if ($agreg_year=='CIVIL_YEAR') {
		$MONTHS = [1,2,3,4,5,6,7,8,9,10,11,12];
	}
	else {
		$MONTHS = [5,6,7,8,9,10,11,12,1,2,3,4];
	}
	if($result){
		$annee_N = array();
		$annee_N_1 = array();
		$array_result = array_result($result);
//Si on a le resultat pour deux années consécutives complètes, on stocke les valeurs de chaque année dans un tableau distinct
		if(sizeof($array_result) == 24){
			for($i=0;$i<12;$i++){
				$annee_N[] = array("MONTH"=>formatMonthFR($array_result[$i]['MONTH']), "YEAR"=>$array_result[$i]['YEAR'], "FREQUENTATION"=>$array_result[$i]['FREQUENTATION'], "CA_HT"=>$array_result[$i]['CA_HT']);

				$annee_N_1[] =  array("MONTH"=>formatMonthFR($array_result[$i+12]['MONTH']), "YEAR"=>$array_result[$i+12]['YEAR'], "FREQUENTATION"=>$array_result[$i+12]['FREQUENTATION'], "CA_HT"=>$array_result[$i+12]['CA_HT']);
			}
		}
		else {
			$LAST_MONTH_N = 0;
			$LAST_MONTH_N_1 = 0;
			for ($i=0; $i < sizeof($array_result); $i++) { 
				if ($array_result[$i]['YEAR'] == $array_result[0]['YEAR']) {
					$LAST_MONTH_N++;
				}
				else {
					$LAST_MONTH_N_1++;
				}
			}

//Il n'y a pas les 12 mois de l'année N: on complète le tableau avec des valeurs nulles
			if ($LAST_MONTH_N < 12) {
				for ($j=11; $j >= $LAST_MONTH_N; $j--) { 
					$annee_N[] = array("MONTH"=>formatMonthFR($MONTHS[$j]),"YEAR"=>$array_result[0]['YEAR'], "FREQUENTATION"=>'N/A', "CA_HT"=>'N/A');
				}
			}
			for($i=0;$i<sizeof($array_result);$i++){
				if($array_result[$i]['YEAR']==$annee){
					$annee_N[] =  array("MONTH"=>formatMonthFR($array_result[$i]['MONTH']), "YEAR"=>$array_result[$i]['YEAR'], "FREQUENTATION"=>$array_result[$i]['FREQUENTATION'], "CA_HT"=>$array_result[$i]['CA_HT']);
				}
				else{
					$annee_N_1[] =  array("MONTH"=>formatMonthFR($array_result[$i]['MONTH']), "YEAR"=>$array_result[$i]['YEAR'], "FREQUENTATION"=>$array_result[$i]['FREQUENTATION'], "CA_HT"=>$array_result[$i]['CA_HT']);
				}
			}
			if ($LAST_MONTH_N_1 < 12 && $LAST_MONTH_N_1 > 0) {
				for ($j=$LAST_MONTH_N_1-1; $j >= 0; $j--) { 
					$annee_N_1[] = array("MONTH"=>formatMonthFR($MONTHS[$j]),"YEAR"=>$array_result[sizeof($array_result)-1]['YEAR'], "FREQUENTATION"=>'N/A', "CA_HT"=>'N/A');
				}
			}
			else {
				for ($j=11; $j >= 0; $j--) { 
					$annee_N_1[] = array("MONTH"=>formatMonthFR($MONTHS[$j]),"YEAR"=>$array_result[sizeof($array_result)-1]['YEAR'], "FREQUENTATION"=>'N/A', "CA_HT"=>'N/A');
				}				
			}
		}

		//On formate les données pour l'affichage
		for ($i=0; $i < sizeof($annee_N); $i++) { 
			$month = $annee_N[$i]['MONTH'];
			$annee_N[$i]['CA_HT']=='N/A'? $CA_N = 'N/A':$CA_N = $annee_N[$i]['CA_HT'] . ' €';
			$annee_N_1[$i]['CA_HT']=='N/A'? $CA_N_1 = 'N/A':$CA_N_1 = $annee_N_1[$i]['CA_HT'] . ' €';
			($annee_N[$i]['CA_HT']=='N/A'||$annee_N_1[$i]['CA_HT']=='N/A')?$evol_CA ='N/A':$evol_CA =number_format(($annee_N[$i]['CA_HT']-$annee_N_1[$i]['CA_HT'])/$annee_N_1[$i]['CA_HT']*100, 2, ".", " ") . " %";
			$annee_N[$i]['FREQUENTATION']=='N/A'? $frequentation_N = 'N/A':$frequentation_N = $annee_N[$i]['FREQUENTATION'];
			$annee_N_1[$i]['FREQUENTATION']=='N/A'? $frequentation_N_1 = 'N/A':$frequentation_N_1 = $annee_N_1[$i]['FREQUENTATION'];
			($annee_N[$i]['FREQUENTATION']=='N/A'||$annee_N_1[$i]['FREQUENTATION']=='N/A')?$evol_freq = 'N/A':$evol_freq = number_format(($annee_N[$i]['FREQUENTATION']-$annee_N_1[$i]['FREQUENTATION'])/$annee_N_1[$i]['FREQUENTATION']*100, 2, ".", " ") . " %";
			

			$CA_detail_N[] = array('MONTH' => $month, 'CAHT_N' =>$CA_N, 'CAHT_N_1' =>$CA_N_1, 'EVOL_CAHT' => $evol_CA, 'FREQUENTATION_N' => $frequentation_N, 'FREQUENTATION_N_1' => $frequentation_N_1, 'EVOL_FREQUENTATION' => $evol_freq);
		}
		
		display_CA_detail($CA_detail_N,$suivi_CA_detail);
	}
}




//Evolution mensuelle du CA et de la fréquentation
function suivi_CA_mensuel(){
	$query = "SELECT DATE_CA, FREQUENTATION, CA_HT FROM SUIVI_CA_MENSUEL";
	$result = execute_query($query);
	if($result){
		if(mysqli_num_rows($result)>0){
			$row = array_result($result);
			$count=0;
			$i=0;
			$j=0;
			while($count<sizeof($row)){
				if($j<12){
					$annee[$i][]=$row[$count];
					$j++;
				}
				else {
					$i++;
					$j=0;
					$annee[$i][]=$row[$count];
				}
				$count++;
			}
		}
	}
	display_CA_mensuel_header();
	for($i=0;$i<sizeof($annee)-2;$i++){
		for($j=0;$j<12;$j++){
			$date = $annee[$i][$j]['DATE_CA'];
			$CA_N = $annee[$i][$j]['CA_HT'];
			$CA_N_1 = $annee[$i+1][$j]['CA_HT'];
			$frequentation_N = $annee[$i][$j]['FREQUENTATION'];
			$frequentation_N_1 = $annee[$i+1][$j]['FREQUENTATION'];
			display_CA_mensuel($date, $CA_N, $CA_N_1, $frequentation_N, $frequentation_N_1);
		}
	}
	display_CA_mensuel_footer();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////   End BSC functions      /////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



?>