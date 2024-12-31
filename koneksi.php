<?php
$servername = "localhost";
$username = "root";  // default username untuk XAMPP
$password = "";      // default password untuk XAMPP
$dbname = "database_playstation"; // nama database yang sudah kamu buat

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
