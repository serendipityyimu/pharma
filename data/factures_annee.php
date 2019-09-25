<?php

//***********factures_annees.php**************

//Created by Philippe Nong
//Contact: philippe.nong@efc2-consulting.com
//Created: 26/12/2017
//Last modified: 27/03/2018
//Annee et dateType sont intégrées dans le résultat json

/*
Pour chaque mois de l'annee selectionnee, on cree un tableau avec tous les types de statuts des factures
SELECT DESC_STATUT, CODE_STATUT, CIVIL_YEAR, MONTH, FULL_DATE FROM STATUT_FACTURE, REF_DATE WHERE CIVIL_YEAR=$annee

*/

require_once("../includes/includes.php");
$annee = $_GET['year'];
if ($_GET['dateType'] == 'dateEcheance') {
	$dateType = 'DATE_ECHEANCE';
}
else {
	$dateType = 'DATE_FACTURE';
}

$query = "SELECT S.DESC_STATUT, S.CODE_STATUT, S.CIVIL_YEAR AS YEAR, S.MONTH, SUM(MONTANT_TTC) AS TOTAL_TTC FROM (SELECT DESC_STATUT, CODE_STATUT, CIVIL_YEAR, MONTH, FULL_DATE FROM STATUT_FACTURE, REF_DATE WHERE CIVIL_YEAR=" . $annee . ") S
LEFT JOIN (SELECT DATE_ECHEANCE, CODE_STATUT, MONTANT_TTC FROM FACTURES WHERE  YEAR(DATE_ECHEANCE)=" . $annee . ")  F ON S.CIVIL_YEAR = YEAR(F.DATE_ECHEANCE) AND S.MONTH = MONTH(F.DATE_ECHEANCE) AND S.CODE_STATUT = F.CODE_STATUT GROUP BY S.FULL_DATE, S.DESC_STATUT ORDER BY S.CODE_STATUT, MONTH ASC";
$result = executeQuery($query);
$data[0]['YEAR'] = intval($annee);
$data[0]['DATETYPE'] = $_GET['dateType'];

$data[1] = array_result_no_null($result);

echo json_encode($data);


?>
