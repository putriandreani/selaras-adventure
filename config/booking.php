<?php
// Memulai session untuk menyimpan data pengguna
session_start();

// Koneksi ke database
require 'database.php'; // Pastikan file database.php berisi koneksi ke database

// Menangani Create (Tambah Pemesanan)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'create') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $package = $_POST['package'];
    $departure_date = $_POST['departure_date'];
    $services = isset($_POST['services']) ? implode(',', $_POST['services']) : ''; // Handle services array
    $user_id = $_SESSION['user_id']; // Mendapatkan ID pengguna yang login
    $jml_peserta = $_POST['jml_peserta'];
    $durasi = $_POST['durasi'];

    if (empty($nama) || empty($email) || empty($no_hp) || empty($package) || empty($departure_date) || empty($jml_peserta) || empty($durasi)) {
        echo "
        <script>
        alert('Semua kolom harus diisi!');
        document.location.href='../index.php#booking';
        </script>
        ";
        exit;
    }

    $query = $conn->prepare("INSERT INTO bookings (user_id, nama, email, no_hp, package, departure_date, jml_peserta, services, durasi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $query->bind_param('issssssss', $user_id, $nama, $email, $no_hp, $package, $departure_date, $jml_peserta, $services, $durasi);

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
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] == 'read-booking') {
    // Pastikan pengguna sudah login
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $booking_id = $_GET['id'];

        // Query untuk mengambil pemesanan berdasarkan id dan user_id
        $query = $conn->prepare("SELECT * FROM bookings WHERE id = ? AND user_id = ?");
        $query->bind_param('ii', $booking_id, $user_id);
        $query->execute();
        $result = $query->get_result();
        $booking = $result->fetch_assoc();

        // Tampilkan pemesanan dalam format JSON
        echo json_encode($booking);
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
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $package = $_POST['package'];
    $departure_date = $_POST['departure_date'];
    $jml_peserta = $_POST['jml_peserta'];
    $durasi = $_POST['durasi'];

    if (empty($id) || empty($nama) || empty($email) || empty($no_hp) || empty($package) || empty($departure_date) || empty($jml_peserta) || empty($durasi)) {
        echo "
        <script>
        alert('Semua kolom harus diisi');
        document.location.href='../index.php#booking';
        </script>
        ";
        exit;
    }

    $query = $conn->prepare("UPDATE bookings SET nama = ?, email = ?, no_hp = ?, package = ?, departure_date = ?, jml_peserta = ?, durasi = ? WHERE id = ?");
    $query->bind_param('sssssssi', $nama, $email, $no_hp, $package, $departure_date, $jml_peserta, $durasi, $id);

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
        <;>
            alert('ID pemesanan tidak valid!');
            document.location.href='../index.php#booking';
        </script>
        ";
        exit;
    }

    $query = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $query->bind_param('i', $id);

    if ($query->execute()) {
        echo "Pemesanan berhasil dihapus";
    } else {
        echo "
        <script>
        alert('Terjadi kesalahan saat menghapus pemesanan.');
        document.location.href='../index.php#booking';
        </script>
        ";
    }
}
