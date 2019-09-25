<?php
//***********liste_laboratoire.php**************

//Created by Philippe Nong
//Contact: philippe.nong@efc2-consulting.com
//Created: 15/11/2017
//Last modified: 21/11/2017
// 21/11/17: Ajout de l'échéance pour mettre à jour automatiquement la date d'échéance lors de la saisie d'une nouvelle facture
//WHERE (ID_CATEGORIE=1001 OR ID_CATEGORIE=1002)
require_once("../includes/includes.php");

	$query = "SELECT ID_FOURNISSEUR, NOM_FOURNISSEUR, ECHEANCE, MODE_REGLEMENT FROM FOURNISSEURS ORDER BY NOM_FOURNISSEUR ASC";
	$result = array_result(executeQuery($query));
	$results = array();

	// La boucle ci-dessous parcourt tout le tableau $data, jusqu'à un maximum de 10 résultats
	for ($i = 0 ; $i < sizeof($result); $i++) {
	  $results[] = array('id' => $result[$i]['ID_FOURNISSEUR'],
	  									'name' => $result[$i]['NOM_FOURNISSEUR'],
	  									'echeance' => $result[$i]['ECHEANCE'],
	  									'mode_reglement' => $result[$i]['MODE_REGLEMENT']);
	}
	echo json_encode($results);
?>
