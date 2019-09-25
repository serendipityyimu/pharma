<?php $title = 'Pharmacie Nong'; ?>
<?php ob_start(); ?>

<div class="row justify-content-start align-items-center no-gutters text-center container" id="filter">
  <div class="col-xl">
    <label>Date</label><br>
    <select id="type_date" name="type_date">
      <option value="dateEcheance">Date d'échéance</option>
      <option value="dateFacture">Date de facture</option>
    </select>
  </div>
  <div class="col-xl">
    <label>Du </label><br>
    <input id="date_debut" name="date_debut" type="date"  size=10 >
  </div>
  <div class="col-xl">
    <label>Au </label><br>
    <input id="date_fin" name="date_fin" type="date" size=10 >
  </div>
  <div class="col-xl">
    <label>Type</label><br>
    <select id="type" name="type">
      <option value=0>Tous</option>
      <option value=1>Facture</option>
      <option value=2>Avoir</option>
      <option value=3>RFA</option>
      <option value=4>Prestation</option>
    </select>
  </div>
  <div class="col-xl">
    <label>Statut</label><br>
    <select id="etat" name="etat">
      <option value=0>Tous</option>
      <option value=1>Saisie</option>
      <option value=2>Validée</option>
      <option value=3>Réglée</option>
      <option value=4>Réclamation</option>
    </select>
  </div>

  <div class="col-xl-2">
    <label>Type de règlement</label><br>
      <select id="mode_paiement" name="mode_paiement">
        <option value=0>Tous</option>
        <option value=1>LCR</option>
        <option value=2>Chèque</option>
        <option value=3>Prélèvement</option>
        <option value=4>Virement</option>
        <option value=5>CB</option>
        <option value=6>Espèces</option>
      </select>
  </div>
  <div class="col-xl">
    <label>Sous-total</label><br>
    <div id="sous_total" readonly> 0.00 €</div>
  </div>
  <div class="col-xl">
    <button id="grouper">Valider/Regler</button>
  </div>
  <div class="col-xl">
  </div>

</div>

<div>
  <table id="echeancier" class="table table-bordered table-hover table-sm">
    <tr class="thead-dark">
      <th width="3%">Grouper</th>
      <th width="11%">Date échéance<img id="sort_payment_date" src="./images/ico_sort_asc.png" width="15" height="15"></th>
      <th width="18%">Fournisseur<img id="sort_lab" src="./images/ico_sort_asc.png" width="15" height="15"></th>
      <th width="11%">Date facture<img id="sort_invoice_date" src="./images/ico_sort_asc.png" width="15" height="15"></th>
      <th width="8%">Type<img id="sort_type" src="./images/ico_sort_asc.png" width="15" height="15"></th>
      <th width="10%">Montant<img id="sort_amount" src="./images/ico_sort_asc.png" width="15" height="15"></th>
      <th width="8%">Statut<img id="sort_status" src="./images/ico_sort_asc.png" width="15" height="15"></th>
      <th width="10%">Règlement<img id="sort_payment" src="./images/ico_sort_asc.png" width="15" height="15"></th>
      <th width="18%">Commentaires</th>
      <th width="3%">Val</th>
      <th width="3%">Sup</th>
    </tr>

    <?php
    while ($data = $posts->fetch()) {
    ?>
    <tr>
      <td>
        <input type="checkbox" id="sousTotalChkbx" name="sousTotalChkbx" onclick="addValue();" value=<?= $data['MONTANT_TTC']?>>
        <input type="hidden" class="idFacture" value=<?= $data['ID_FACTURE']?>>
      </td>
      <td class="dateEcheance"><?= $data['DATE_ECHEANCE']?></td>
      <td class="nomFournisseur" value=<?= $data['ID_FACTURE']?>> <a href="#" onclick=""><?= $data['NOM_FOURNISSEUR']?></a> </td>
      <td><?= $data['DATE_FACTURE']?></td>
      <td><?= $data['DESC_NATURE']?></td>
      <td align="right"><?= $data['MONTANT_TTC']?></td>
      <td><?= $data['DESC_STATUT']?></td>
      <td><?= $data['DESC_PAIEMENT']?></td>
      <td><?= $data['COMMENTAIRES']?></td>
      <td><a href="#" onclick=""><img src="public/image/ico_valider_15.png"></a></td>
      <td><a href="#" onclick=""><img src="public/image/ico_supprimer_15.png"></a></td>
    </tr>
    <?php
    }
    $posts->closeCursor();
    ?>
  </table>
</div>
<script type="text/javascript" src="js/custom/liste_dynamique.js"></script>
<!-- <script type="text/javascript" src="js/custom/events_js.js"></script> -->


<?php $content = ob_get_clean(); ?>
  <?php require('view/template.php') ?>
