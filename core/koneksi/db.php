<?php
$host = 'localhost';         // Alamat server database
$dbname = 'bmc';          // Nama database
$username = 'root';          // Username database
$password = '';              // Password database (kosong untuk default)
$server = $_SERVER['HTTP_HOST']; 
$index =  $_SERVER['REQUEST_URI'];

// Menentukan protokol HTTP atau HTTPS
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $uri = 'https://';
} else {
    $uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];
$url = $uri . '/'."bmc/";

// Membuat koneksi PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Mengatur error mode PDO untuk menampilkan error jika ada masalah
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Menangkap error jika koneksi gagal
}
?>
