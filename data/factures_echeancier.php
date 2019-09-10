<?php

//***********liste_factures2.php**************

//Created by Philippe Nong
//Contact: philippe.nong@efc2-consulting.com
//Created: 28/03/2018
//Last modified: 28/03/2018

require_once("../includes/includes.php");

if ($_GET['dateType'] == 'dateEcheance') {
	$dateType = 'DATE_ECHEANCE';
}
else {
	$dateType = 'DATE_FACTURE';
}
$codeType = '';
$statut = '';
$modePaiement = '';
$date_debut = '';
$date_fin = '';

(isset($_GET['date_debut']) && $_GET['date_debut']<>'')?$date_debut=$_GET['date_debut']:$date_debut='01-' . date("m"). '-' . date("Y");
(isset($_GET['date_fin']) && $_GET['date_fin']<>'')?$date_fin = $_GET['date_fin']:$date_fin = date("t") . '-' . date("m") . '-' . date("Y");

if(!isset($_GET['sort']) || is_null($_GET['sort'])){
	$orderBy = 'FACTURES.' . $dateType . ', NOM_FOURNISSEUR';
}
else if ($_GET['sort'] == 'NOM_FOURNISSEUR') {
	$orderBy = "NOM_FOURNISSEUR, " . $dateType;
}
else if ($_GET['sort'] == 'DATE_ECHEANCE') {
	$orderBy = "DATE_ECHEANCE, NOM_FOURNISSEUR ";
}
else if ($_GET['sort'] == 'DATE_FACTURE') {
	$orderBy = "DATE_FACTURE, NOM_FOURNISSEUR ";
}
else if ($_GET['sort'] == 'CODE_TYPE') {
	$orderBy = "CODE_TYPE, NOM_FOURNISSEUR ";
}
else if ($_GET['sort'] == 'MONTANT_TTC') {
	$orderBy = "MONTANT_TTC, NOM_FOURNISSEUR ";
}
else if ($_GET['sort'] == 'CODE_STATUT') {
	$orderBy = "CODE_STATUT, NOM_FOURNISSEUR ";
}
else if ($_GET['sort'] == 'CODE_MODE_PAIEMENT') {
	$orderBy = "CODE_MODE_PAIEMENT, NOM_FOURNISSEUR ";
}

$whereClause = ' AND ' . $dateType . ' >= STR_TO_DATE("' . $date_debut . '", "%d-%m-%Y") AND ' . $dateType . ' <= STR_TO_DATE("' . $date_fin . '", "%d-%m-%Y")' ;


(isset($_GET['codeType']) && $_GET['codeType']<>'' && $_GET['codeType']<>0)?($whereClause .= ' AND CODE_TYPE=' . $_GET['codeType'] AND $codeType = $_GET['codeType']):$codeType = 0;
/*if (isset($_GET['codeType']) && $_GET['codeType']<>'' && $_GET['codeType']<>0) {
	$whereClause .= ' AND CODE_TYPE=' . $_GET['codeType'];
	$codeType = $_GET['codeType'];
}
else $codeType = 0;*/

if (isset($_GET['statut']) && $_GET['statut']<>0) {
	$whereClause .= ' AND FACTURES.CODE_STATUT=' . $_GET['statut'];
	$statut = $_GET['statut'];
}
else if (isset($_GET['statut']) && $_GET['statut']== 0){
	$statut = 0;
}
else {
	$statut = 2;
	$whereClause .= ' AND FACTURES.CODE_STATUT=2';	
}
(isset($_GET['modePaiement']) && $_GET['modePaiement']<>0)?($whereClause .= ' AND CODE_MODE_PAIEMENT=' . $_GET['modePaiement'] AND $modePaiement = $_GET['modePaiement']):$modePaiement = 0;
/*if (isset($_GET['modePaiement']) && $_GET['modePaiement']<>0) {
	$whereClause .= ' AND CODE_MODE_PAIEMENT=' . $_GET['modePaiement'];
	$modePaiement = $_GET['modePaiement'];
}
else $modePaiement = 0;*/


$query = "SELECT NOM_FOURNISSEUR, DATE_FORMAT(DATE_FACTURE, '%d/%m/%Y') AS DATE_FACTURE, CODE_TYPE, DESC_NATURE, DATE_FORMAT(DATE_ECHEANCE, '%d/%m/%Y') AS DATE_ECHEANCE, MONTANT_TTC, FACTURES.CODE_STATUT AS CODE_STATUT, DESC_STATUT, CODE_MODE_PAIEMENT, DESC_PAIEMENT, SUBSTRING(COMMENTAIRES, 1, 20) AS COMMENTAIRES, ID_FACTURE 
FROM FACTURES, FOURNISSEURS, MODE_PAIEMENT, STATUT_FACTURE, NATURE_FACTURE WHERE FACTURES.ID_FOURNISSEUR = FOURNISSEURS.ID_FOURNISSEUR AND CODE_MODE_PAIEMENT=CODE_PAIEMENT AND CODE_TYPE=CODE_NATURE AND FACTURES.CODE_STATUT=STATUT_FACTURE.CODE_STATUT " . $whereClause . " ORDER BY " . $orderBy . " ASC";

$result = execute_query($query);

$data[0]['dateType'] = $_GET['dateType'];
$data[0]['codeType'] = $codeType;
$data[0]['statut'] = $statut;
$data[0]['modePaiement'] = $modePaiement;
$data[0]['codeType'] = $codeType;
$data[0]['date_debut'] = $date_debut;
$data[0]['date_fin'] = $date_fin;
$data[0]['sort'] = $orderBy;

$data[1] = array_result_no_null($result);
echo json_encode($data);


?>