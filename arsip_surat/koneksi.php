<?php
$host = "localhost";
$user = "root";  // default XAMPP
$pass = "";      // default XAMPP (kosong)
$db   = "arsip_surat"; 

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
