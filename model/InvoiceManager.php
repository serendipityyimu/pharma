<?php
require_once("includes/includes.php");
class InvoiceManager {
  private $invoiceId;
  private $supplierId;
  private $invoiceDate;
  private $dueDate;
  private $totalAmount;
  private $status;
  private $invoiceType;
  private $paymentType;
  private $comments;


  public function insertInvoice($supplierId, $invoiceDate, $dueDate, $totalAmount, $status, $invoiceType, $paymentType, $comments) {
    $this->$supplierId = $supplierId;
    $this->$invoiceDate = $invoiceDate;
    $this->$dueDate = $dueDate;
    $this->$totalAmount = $totalAmount;
    $this->$status = $status;
    $this->$invoiceType = $invoiceType;
    $this->$paymentType = $paymentType;
    $this->$comments = $comments;

    ($this->$totalAmount =='')?$this->$totalAmount=0:$this->$totalAmount;
  	if ($this->$invoiceType <>1) {
  		$totalAmount = -$totalAmount;
  	}
    $pdo = pdo();
    $newInvoice = $pdo->prepare('INSERT INTO FACTURES (ID_FOURNISSEUR, DATE_FACTURE, DATE_ECHEANCE, MONTANT_TTC, CODE_STATUT, CODE_TYPE, CODE_MODE_PAIEMENT, COMMENTAIRES) VALUES
  	(?, STR_TO_DATE(?, \'%Y-%m-%d\'), STR_TO_DATE(?, \'%Y-%m-%d\'), ?, ?, ?, ?, ?)');
    $affectedLines = $newInvoice->execute(array($this->$supplierId, $this->$invoiceDate, $this->$dueDate, $this->$totalAmount, $this->$status, $this->$invoiceType, $this->$paymentType, $this->$comments));
  }

  public function updateInvoice() {

  }

  public function deleteInvoice($invoiceId) {
    $this->$invoiceId = $invoiceId;
  }

  public function getInvoice() {
    $pdo = pdo();
    $invoiceList = $pdo->query('SELECT NOM_FOURNISSEUR, DATE_FORMAT(DATE_FACTURE, \'%d/%m/%Y\') AS DATE_FACTURE, CODE_TYPE, DESC_NATURE, DATE_FORMAT(DATE_ECHEANCE, \'%d/%m/%Y\') AS DATE_ECHEANCE, MONTANT_TTC, FACTURES.CODE_STATUT AS CODE_STATUT, DESC_STATUT, CODE_MODE_PAIEMENT, DESC_PAIEMENT, SUBSTRING(COMMENTAIRES, 1, 20) AS COMMENTAIRES, ID_FACTURE
    FROM FACTURES, FOURNISSEURS, MODE_PAIEMENT, STATUT_FACTURE, NATURE_FACTURE WHERE FACTURES.ID_FOURNISSEUR = FOURNISSEURS.ID_FOURNISSEUR AND CODE_MODE_PAIEMENT=CODE_PAIEMENT AND CODE_TYPE=CODE_NATURE AND FACTURES.CODE_STATUT=STATUT_FACTURE.CODE_STATUT');
    return $invoiceList;

  //" . $whereClause . " ORDER BY " . $orderBy . " ASC";

  }
}
 ?>
