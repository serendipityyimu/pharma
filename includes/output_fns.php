<?php

//***********output_fns.php**************
//Created by Philippe Nong
//Contact: philippe.nong@efc2-consulting.com
//Created: 21/07/2017
//Last modified: 13/11/2017 : Reformatage avec Bootstrap

//Display Header
function head($title){
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php echo $title;?></title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="jquery/jquery-ui.min.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/MonthPicker.min.css">
		<link href="https://fonts.googleapis.com/css?family=Lora|Oxygen" rel="stylesheet">

	</head>
	<body>
		<nav id="header-nav" class="navbar navbar-expand-md">
			<div class='container'>
				<a href="factures.php?display=dateEcheance" class="navbar-brand">Home</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsable-nav" aria-controls="collapsable-nav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div id="collapsable-nav" class="collapse navbar-collapse">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="revenuDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Revenus</a>
								<div class="dropdown-menu" aria-labelledby="revenuDropdown">
									<a class="dropdown-item" id="CaTvaDisplay" href="revenus.php">CA par taux de TVA</a>
									<a class="dropdown-item" href="revenus.php?display=new">Saisie CA par taux de TVA</a>
								</div>
						</li>
						<li class="nav-item"><a class="nav-link" href="factures.php?display=new">Nouvelle facture</a></li>
						<li class="nav-item"><a class="nav-link" href="factures.php?display=dateEcheance">Echeancier</a></li>

<!-- 						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="invoiceDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Factures</a>
								<div class="dropdown-menu" aria-labelledby="invoiceDropdown">
									<a class="dropdown-item" href="factures.php?display=new">Nouvelle facture</a>
									<a class="dropdown-item" href="factures.php?display=dateEcheance">Suivi factures (par date d'échéance)</a>
									<a class="dropdown-item" href="echeancier.php">Echéancier</a>
								</div>
						</li> -->
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="personnelDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Personnel</a>
								<div class="dropdown-menu" aria-labelledby="personnelDropdown">
									<a class="dropdown-item" href="salary.php?display=new">Saisie des salaires</a>
									<a class="dropdown-item" href="salary.php">Récapitulatif masse salariale</a>
									<a class="dropdown-item" href="salary.php?display=list">Gestion des salariés</a>
								</div>
						</li>
						<li class="nav-item"><a class="nav-link" href="financement.php">Financement</a></li>
						<li class="nav-item dropdown">
							 <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="#" onclick="js.loadDisplayMainContent('snippets/synthese-CA-snippet.php', 'js/javascript.js');">Synthèse</a>
								<a class="dropdown-item" href="tresorerie.php">Trésorerie</a>
								<a class="dropdown-item" href="compte_resultat.php">Comptes de résultats</a>
								<a class="dropdown-item" href="plan_financement.php">Plan de financement</a>
								<a class="dropdown-item" href="bilan.php">Bilan</a>
							</div>
						</li>
					</ul>
				</div> <!-- collapsable-nav -->
			</div> <!-- container -->
		</nav>
		<div class="container" id="main-content"> </div>
<?php
}

//Display Footer
function footer($html){

?>
	<footer>
 		<script src="jquery/jquery.min.js"></script>
		<script src="jquery/jquery-ui.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/custom/javascript.js"> </script>
		<script src="js/custom/factures.js"> </script>
		<?php
			echo $html;
		?>
		<!-- <script src="js/custom/revenus.js"> </script> -->
		<script src="js/datepicker-fr.js"> </script>
		<script type="text/javascript" src="js/custom/liste_dynamique.js"></script>
		<!-- <script type="text/javascript" src="js/custom/events_js.js"></script> -->
		<!-- <script type="text/javascript" src="js/custom/dates_js.js"></script> -->


 <!--       <script src="js/revenus.js"> </script>
       <script src="js/salary.js"> </script>
		<script src="js/custom/events_js.js"> </script>
	   	<script src="js/MonthPicker.min.js"> </script>
	   	<script src="js/jquery.maskedinput.min.js"> </script>
	   	 -->

	</footer>
	</body>
</html>
<?php
}

//***************************************************************************************************//
//*********************************** Evolution du CA: suivi_CA.php *********************************//
//***************************************************************************************************//

function display_suivi_CA_head(){
?>
<!-- 	<div class="container"> -->
		<div class='main-title'>Evolution du Chiffre d'affaire</div>
		<div class='table_CA_row'>Mettre les deux boutons année civile et année comptable</div>
		<table class="table table-responsive-lg table-striped table-bordered table-hover table-sm">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Période</th>
					<th scope="col">CA HT N</th>
					<th scope="col">CA HT N-1</th>
					<th scope="col">% Evol</th>
					<th scope="col">Nb Clients N</th>
					<th scope="col">Nb Clients N-1</th>
					<th scope="col">% Evol</th>
				</tr>
			</thead>
			<tbody>

<?php
}

function display_table_suivi_CA($suivi_CA_detail,$annee_date_debut, $date_debut, $date_fin, $CAHT_N, $CAHT_N_1, $evol_CA, $frequentation_N, $frequentation_N_1, $evol_frequentation){
?>
			<tr class="CA_TVA_year">
				<td><a id="<?php echo $annee_date_debut;?>">Du <?php echo $date_debut;?> au <?php echo $date_fin;?></a></td>
				<td><?php echo  $CAHT_N . ' €';?></td>
				<td><?php echo $CAHT_N_1=='N/A'?'N/A':$CAHT_N_1 . ' €';?></td>
				<td><?php echo ($evol_CA=='N/A')?'N/A':$evol_CA . ' %';?></td>
				<td><?php echo $frequentation_N=='N/A'?'N/A':$frequentation_N;?></td>
				<td><?php echo $frequentation_N_1=='N/A'?'N/A':$frequentation_N_1;?></td>
				<td><?php echo ($evol_frequentation=='N/A')? 'N/A': $evol_frequentation . ' %';?></td>
			</tr>
<?php
}

function display_CA_detail($CA_detail_N,$suivi_CA_detail){
?>
			<tr id='<?php echo $suivi_CA_detail;?>'>
				<td colspan="7">
					<table class="table table-inverse">
<?php
		for($i=0;$i<sizeof($CA_detail_N);$i++){
?>
						<tr class='table_CA_row'>
							<td ><?php echo $CA_detail_N[$i]['MONTH'];?></td>
							<td><?php echo $CA_detail_N[$i]['CAHT_N'];?></td>
							<td><?php echo $CA_detail_N[$i]['CAHT_N_1'];?></td>
							<td><?php echo $CA_detail_N[$i]['EVOL_CAHT'];?></td>
							<td><?php echo $CA_detail_N[$i]['FREQUENTATION_N'];?></td>
							<td><?php echo $CA_detail_N[$i]['FREQUENTATION_N_1'];?></td>
							<td><?php echo $CA_detail_N[$i]['EVOL_FREQUENTATION'];?></td>
						</tr>
<?php
		}
?>
					</table>
				</td>
			</tr>
<?php
}

function display_suivi_CA_footer () {
?>
			</tbody>
		</table>
	<!-- </div> -->
<?php
}
//***************************************************************************************************//
//************************ Fin evolution du CA: suivi_CA.php: suivi_CA.php **************************//
//***************************************************************************************************//

//***************************************************************************************************//
//******************* Saisie du chiffre d'affaires par taux de TVA: insert_CA_TVA.php ***************//
//***************************************************************************************************//

function display_input_CA_TVA($date_CA_TVA, $CA_HT_TVA_210, $CA_HT_TVA_550, $CA_HT_TVA_10, $CA_HT_TVA_20, $frequentation){
	if($date_CA_TVA=='') {
		$date_CA_TVA = input_date_CA_TVA();
	}
	$dateObj   = DateTime::createFromFormat('!m', $date_CA_TVA['MONTH']);
	$monthName = $dateObj->format('F');
?>
	<!-- <div class="container"> -->
	<div class='main-title'>Chiffre d'affaire mensuel par taux de TVA</div>
	<form method='post' action='<?php echo $_SERVER['PHP_SELF'];?>'>
		<input type='hidden' name='month_CA_TVA' value='<?php echo $date_CA_TVA['MONTH'];?>'>
		<input type='hidden' name='year_CA_TVA' value='<?php echo $date_CA_TVA['YEAR'];?>'>
		<table class="table table-responsive-lg table-bordered table-sm">
			<thead>
				<tr><th colspan='2'><?php echo $monthName . " " . $date_CA_TVA['YEAR'];?></th></tr>
				<tr><th>CA HT</th><th>Montant HT</th></tr>
			</thead>
			<tbody>
				<tr><td>2.10%</td><td><input name='CA_HT_TVA_210' type='number' step='0.01' value=<?php echo $CA_HT_TVA_210;?>></td></tr>
				<tr><td>5.50%</td><td><input name='CA_HT_TVA_550' type='number' step='0.01' value=<?php echo $CA_HT_TVA_550;?>></td></tr>
				<tr><td>10.00%</td><td><input name='CA_HT_TVA_10' type='number' step='0.01' value=<?php echo $CA_HT_TVA_10;?>></td></tr>
				<tr><td>20.00%</td><td><input name='CA_HT_TVA_20' type='number' step='0.01' value=<?php echo $CA_HT_TVA_20;?>></td></tr>
				<tr><td>Fréquentation</td><td><input name='FREQUENTATION' type='number' step='0' value=<?php echo $frequentation;?>></td></tr>
				<tr><td><a href="#" class='button' onclick="js.loadDisplayMainContent('snippets/CA-TVA-snippet.php', 'js/form_events.js');"><input type='button' value='Retour'></a></td><td><input type='submit' name='submit' value='Valider'></td></tr>
			</tbody>
		</table>
	</form>
	<!-- </div> -->

<?php
}
//***************************************************************************************************//
//*************** Fin saisie du chiffre d'affaires par taux de TVA: insert_CA_TVA.php ***************//
//***************************************************************************************************//



//***************************************************************************************************//
//***************************** Liste des factures: display_invoice.php *****************************//
//***************************************************************************************************//
function display_invoice_head(){
?>
			<table class="table table-responsive-lg table-striped table-bordered table-hover table-sm">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Date d échéance</th>
						<th scope="col">Fournisseur</th>
						<th scope="col">Montant TTC</th>
						<th scope="col">Date de facture</th>
						<th scope="col">Commentaires</th>
						<th colspan=3></tr>
					</tr>
				</thead>
				<tbody>
<?php
}

function display_invoice($invoice){
?>
	<!-- <div class="container"> -->
		<div class='main-title'>Liste des factures</div>
<?php
	display_invoice_head();
	for($i=0;$i<sizeof($invoice);$i++){
?>
					<tr>
						<td><?php echo $invoice[$i]['DATE_ECHEANCE'];?></td>
						<td><a href='#' onclick="js.loadDisplayMainContent('snippets/display_invoice_detail-snippet.php?id_facture=<?php echo $invoice[$i]['ID_FACTURE'];?>', 'js/form_events.js');"><?php echo $invoice[$i]['NOM_FOURNISSEUR'];?></a></td>
						<td><?php echo $invoice[$i]['MONTANT_TTC'];?> €</td>
						<td><?php echo $invoice[$i]['DATE_FACTURE'];?></td>
						<td><textarea></textarea></td>
						<td><input name='total_facture' type='checkbox' onclick='somme()' value=" . $montant . "></td>
						<td><?php echo display_button($_SERVER['PHP_SELF'] . "?id_facture=" . $invoice[$i]['ID_FACTURE'] . "&code_statut=" . $invoice[$i]['CODE_STATUT'], "ico_valider.png", "Valider");?></td>
						<td><?php echo display_button($_SERVER['PHP_SELF'], "ico_modifier.png", "Modifier");?>
					</tr>
<?php
	}
?>
				</tbody>
			</table>
		<!-- </div>		 -->
<?php
}

function display_invoice_detail($id_facture){
	$invoice = invoice_detail($id_facture);
?>
<form id="updateInvoiceForm" method="post">
<input type="hidden" name="id_facture" id="id_facture" value="<?php echo $id_facture;?>">
<table class='liste'>
<tr><td>Fournisseur</td><td><input type="text" id="id_fournisseur" name="id_fournisseur" value="<?php echo $invoice['NOM_FOURNISSEUR'];?>" disabled="disabled"><td></td</tr>
<tr><td>Montant HT</td><td><input type="text" id="montant_HT" name="montant_HT" value=<?php echo $invoice['MONTANT_HT'];?>></td></tr>
<tr><td>TVA</td><td><input type="text" id="TVA" name="TVA" value=<?php echo $invoice['TVA'];?>></td></tr>

<tr><td>Date de facture</td><td><input type="text" id="date_facture" name="date_facture" class="datepicker" readonly value=<?php echo $invoice['DATE_FACTURE'];?> ></td></tr>
<tr><td>Date d'échéance</td><td><input type="text" id="date_echeance" name="date_echeance" class="datepicker" readonly value=<?php echo $invoice['DATE_ECHEANCE'];?> ></td></tr>
<tr><td>Date de règlement</td><td><input type="text" id="date_reglement" name="date_reglement" class="datepicker" readonly value=<?php echo $invoice['DATE_PAIEMENT'];?> ></td></tr>
<tr><td>Statut</td><td><select id="statut" name="statut">
							<option value="1" <?php echo $invoice['CODE_STATUT']==1?'selected':'';?>>Saisie</option>
							<option value="2" <?php echo $invoice['CODE_STATUT']==2?'selected':'';?>>Validée</option>
							<option value="3" <?php echo $invoice['CODE_STATUT']==3?'selected':'';?>>Validée</option>
							<option value="4" <?php echo $invoice['CODE_STATUT']==4?'selected':'';?>>Réclamation</option>
							<option value="5" <?php echo $invoice['CODE_STATUT']==5?'selected':'';?>>Annulée</option>
						</select>
</td></tr>
<tr><td>Nature</td><td>
<select id="nature" name="nature">
							<option value="1" <?php echo $invoice['CODE_TYPE']==1?'selected':'';?>>Facture</option>
							<option value="2" <?php echo $invoice['CODE_TYPE']==2?'selected':'';?>>Avoir</option>
							<option value="3" <?php echo $invoice['CODE_TYPE']==3?'selected':'';?>>RFA</option>
							<option value="4" <?php echo $invoice['CODE_TYPE']==4?'selected':'';?>>Prestation</option>
						</select>
</td></tr>
<tr><td>Mode de règlement</td><td>
<select id="mode_paiement" name="mode_paiement">
							<option value="1" <?php echo $invoice['CODE_PAIEMENT']==1?'selected':'';?>>LCR</option>
							<option value="2" <?php echo $invoice['CODE_PAIEMENT']==2?'selected':'';?>>Chèque</option>
							<option value="3" <?php echo $invoice['CODE_PAIEMENT']==3?'selected':'';?>>Prélèvement</option>
							<option value="4" <?php echo $invoice['CODE_PAIEMENT']==4?'selected':'';?>>Virement</option>
							<option value="5" <?php echo $invoice['CODE_PAIEMENT']==3?'selected':'';?>>CB</option>
							<option value="6" <?php echo $invoice['CODE_PAIEMENT']==4?'selected':'';?>>Espèce</option>
						</select></td></tr>
<tr><td>Commentaires</td><td><input type="text" id="commentaires" name="commentaires" value=<?php echo $invoice['COMMENTAIRES'];?>></td></tr>
<tr><td colspan=2 align=center><button class="btn btn-primary" name="maj">Mettre à jour</button></td></tr>
</table>
</form>
<?php
/*			echo "<table class='liste'>\n<tr><td>Date de facture</td>\n<th>Fournisseur</th>\n<th>Montant TTC</th>\n
		<th>Date d'échéance</th>\n<th>Commentaire</th><th>Somme</th><th colspan=2></tr>\n";
*/
}

//***************************************************************************************************//
//************************** Fin liste des factures: display_invoice.php ****************************//
//***************************************************************************************************//

//***************************************************************************************************//
//********************************* Nouvelle facture: new_invoice.php *******************************//
//***************************************************************************************************//
function display_liste_categories($categories){
?>
	<ul>
<?php
	for($i=0;$i<sizeof($categories);$i++){
		echo "<li>" . $categories[$i]['DESC_CAT2'] . "</li>\n";
	}
?>
	</ul>
<?php
}

function display_liste_fournisseur($fournisseurs){
?>
	<ul>
<?php
		for($i=0;$i<sizeof($fournisseurs);$i++){
		echo "<li  value='". $fournisseurs[$i]["ID_FOURNISSEUR"] . "'>" . $fournisseurs[$i]['NOM_FOURNISSEUR'] . "</li>\n";
	}
?>
	</ul>
<?php
}

function display_button($target, $image, $alt){
	echo "<center><a href=\"$target\"><img src=\"images/$image"."\" alt=\"$alt\" border=0 height = 30 width = 30></a></center>";
}
//***************************************************************************************************//
//******************************** Fin Nouvelle facture: new_invoice.php ****************************//
//***************************************************************************************************//


?>
