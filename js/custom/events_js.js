$(document).ready(function() {
  var invoice = './data/invoice_management.php', 
      newInvoiceGroupSnippet = './snippets/new-invoice-group-snippet.html',
      income = './data/income_management.php';

  $("#newInvoiceForm").submit(function(e) {
     // e.preventDefault();
    $.post(invoice, $(this).serialize(), 
       // $factures.display.displayInvoiceList('dateEcheance','01-01-2019','31-12-2019', 0, 0, 0,''),
      // function(data){
      //   $factures.display.displayInvoiceList('dateEcheance');
      // },
      'html');
  });

  $("#newCAForm").submit(function() {
    $.post(income, $(this).serialize(), 
      function(data) {
        $revenus.display.displayRevenus(data);
    }, 'html');
  });

  $('#grouper').click(function(){
    $factures.management.multipleInvoicesNextStatut();
  });

 $('#ListeSalarie').click(function(e){
  var maxSalesDate;
  var salesrepId = e.target.id;
  var salesDate = $("#salesDate");
  var maxDate = $("#MaxDate");
  var salesRep = $("#SalesrepId");
  var arrayMaxSalesDate = JSON.parse($("#MaxDateListe").value);
  // var arrayMaxSalesDate = JSON.parse(salesDate.value);
  $.each(arrayMaxSalesDate, function(index, value) {
    if(value['SALESREP_ID']==salesrepId){
      salesDate.html(value['MONTH_YEAR']);
      maxSalesDate = value['ID'];
    }
  });
  maxDate.attr({"value":maxSalesDate});
  salesRep.attr({"value":salesrepId});
 });
});
  
