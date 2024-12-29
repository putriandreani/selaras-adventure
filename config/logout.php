<?php
session_start(); // Memulai session
session_destroy(); // Menghancurkan semua data session
header("Location: ../index.php"); // Redirect ke halaman login setelah logout
exit;
?>
