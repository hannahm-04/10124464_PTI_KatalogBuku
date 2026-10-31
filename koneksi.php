<?php
// koneksi.php
$host     = "localhost";
$nama_db  = "db_katalog";  // sesuaikan dengan nama database yang kamu buat di HeidiSQL
$username = "root";        // pastikan variabel ini tertulis persis $username
$password = "";            // password kosong untuk setelan bawaan Laragon
$dsn      = "mysql:host=" . $host . ";dbname=" . $nama_db . ";charset=utf8";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>