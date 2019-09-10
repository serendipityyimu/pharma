$(document).ready(function() {
  var invoice = './data/invoice_management.php', newInvoiceGroupSnippet = './snippets/new-invoice-group-snippet.html';
  var income = './data/income_management.php';

  $("#newInvoiceForm").submit(function() {
    $.post(invoice, $(this).serialize(), 
       // factures.display.displayInvoiceList('dateEcheance'), 
      function(data){
        $factures.display.displayInvoiceList('dateEcheance');
       },'html');
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
  var salesDate = document.getElementById("salesDate");
  var maxDate = document.getElementById("MaxDate");
  var salesRep = document.getElementById("SalesrepId");
  var arrayMaxSalesDate = JSON.parse(document.getElementById("MaxDateListe").value);
  // var arrayMaxSalesDate = JSON.parse(salesDate.value);
  $.each(arrayMaxSalesDate, function(index, value) {
    if(value['SALESREP_ID']==salesrepId){
      salesDate.innerHTML = value['MONTH_YEAR'];
      maxSalesDate = value['ID'];
    }
  });
  $js.setAttributes(maxDate, {"value":maxSalesDate});
  $js.setAttributes(salesRep, {"value":salesrepId});
  // console.log(maxDate);
  // console.log('Salesrep: ' + salesRep.value);
 });
});
  
