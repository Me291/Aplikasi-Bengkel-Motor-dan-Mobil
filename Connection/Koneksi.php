<?php
$servername = "localhost"; // Nama server database
$username = "root"; // Nama pengguna database
$password = ""; // Kata sandi database (kosong jika tidak ada)
$dbname = "proyek_rekayasa"; // Nama database

// Membuat koneksi baru
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
