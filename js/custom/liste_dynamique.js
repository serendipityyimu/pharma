/***************************************************************************************************************************
****************************************************************************************************************************
***************************************** Moteur de recherche fournisseur **************************************************
****************************************************************************************************************************
****************************************************************************************************************************/

$(function() {
  var listeFournisseurs = './data/liste_fournisseurs.php',
      arrayReturn = [];

  $.get({url: listeFournisseurs, success: function(data) {
    $.each(JSON.parse(data), function(key, value) {
      arrayReturn.push({'id': value.id, 'value': value.name, 'echeance': value.echeance, 'mode_reglement': value.mode_reglement});
    });
    loadSuggestions(arrayReturn);
  }});

  function loadSuggestions(options) {
    $('#laboratoire').autocomplete({
      source: options,
      select: function(event, ui) {
        $('#laboratoire').val(ui.item.value); // On change le contenu du champ de recherche et on enregistre en tant que précédente valeur
        $('#id_lab').val(ui.item.id);
        $("#mode_paiement option[value=" + ui.item.mode_reglement + "]").prop('selected', true);
        $('#laboratoire').attr('data-echeance', ui.item.echeance);
         console.log($('#laboratoire').val());
      }
    });
  }
});
