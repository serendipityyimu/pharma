var DateDiff = {
  inDays: function(d1, d2) {
    var t2 = d2.getTime();
    var t1 = d1.getTime();
    return parseInt((t2-t1)/(24*3600*1000));
  },

  inWeeks: function(d1, d2) {
    var t2 = d2.getTime();
    var t1 = d1.getTime();
    return parseInt((t2-t1)/(24*3600*1000*7));
  },

  inMonths: function(d1, d2) {
    var d1Y = d1.getFullYear();
    var d2Y = d2.getFullYear();
    var d1M = d1.getMonth();
    var d2M = d2.getMonth();
    return (d2M+12*d2Y)-(d1M+12*d1Y);
  },

  inYears: function(d1, d2) {
    return d2.getFullYear()-d1.getFullYear();
  }
}

$('#date_facture').datepicker($.datepicker.regional["fr"]);
$('#date_echeance').datepicker($.datepicker.regional["fr"]);
$('#date_reglement').datepicker($.datepicker.regional["fr"]);
$('#date_debut').datepicker($.datepicker.regional["fr"]);
$('#date_fin').datepicker($.datepicker.regional["fr"]);


function LastDayOfMonth(date) {
  return new Date(date.getFullYear(), date.getMonth()+1,0);
}

function LastDayOfNextMonth(date){
  return new Date(date.getFullYear(), date.getMonth()+2,0);
}

$('#date_facture').removeClass('hasDatepicker');
$('#date_echeance').removeClass('hasDatepicker');

$('#date_facture').datepicker({
  onSelect: function (dateSelected, i){
    if (laboratoire.value) {
      var dateEcheance = new Date($('#date_facture').datepicker('getDate'));
      var echeance = parseInt(laboratoire.getAttribute('data-echeance'));
      if (echeance <100) {
        dateEcheance.setDate(dateEcheance.getDate() + echeance);
      }
      else if (echeance ===450) {
        //45 jours fin de mois
        dateEcheance.setDate(dateEcheance.getDate() + 45);
        dateEcheance = LastDayOfMonth(dateEcheance);
      }
      else if (echeance ===300) {
        //30 jours fin de mois
        dateEcheance.setDate(dateEcheance.getDate() + 30);
        dateEcheance = LastDayOfMonth(dateEcheance);          
      }
      else if (echeance ===451) {
        //Fin de mois + 45 jours
        dateEcheance = LastDayOfNextMonth(dateEcheance);
        dateEcheance.setDate(dateEcheance.getDate() + 15);
      }
      else if (echeance ===315) {
        // 30 jours fin de quinzaine
        if (dateEcheance.getDate()>15) {
          dateEcheance = LastDayOfNextMonth(dateEcheance);
        }
        else {
          dateEcheance = LastDayOfMonth(dateEcheance);
          dateEcheance.setDate(dateEcheance.getDate() + 15);
        }
      }
      else if (echeance ===550) {
        //55 jours fin de decade
        if (dateEcheance.getDate()>20) {
          dateEcheance = LastDayOfNextMonth(dateEcheance);
          dateEcheance.setDate(dateEcheance.getDate() + 25);
        }
        else if (dateEcheance.getDate()>10) {
          dateEcheance = LastDayOfNextMonth(dateEcheance);
          dateEcheance.setDate(dateEcheance.getDate() + 15);
        }
        else {
          dateEcheance = LastDayOfNextMonth(dateEcheance);
          dateEcheance.setDate(dateEcheance.getDate() + 5);
        }
       }
      $('#date_echeance').datepicker('setDate', dateEcheance);
    }
  }
});
