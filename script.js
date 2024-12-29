function submitBooking(event) {
    // Mencegah pengiriman form yang akan memuat ulang halaman
    event.preventDefault();

    // Mendapatkan nilai input dari form
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const packageSelected = document.getElementById('package').value;
    const date = document.getElementById('date').value;
    const message = document.getElementById('message');

    // Validasi Data Pemesanan
    if (name && email && packageSelected && date) {
        // Menampilkan pesan sukses
        message.textContent = `Terima kasih, ${name}! Pemesanan paket wisata ${packageSelected} berhasil untuk tanggal ${date}. Kami akan mengirimkan konfirmasi ke ${email}.`;
        message.style.color = "green"; // Menambahkan warna hijau untuk pesan sukses
    } else {
        // Menampilkan pesan error jika data belum lengkap
        message.textContent = "Mohon lengkapi semua data.";
        message.style.color = "red"; // Menambahkan warna merah untuk pesan error
    }
}
