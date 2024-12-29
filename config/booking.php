<?php
// Memulai session untuk menyimpan data pengguna
session_start();

// Koneksi ke database
require 'database.php'; // Pastikan file database.php berisi koneksi ke database

// Menangani Create (Tambah Pemesanan)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'create') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $package = $_POST['package'];
    $date = $_POST['date'];
    $services = isset($_POST['services']) ? implode(',', $_POST['services']) : ''; // Handle services array
    $user_id = $_SESSION['user_id']; // Mendapatkan ID pengguna yang login

    if (empty($name) || empty($email) || empty($package) || empty($date)) {
        echo "
        <script>
        alert('Semua kolom harus diisi!');
        document.location.href='../index.php#booking';
        </script>
        ";
        exit;
    }

    $query = $conn->prepare("INSERT INTO bookings (user_id, name, email, package, departure_date, services) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param('isssss', $user_id, $name, $email, $package, $date, $services);

    if ($query->execute()) {
        echo "
        <script>
        alert('Pemesanan berhasil ditambahkan!');
        document.location.href='../index.php#booking';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Terjadi kesalahan, coba lagi.');
        document.location.href='../index.php#booking';
        </script>
        ";
    }
}
// Menangani Read (Tampilkan Semua Pemesanan untuk User yang Login)
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] == 'read') {
    // Pastikan pengguna sudah login
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Query untuk mengambil pemesanan berdasarkan user_id
        $query = $conn->prepare("SELECT * FROM bookings WHERE user_id = ?");
        $query->bind_param('i', $user_id);
        $query->execute();
        $result = $query->get_result();
        $bookings = $result->fetch_all(MYSQLI_ASSOC);

        // Tampilkan pemesanan dalam format JSON
        echo json_encode($bookings);
    } else {
        echo "
        <script>
        alert('Anda harus login untuk melihat pemesanan.');
        document.location.href='../index.php#booking';
        </script>
        ";
    }
}

// Menangani Update (Update Pemesanan)
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $package = $_POST['package'];
    $date = $_POST['date'];

    if (empty($id) || empty($name) || empty($email) || empty($package) || empty($date)) {
        echo "
        <script>
        alert('Semua kolom harus diisi');
        document.location.href='../index.php#booking';
        </script>
        ";
        exit;
    }

    $query = $conn->prepare("UPDATE bookings SET name = ?, email = ?, package = ?, departure_date = ? WHERE id = ?");
    $query->bind_param('ssssi', $name, $email, $package, $date, $id);

    if ($query->execute()) {
        echo "
        <script>
        alert('Pemesanan berhasil diperbarui!');
        document.location.href='../index.php#booking';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('terjadi kesalahan saat memperbarui pemesanan');
        document.location.href='../index.php#booking';
        </script>
        ";
    }
}

// Menangani Delete (Hapus Pemesanan)
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = $_POST['id'];

    if (empty($id)) {
        echo "
        <script>
        alert('ID pemesanan tidak valid!');
        document.location.href='../index.php#booking';
        </script>
        ";
        exit;
    }

    $query = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $query->bind_param('i', $id);

    if ($query->execute()) {
        echo "
        <script>
        alert('Pemesanan berhasil dihapus!');
        document.location.href='../index.php#booking';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Terjadi kesalahan saat menghapus pemesanan.');
        document.location.href='../index.php#booking';
        </script>
        ";
    }
}
