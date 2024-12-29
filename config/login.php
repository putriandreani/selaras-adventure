<?php
// Memulai session untuk menyimpan data pengguna
session_start();

// Mengimpor file koneksi database
require 'database.php'; // Pastikan file ini berisi koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil input username dan password dari form
    $username = $_POST['username'];
    $password = $_POST['password']; // Password yang dimasukkan oleh pengguna

    // Validasi input
    if (empty($username) || empty($password)) {
        echo "Username atau password tidak boleh kosong!";
        exit;
    }

    // Mempersiapkan query untuk memeriksa pengguna di database
    $query = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $query->bind_param('s', $username);
    $query->execute();

    // Mendapatkan hasil query
    $result = $query->get_result();

    // Memeriksa apakah pengguna ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password menggunakan password_verify
        if (password_verify($password, $user['password'])) {
            // Menyimpan data pengguna di session
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['no_hp'] = $user['no_hp'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['login'] = '1';

            // Redirect ke dashboard
            header("Location: ../index.php");
            exit;
        } else {
            echo "Password salah!";
            exit;
        }
    } else {
        echo "Pengguna tidak ditemukan!";
        exit;
    }
} else {
    // Jika halaman diakses tanpa submit form, redirect ke halaman login
    header("Location: ../login.html");
    exit;
}
