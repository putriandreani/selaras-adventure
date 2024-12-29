<?php
// Memulai session untuk menyimpan data
session_start();

// Koneksi ke database (sesuaikan dengan file database.php)
require 'database.php'; // Pastikan file database.php sudah terkonfigurasi dengan benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil input dari form registrasi
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $no_hp = trim($_POST['no_hp']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validasi input
    if (empty($nama) || empty($email) || empty($no_hp) || empty($username) || empty($password)) {
        echo "
        <script>
        alert('Semua kolom harus diisi!');
        document.location.href='../register.html';
        </script>
        ";
        exit;
    }

    // Cek apakah username sudah ada
    $query = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $query->bind_param('s', $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        echo "
        <script>
        alert('Username sudah digunakan, silakan pilih username lain!');
        document.location.href='../register.html';
        </script>
        ";
        exit;
    }

    // Hashing password menggunakan bcrypt
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Menyimpan pengguna baru ke database
    $insert_query = $conn->prepare("INSERT INTO users (nama, email, no_hp, username, password) VALUES (?, ?, ?, ?, ?)");
    $insert_query->bind_param('sssss', $nama, $email, $no_hp, $username, $hashed_password);
    if ($insert_query->execute()) {
        // Registrasi berhasil, redirect ke halaman login
        $_SESSION['username'] = $username; // Menyimpan username di session
        echo "
        <script>
        alert('Registrasi berhasil!');
        document.location.href='../login.html';
        </script>
        ";
        exit;
    } else {
        echo "
        <script>
        alert('Terjadi kesalahan saat registrasi, coba lagi.');
        document.location.href='../register.html';
        </script>
        ";
        exit;
    }
} else {
    // Jika form tidak disubmit dengan metode POST, redirect ke halaman login
    header("Location: ../login.html");
    exit;
}
