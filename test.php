<?php
require_once("includes/includes.php");
$stmt = $pdo->query("SELECT SALESREP_ID, SALESREP, ACTIF FROM salesdept");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo '<table border="1">'."\n";
foreach ( $rows as $row ) {
    echo "<tr><td>";
    echo($row['SALESREP_ID']);
    echo("</td><td>");
    echo($row['SALESREP']);
    echo("</td><td>");
    echo($row['ACTIF']);
    echo("</td></tr>\n");
}
echo "</table>\n";
?>
