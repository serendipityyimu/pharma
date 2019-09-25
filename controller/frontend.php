<?php
require_once('model/InvoiceManager.php');

function postInvoice($supplierId, $invoiceDate, $dueDate, $totalAmount, $status, $invoiceType, $paymentType, $comments) {
  $invoiceManager = new InvoiceManager($supplierId, $invoiceDate, $dueDate, $totalAmount, $status, $invoiceType, $paymentType, $comments);
  $affectedLines = $invoiceManager->insertInvoice($supplierId, $invoiceDate, $dueDate, $totalAmount, $status, $invoiceType, $paymentType, $comments);
  if($affectedLines === false) {
    throw new \Exception("Erreur lors de la création d'une nouvelle facture !");
  }
  else {
    header('Location: index.php');
  }
}

function listInvoice() {
  $invoiceManager = new InvoiceManager();
  $posts = $invoiceManager->getInvoice();
  require('view/frontend/listInvoiceView.php');
}
?>
