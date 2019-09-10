<?php
//***********revenus.php**************
//Created by Philippe Nong
//Contact: philippe.nong@efc2-consulting.com
//Created: 04/12/2017
//Last modified: 04/12/2017

require_once("includes/includes.php");
head('Gestion d\'entreprise');
$html = "<script>\$revenus.management.newIncome();</script>";
// if(isset($_GET['display'])) {
// 	$html = "<script>\$revenus.insert.insertCaTva();</script>";
// }
footer($html);
?>