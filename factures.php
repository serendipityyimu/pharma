<?php
//***********factures.php**************
//Created by Philippe Nong
//Contact: philippe.nong@efc2-consulting.com
//Created: 30/01/2018
//Last modified: 30/01/2018

require_once("includes/includes.php");
head('Gestion d\'entreprise');

if(isset($_GET['display']) && $_GET['display'] == 'new') {
	$html = "<script>\$factures.management.newInvoice();</script>";
}
else if(isset($_GET['display']) && $_GET['display'] == 'facture') {
	$html = "<script>\$factures.display.displayInvoice('dateFacture');</script>";
}
else {
	$html = "<script>\$factures.display.displayInvoice('dateEcheance');</script>";
}
footer($html);
?>