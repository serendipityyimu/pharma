<?php

//Formatage d'une date J/M/AAAA en JJ/MM/AAAA 
function formatDate($date){
	if(strlen($date)<10){
		if(strlen($date<9))
			$result = "0". substr($date,0,2) . "0" . substr($date,2,strlen($date)-2);
	else
		$result = substr($date,0,3) . "0" . substr($date,3,strlen($date)-3);
	}
	else $result = $date;
	return $result;
}

//Formatage d'une date au format français AAAA/MM/JJ
function formatDateDB($date){
	return (substr($date,6,4) . "/" . substr($date,3,2) . "/" . substr($date,0,2));
}

//Formatage d'une date au format français JJ/MM/AAAA
function formatDateFR($date){
	return (substr($date,8,2) . "/" . substr($date,5,2) . "/" . substr($date,0,4));
}

//Renvoie le mois MM d'une date
function month($date){
	return substr($date,5,2);
}

function annee($date){
	return substr($date, 0, 4);
}
//Imprime le jour et le mois de la date en lettres
function formatDateText($date){
	return utf8_decode(strftime("%A %d %B %Y",strtotime($date)));
}

//Formattage du numéro de téléphone au format francais 00.00.00.00.00
function formatPhone($telephone){
	return (substr($telephone,0,2) . "." . substr($telephone,2,2) . "." . substr($telephone,4,2) . "." . substr($telephone,6,2) . "." . substr($telephone,8,2) . ".");
}

function formatMonthFR($month){
	switch($month){
		case 1:
			return "Janvier";
			break;
		case 2:
			return "Février";
			break;
		case 3:
			return "Mars";
			break;
		case 4:
			return "Avril";
			break;
		case 5:
			return "Mai";
			break;
		case 6:
			return "Juin";
			break;
		case 7:
			return "Juillet";
			break;
		case 8:
			return "Août";
			break;
		case 9:
			return "Septembre";
			break;
		case 10:
			return "Octobre";
			break;
		case 11:
			return "Novembre";
			break;
		case 12:
			return "Decembre";
			break;

	}
}

function formatMonthLetters($month) {
	$dateObj = DateTime::createFromFormat('!m', $month);
	return $dateObj->format('F');
}

function formatAmount($number) {
	return number_format($number, 2, ',', ' ');
}
?>