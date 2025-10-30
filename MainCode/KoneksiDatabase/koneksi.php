<?php
// File: MainCode/KoneksiDatabase/koneksi.php

$host = 'fdb1034.awardspace.net'; // GANTI dengan host yang sesuai
$dbname = '4698762_simpelsi';
$user = '4698762_simpelsi';         // GANTI dengan username database
$pass = 'katasandi123';    // GANTI dengan password database
$port = '3306';                   // biasanya 3306
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>