<?php $title= 'Pharmacie Nong'; ?>
<?php ob_start(); ?>
<div class="main-title">Nouvelle facture</div>
<form method="post" id="newInvoiceForm">
  <div class="container form-group">
    <div class="form-group row">
      <label for="laboratoire" class="col-sm-2 col-form-label">Laboratoire: </label>
      <div class="col-sm-5">
        <input type="text" autocomplete="off" id="laboratoire" name="laboratoire" class="dropdown input-group form-control" data-index="1">
        <input type="hidden" id="id_lab" name="id_lab">
        <input type="hidden" id="id_facture" name="id_facture" >
        <input type="hidden" id="query_type" name="QUERY_TYPE" >
        <input type="hidden" id="filter_date_debut" name="FILTER_DATE_DEBUT" >
        <input type="hidden" id="filter_date_fin" name="FILTER_DATE_FIN" >
        <input type="hidden" id="filter_code_type" name="FILTER_CODE_TYPE" >
        <input type="hidden" id="filter_mode_paiement" name="FILTER_MODE_PAIEMENT" >
        <input type="hidden" id="filter_code_statut" name="FILTER_CODE_STATUT" >
        <!-- <div id="results" class="dropdown-menu"></div> -->
      </div>
    </div>
    <div class="form-group row">
      <label for="montant_TTC" class="col-sm-2 col-form-label">Montant TTC: </label>
      <div class="col-sm-5"><input class="form-control" id="montant_TTC" name="montant_TTC" type="number" step=0.01 data-index="2" autocomplete="off"></div>
    </div>
    <div class="form-group row">
      <label for="date_facture" class="col-sm-2 col-form-label">Date de facture: </label>
      <div class="col-sm-5"><input class="form-control" id="date_facture" name="date_facture" type="date"  data-index="4" ></div>
    </div>
    <div class="form-group row">
      <label for="date_echeance" class="col-sm-2 col-form-label">Date d'échéance: </label>
      <div class="col-sm-5"><input class="form-control" id="date_echeance" name="date_echeance" type="date" data-index="5" ></div>
    </div>
    <div class="form-group row">
      <label for="etat" class="col-sm-2 col-form-label">Etat: </label>
      <div class="col-sm-5">
        <select class="form-control" id="etat" name="etat" data-index="6">
          <option value=1>Saisie</option>
          <option value=2 selected>Validée</option>
          <option value=3>Réglée</option>
          <option value=4>Réclamation</option>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="type" class="col-sm-2 col-form-label">Type: </label>
      <div class="col-sm-5">
        <select class="form-control" id="type" name="type" data-index="7">
          <option value=1>Facture</option>
          <option value=2>Avoir</option>
          <option value=3>RFA</option>
          <option value=4>Prestation</option>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="mode_paiement" class="col-sm-2 col-form-label">Mode de règlement: </label>
      <div class="col-sm-5">
        <select class="form-control" id="mode_paiement" name="mode_paiement" data-index="8">
          <option value=1>LCR</option>
          <option value=2>Chèque</option>
          <option value=3>Prélèvement</option>
          <option value=4>Virement</option>
          <option value=5>CB</option>
          <option value=6>Espèces</option>
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="comments" class="col-sm-2 col-form-label">Commentaires: </label>
      <div class="col-sm-5"><textarea class="form-control" id="comments" name="comments" type="text"></textarea></div>
    </div>
    <div class="form-group row">
      <div class="col-sm-7 text-center">
        <input type="button" class="btn btn-primary" onclick="location.href='factures.php?display=dateEcheance';" value="Retour"> <button class="btn btn-primary" name="valider">Valider</button>
      </div>
    </div>
  </div>
</form>
<script type="text/javascript" src="js/custom/liste_dynamique.js"></script>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
