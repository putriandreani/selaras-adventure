<?php
session_start();
require 'config/database.php';
if (isset($_SESSION['username'])) {
    $user_id = $_SESSION['user_id'];
    $query = $conn->prepare("SELECT COUNT(*) as order_count FROM bookings WHERE user_id = ?");
    $query->bind_param('i', $user_id);
    $query->execute();
    $result = $query->get_result();
    $order_count = $result->fetch_assoc()['order_count'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selaras Adventure</title>
    <!-- Link ke Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #00101b;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="asset/_80d39289-57d7-4d34-be54-2de7585b1624.jpeg" alt="Logo Selaras Adventure" height="40" class="me-2">
                <span>Selaras Adventure</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#packages">Paket Wisata</a>
                    </li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#booking">Pemesanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><?= htmlspecialchars(ucfirst($_SESSION['nama'])); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#booking-list">
                                <i class="fas fa-shopping-cart"></i>
                                Pesanan <span class="badge badge-light"><?= $order_count ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="config/logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.html">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Halaman Beranda -->
    <section id="home" class="section">
        <div class="container">
            <h2>Selamat Datang di Selaras Adventure</h2>
            <img src="https://picture.triptrus.com/image/2016/02/hello.jpg" alt="Selamat Datang di Selaras Adventure" class="img-fluid">
            <p>Nikmati keindahan alam dan budaya lokal bersama Selaras Adventure! perjalanan tak terlupakan dengan paket wisata kami yang menarik. Kami siap membawa Anda menuju destinasi-destinasi wisata yang viral dan wajib dikunjungi, tanpa perlu khawatir soal harga. Dengan beragam pilihan paket dan lokasi yang indah, Selaras Adventure menawarkan pengalaman berwisata yang menyatu dengan alam, seru, dan tentu saja terjangkau!.</p>
        </div>
    </section>

    <!-- Daftar Paket Wisata -->
    <section id="packages" class="section bg-light">
        <div class="container">
            <h2>Paket Wisata</h2>
            <div class="row">
                <!-- Contoh Paket Wisata 1 -->
                <div class="col-md-3">
                    <div class="card mb-4 h-100">
                        <img src="https://assets.promediateknologi.id/crop/0x0:0x0/750x500/webp/photo/2021/12/27/1814339773.jpg" class="card-img-top" alt="Paket Wisata Bali">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Paket Wisata Bali</h5>
                            <p class="card-text text-justify">Jelajahi keindahan Bali dengan harga terjangkau. Paket ini mencakup perjalanan ke pantai, pura, dan tempat wisata terkenal lainnya.</p>
                            <a href="https://www.youtube.com/watch?v=9MvDzqg5hLg" class="btn btn-primary mt-auto" target="_blank">Video Promosi</a>
                        </div>
                    </div>
                </div>
                <!-- Contoh Paket Wisata 2 -->
                <div class="col-md-3">
                    <div class="card mb-4 h-100">
                        <img src="https://wisatajogjatrip.com/images/blog/wisata-jogja-trip-45-tempat-wisata-populer-di-yogyakarta-91.jpeg" class="card-img-top" alt="Paket Wisata Yogyakarta">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Paket Wisata Yogyakarta</h5>
                            <p class="card-text text-justify">Nikmati budaya dan keindahan alam Yogyakarta terkenal dengan peninggalan bersejarah seperti Candi Borobudur dan Candi Prambanan, yang termasuk situs warisan dunia UNESCO.</p>
                            <a href="https://www.youtube.com/watch?v=CvlYs04918A" class="btn btn-primary mt-auto" target="_blank">Video Promosi</a>
                        </div>
                    </div>
                </div>
                <!-- Contoh Paket Wisata 3 -->
                <div class="col-md-3">
                    <div class="card mb-4 h-100">
                        <img src="https://assets.promediateknologi.id/crop/0x0:0x0/750x500/webp/photo/2022/11/29/1477750370.jpg" class="card-img-top" alt="Paket Wisata Bandung">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Paket Wisata Bandung</h5>
                            <p class="card-text text-justify">Nikmati budaya dan keindahan alam Bandung yang memiliki berbagai macam destinasi alam seperti kebun teh, air terjun, dan taman bunga.</p>
                            <a href="https://www.youtube.com/watch?v=eqbFOYPoDNw" class="btn btn-primary mt-auto" target="_blank">Video Promosi</a>
                        </div>
                    </div>
                </div>
                <!-- Contoh Paket Wisata 4 -->
                <div class="col-md-3">
                    <div class="card mb-4 h-100">
                        <img src="https://static.tripzilla.id/media/22242/conversions/Preview-Tempat-Wisata-Semarang-w768.webp" class="card-img-top" alt="Paket Wisata Semarang">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">Paket Wisata Semarang</h5>
                            <p class="card-text text-justify">Nikmati budaya dan keindahan alam Semarang memiliki beragam destinasi alam yang indah, seperti Brown Canyon, yang merupakan formasi tebing batu yang unik dan eksotis.</p>
                            <a href="https://www.youtube.com/watch?v=0m6Fq62cHuQ" class="btn btn-primary mt-auto" target="_blank">Video Promosi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if (isset($_SESSION['login'])): ?>
        <?php if ($_SESSION['login'] == 1): ?>
            <section id="booking" class="section mt-0 bg-white">
                <div class="container">
                    <h2 class="mb-4">Pemesanan Paket Wisata</h2>
                    <form id="bookingForm" method="POST" action="config/booking.php" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama:</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo $_SESSION['nama']; ?>">
                            <div class="invalid-feedback">Nama diperlukan.</div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo $_SESSION['email']; ?>">
                            <div class="invalid-feedback">Email diperlukan.</div>
                        </div>
                        <div class="mb-3">
                            <label for="package" class="form-label">Pilih Paket Wisata:</label>
                            <select id="package" name="package" class="form-select" required>
                                <option value="">Pilih...</option>
                                <option value="bali">Paket Wisata Bali</option>
                                <option value="yogyakarta">Paket Wisata Yogyakarta</option>
                                <option value="bandung">Paket Wisata Bandung</option>
                                <option value="semarang">Paket Wisata Semarang</option>
                            </select>
                            <div class="invalid-feedback">Paket wisata diperlukan.</div>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal Keberangkatan:</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                            <div class="invalid-feedback">Tanggal diperlukan.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pelayanan:</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="penginapan" name="services[]" value="penginapan">
                                <label class="form-check-label" for="penginapan">Penginapan</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="transportasi" name="services[]" value="transportasi">
                                <label class="form-check-label" for="transportasi">Transportasi</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="makanan" name="services[]" value="makanan">
                                <label class="form-check-label" for="makanan">Makanan</label>
                            </div>
                        </div>
                        <button type="submit" name="action" value="create" class="btn btn-success w-100">Pesan Sekarang</button>
                    </form>
                </div>
            </section>

            <section id="booking-list" class="section mt-0 bg-light">
                <h3>Daftar Pemesanan</h3>
                <table class="table table-striped" id="bookingTable">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Paket</th>
                            <th>Tanggal</th>
                            <th>Pelayanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="bookingList">
                        <!-- Data Pemesanan akan dimuat di sini -->
                    </tbody>
                </table>
            </section>
        <?php endif; ?>
    <?php endif; ?>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Selaras Adventure.</p>
    </footer>

    <!-- Script Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <script>
        // Mengambil data pemesanan dan menampilkannya di tabel
        function loadBookings() {
            fetch('config/booking.php?action=read')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('bookingList');
                    tableBody.innerHTML = '';
                    data.forEach(booking => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td>${booking.name}</td>
                    <td>${booking.email}</td>
                    <td>${booking.package.charAt(0).toUpperCase() + booking.package.slice(1)}</td>
                    <td>${booking.departure_date}</td>
                    <td>${booking.services ? booking.services.split(',').map(service => service.charAt(0).toUpperCase() + service.slice(1)).join(', ') : ''}</td>
                    <td>
                        <button onclick="editBooking(${booking.id})">Edit</button>
                        <button onclick="deleteBooking(${booking.id})">Delete</button>
                    </td>
                `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Fungsi untuk menghapus pemesanan
        function deleteBooking(id) {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);

            fetch('config/booking.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(message => {
                    alert(message);
                    loadBookings(); // Refresh tabel pemesanan
                });
        }

        // Fungsi untuk mengedit pemesanan
        function editBooking(id) {
            // Implementasi edit booking jika diperlukan
            alert('Edit feature belum diimplementasikan');
        }

        loadBookings(); // Load data pemesanan saat halaman dimuat
    </script>
</body>

</html>