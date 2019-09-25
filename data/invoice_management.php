<?php
require_once("../includes/includes.php");

if(isset($_POST['QUERY_TYPE']) && $_POST['QUERY_TYPE']=='UPDATE') {
	console.log('update');
	$_POST['type']<>1?$montant_TTC=-$_POST['montant_TTC']:$montant_TTC=$_POST['montant_TTC'];
	update_invoice($_POST['id_facture'], $_POST['date_facture'], $_POST['date_echeance'], '', $montant_TTC, $_POST['etat'], $_POST['type'], $_POST['mode_paiement'], $_POST['comments']);
}

else if(isset($_POST['QUERY_TYPE']) && $_POST['QUERY_TYPE']=='DELETE') {
	delete_invoice($_POST['id_facture']);
}

else if(isset($_POST['QUERY_TYPE']) && $_POST['QUERY_TYPE']=='NEXT_STATUT') {
	$query = "UPDATE FACTURES SET CODE_STATUT=CODE_STATUT+1 WHERE ID_FACTURE=" . $_POST['id_facture'];
	$result = executeQuery($query);
}


else if (isset($_GET['ID_FACTURE'])) {
	$result = invoice_detail($_GET['ID_FACTURE']);
	$jsonData = ['LABORATOIRE' => $result['NOM_FOURNISSEUR'], 'ID_FOURNISSEUR' => $result['ID_FOURNISSEUR'], 'ID_FACTURE' => $result['ID_FACTURE'], 'MONTANT_TTC' => ($result['CODE_TYPE']<>1?-$result['MONTANT_TTC']:$result['MONTANT_TTC']), 'DATE_FACTURE' => $result['DATE_FACTURE'], 'DATE_ECHEANCE' => $result['DATE_ECHEANCE'], 'DATE_PAIEMENT' => $result['DATE_PAIEMENT'], 'CODE_STATUT' => $result['CODE_STATUT'], 'CODE_TYPE' => $result['CODE_TYPE'], 'CODE_MODE_PAIEMENT' => $result['CODE_PAIEMENT'], 'COMMENTAIRES' => $result['COMMENTAIRES'], 'QUERY_TYPE' => 'UPDATE', 'DATETYPE' => $_GET['DATETYPE'], 'FILTER_DATE_DEBUT' => $_GET['DATE_DEBUT'], 'FILTER_CODE_TYPE' => $_GET['CODE_TYPE'], 'FILTER_DATE_FIN' => $_GET['DATE_FIN'], 'FILTER_MODE_PAIEMENT' => $_GET['MODE_PAIEMENT'], 'FILTER_CODE_STATUT' => $_GET['CODE_STATUT']];
	echo json_encode($jsonData);
}

else if(isset($_POST['id_lab'])) {
	$result = insert_invoice($_POST['id_lab'], $_POST['date_facture'], $_POST['date_echeance'], $_POST['montant_TTC'], $_POST['etat'], $_POST['type'], $_POST['mode_paiement'], $_POST['comments']);
}

else {
	$jsonData = ['LABORATOIRE' => '', 'ID_FOURNISSEUR' => '', 'ID_FACTURE' => '', 'MONTANT_HT' => '', 'MONTANT_TTC' => '', 'TVA' => '', 'DATE_FACTURE' => '', 'DATE_ECHEANCE' => '', 'DATE_PAIEMENT' => '', 'CODE_STATUT' => '', 'CODE_TYPE' => '', 'CODE_MODE_PAIEMENT' => '', 'COMMENTAIRES' => '', 'QUERY_TYPE' => ''];
	echo json_encode($jsonData);
}

//Création d'une nouvelle facture
function insert_invoice($id_fournisseur, $date_facture, $date_echeance, $montant_TTC, $statut, $type, $mode_paiement, $comments){
	($montant_TTC =='')?$montant_TTC=0:$montant_TTC;
	if ($type <>1) {
		$montant_TTC = -$montant_TTC;
	}
	$comments = addslashes($comments);
	$query = "INSERT INTO FACTURES (ID_FOURNISSEUR, DATE_FACTURE, DATE_ECHEANCE, MONTANT_TTC, CODE_STATUT, CODE_TYPE, CODE_MODE_PAIEMENT, COMMENTAIRES) VALUES
	($id_fournisseur, STR_TO_DATE('$date_facture', '%Y-%m-%d'), STR_TO_DATE('$date_echeance', '%Y-%m-%d'), $montant_TTC, $statut, $type, $mode_paiement, '$comments')";
	$result = executeQuery($query);
}

//Suppression d'une facture
function delete_invoice($id_facture){
	$query = "DELETE FROM FACTURES WHERE ID_FACTURE=" . $id_facture;
	$result = executeQuery($query);
}

