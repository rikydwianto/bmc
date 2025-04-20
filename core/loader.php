<?php 
session_start();

include_once(__DIR__."/koneksi/db.php");
include_once(__DIR__."/helpers/function.php");
$stmt = $pdo->query("SELECT * FROM payment_methods");
$paymentMethods = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $paymentMethods[$row['code']] = $row;
}
