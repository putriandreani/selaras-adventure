<?php
$servername = "localhost";  // Ganti dengan nama host database Anda
$username = "root";         // Username MySQL
$password = "";             // Password MySQL
$dbname = "pariwisata"; // Nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

