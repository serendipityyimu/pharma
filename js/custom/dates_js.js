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

// $('#date_reglement').datepicker($.datepicker.regional["fr"]);
// $('#date_debut').datepicker($.datepicker.regional["fr"]);
// $('#date_fin').datepicker($.datepicker.regional["fr"]);
