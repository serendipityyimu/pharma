<?php
//***********liste_laboratoire.php**************

//Created by Philippe Nong
//Contact: philippe.nong@efc2-consulting.com
//Created: 15/11/2017
//Last modified: 21/11/2017
// 21/11/17: Ajout de l'échéance pour mettre à jour automatiquement la date d'échéance lors de la saisie d'une nouvelle facture
//WHERE (ID_CATEGORIE=1001 OR ID_CATEGORIE=1002)
require_once("./includes/includes.php");
$query = "SELECT ID_FOURNISSEUR, NOM_FOURNISSEUR, ECHEANCE, MODE_REGLEMENT FROM FOURNISSEURS ORDER BY NOM_FOURNISSEUR ASC";
// $query = "SELECT ID_FOURNISSEUR, NOM_FOURNISSEUR, ECHEANCE, MODE_REGLEMENT FROM FOURNISSEURS ORDER BY NOM_FOURNISSEUR ASC";

	$result = array_result(executeQuery($query));
	$dataLen = sizeof($result);
	$results = array();

	// La boucle ci-dessous parcourt tout le tableau $data, jusqu'à un maximum de 10 résultats
	for ($i = 0 ; $i < $dataLen; $i++) {
	     // if (stripos($result[$i]['NOM_FOURNISSEUR'], $_GET['s']) === 0) { // Si la valeur commence par les mêmes caractères que la recherche
	  $data['id'] = $result[$i]['ID_FOURNISSEUR'];
	  $data['name'] = $result[$i]['NOM_FOURNISSEUR'];
	  $data['echeance'] = $result[$i]['ECHEANCE'];
	  $data['mode_reglement'] = $result[$i]['MODE_REGLEMENT'];
	array_push($results, $data);
	// $results[] = $result[$i]['NOM_FOURNISSEUR'];
	     // }
	}
echo json_encode($results);
?>