//Function to display the detailed informations of an invoice
function invoice_detail($id_facture){
	$query = "SELECT ID_FACTURE, FO.NOM_FOURNISSEUR AS NOM_FOURNISSEUR, MONTANT_TTC, DATE_FORMAT(DATE_FACTURE, '%Y-%m-%d') AS DATE_FACTURE, DATE_FORMAT(DATE_ECHEANCE, '%Y-%m-%d') AS DATE_ECHEANCE, DATE_FORMAT(DATE_PAIEMENT, '%d/%m/%Y') AS DATE_PAIEMENT, F.CODE_STATUT AS CODE_STATUT, DESC_STATUT, F.CODE_TYPE AS CODE_TYPE, DESC_NATURE, F.CODE_MODE_PAIEMENT AS CODE_PAIEMENT, DESC_PAIEMENT, COMMENTAIRES,  F.ID_FOURNISSEUR AS ID_FOURNISSEUR	FROM FACTURES F, FOURNISSEURS FO, STATUT_FACTURE SF, MODE_PAIEMENT MP, NATURE_FACTURE NF WHERE ID_FACTURE=" . $id_facture . " 	AND F.ID_FOURNISSEUR=FO.ID_FOURNISSEUR AND F.CODE_STATUT = SF.CODE_STATUT	AND F.CODE_MODE_PAIEMENT = MP.CODE_PAIEMENT	AND F.CODE_TYPE = NF.CODE_NATURE";
	$result = executeQuery($query);
	if($result){
		return $result->fetch(PDO::FETCH_ASSOC);
	}
	else return 0;
}

function update_invoice($id_facture, $date_facture, $date_echeance, $date_reglement, $montant_ttc, $statut, $nature, $mode_paiement, $commentaires){
	console.log("fonction update_invoice");
	$query = "UPDATE FACTURES SET MONTANT_TTC='" . $montant_ttc . "', CODE_STATUT='" . $statut . "', CODE_TYPE='" . $nature . "', CODE_MODE_PAIEMENT='" . $mode_paiement . "', COMMENTAIRES='" . addslashes($commentaires) . "'";
	if ($date_facture) {
		$query .= ", DATE_FACTURE='" . formatDateDB($date_facture) . "'";
	}
	if ($date_echeance) {
		$query .= ", DATE_ECHEANCE='" . formatDateDB($date_echeance) . "'";
	}
	if ($date_reglement) {
		$query .= ", DATE_PAIEMENT='" . formatDateDB($date_reglement) . "'";
	}
	$query .= " WHERE ID_FACTURE=" . $id_facture;
	$result = executeQuery($query);
}

//Recupere la liste des factures selectionnees pour le regroupement
/*function liste_factures($listIdFactures){
	$query = "SELECT ID_FACTURE, FACTURES.ID_FOURNISSEUR AS ID_FOURNISSEUR, NOM_FOURNISSEUR, MONTANT_TTC, DATE_FACTURE, DATE_ECHEANCE, CODE_STATUT, CODE_TYPE, CODE_MODE_PAIEMENT FROM FACTURES, FOURNISSEURS WHERE ID_FACTURE IN (" . $listIdFactures . ") AND FACTURES.ID_FOURNISSEUR = FOURNISSEURS.ID_FOURNISSEUR";
	$result = execute_query($query);
	if ($result) {
		return array_result($result);
	}
}*/

/*else if (isset($_POST['groupFactures'])) {
	$listIdFactures = implode(", ",json_decode($_POST['groupFactures']));
	$listeFactures = liste_factures($listIdFactures);
	for ($i=0; $i < sizeof($listeFactures); $i++) {
		$array[] = array(
		"ID_FACTURE" => $listeFactures[$i]['ID_FACTURE'],
		"ID_FOURNISSEUR" => $listeFactures[$i]['ID_FOURNISSEUR'],
		"NOM_FOURNISSEUR" => $listeFactures[$i]['NOM_FOURNISSEUR'],
		"MONTANT_TTC" => $listeFactures[$i]['MONTANT_TTC'],
		"DATE_FACTURE" => $listeFactures[$i]['DATE_FACTURE'],
		"DATE_ECHEANCE" => $listeFactures[$i]['DATE_ECHEANCE'],
		"CODE_STATUT" => $listeFactures[$i]['CODE_STATUT'],
		"CODE_TYPE" => $listeFactures[$i]['CODE_TYPE'],
		"CODE_MODE_PAIEMENT" => $listeFactures[$i]['CODE_MODE_PAIEMENT']
		);
		// echo $listeFactures[$i]['NOM_FOURNISSEUR'];
	}
	echo json_encode($array);
}*/

// else if (isset($_GET['id_facture_group'])){
// 	// echo json_encode($_POST['date_echeance_group']);
// 	// echo "inside";
// 	 $id_group_invoice = insert_group_invoice($_GET['date_facture_group'], $_GET['date_echeance_group'], $_GET['montant_TTC_group'], $_GET['etat_group'], $_GET['mode_reglement_group'], $_GET['type_group'], $_GET['id_facture_group']);
// 	 // echo json_encode($id_group_invoice);

// }
?>
