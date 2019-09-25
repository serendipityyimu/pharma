/***************************************************************************************************************************
****************************************************************************************************************************
***************************************** Moteur de recherche fournisseur **************************************************
****************************************************************************************************************************
****************************************************************************************************************************/

$(function() {
  var listeFournisseurs = './data/liste_fournisseurs.php',
      arrayReturn = [];
      var invoice = './data/invoice_management.php',
          newInvoiceGroupSnippet = './snippets/new-invoice-group-snippet.html',
          income = './data/income_management.php';

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
         // console.log($('#laboratoire').val());
      }
    });
  }

  $("#newInvoiceForm").submit(function(e) {
     e.preventDefault();
    $.post(invoice, $(this).serialize(),
      function(data){
        // $factures.display.displayInvoiceList('dateEcheance');
        $factures.management.newInvoice();
      },
      'html');
  });

  $('#date_facture').change(function(event, ui) {
    if ($('#laboratoire').val()) {
      var dateEcheance = new Date($('#date_facture').val());
      var echeance = parseInt($('#laboratoire').attr('data-echeance'),10);

      if (echeance < 100) {
        dateEcheance.setDate(dateEcheance.getDate() + echeance);
      } else if (echeance === 450) { //45 jours fin de mois
        dateEcheance.setDate(dateEcheance.getDate() + 45);
        dateEcheance = LastDayOfMonth(dateEcheance);
      } else if (echeance === 300) { //30 jours fin de mois
        dateEcheance.setDate(dateEcheance.getDate() + 30);
        dateEcheance = LastDayOfMonth(dateEcheance);
      } else if (echeance === 451) { //Fin de mois + 45 jours
        dateEcheance = LastDayOfNextMonth(dateEcheance);
        dateEcheance.setDate(dateEcheance.getDate() + 15);
      } else if (echeance === 315) { // 30 jours fin de quinzaine
        if (dateEcheance.getDate() > 15) {
          dateEcheance = LastDayOfNextMonth(dateEcheance);
        } else {
          dateEcheance = LastDayOfMonth(dateEcheance);
          dateEcheance.setDate(dateEcheance.getDate() + 15);
        }
      } else if (echeance ===550) { //55 jours fin de decade
        if (dateEcheance.getDate() > 20) {
          dateEcheance = LastDayOfNextMonth(dateEcheance);
          dateEcheance.setDate(dateEcheance.getDate() + 25);
        } else if (dateEcheance.getDate() > 10) {
          dateEcheance = LastDayOfNextMonth(dateEcheance);
          dateEcheance.setDate(dateEcheance.getDate() + 15);
        } else {
          dateEcheance = LastDayOfNextMonth(dateEcheance);
          dateEcheance.setDate(dateEcheance.getDate() + 5);
        }
      }
      $('#date_echeance').val(formatDate(dateEcheance));
    }
  });

});
function LastDayOfMonth(date) {
  return new Date(date.getFullYear(), date.getMonth()+1,0);
}

function LastDayOfNextMonth(date){
  return new Date(date.getFullYear(), date.getMonth()+2,0);
}

function formatDate(date) {
  var formattedDate = date.getFullYear() + '-';
  var month = date.getMonth() + 1;
  if(month < 10) formattedDate += '0' + month + '-';
  else formattedDate += month + '-';
  if(date.getDate() < 10) formattedDate += '0' + date.getDate();
  else formattedDate += date.getDate();
  return formattedDate;
}
