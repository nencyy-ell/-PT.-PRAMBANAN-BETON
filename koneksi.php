<?php
// =============================================
// FILE: koneksi.php
// Fungsi: Menghubungkan ke database MySQL
// =============================================

$host     = "localhost";
$user     = "root";
$password = "nenci123";        // kosong jika belum diset password di XAMPP
$database = "db_login"; // sesuaikan nama database kamu

// Membuat koneksi
$koneksi = mysqli_connect("localhost", "root", "nenci123", "db_login");

// Cek apakah koneksi berhasil
if (!$koneksi) {
    die("Koneksi GAGAL: " . mysqli_connect_error());
}
// Jika berhasil, tidak ada output apapun (normal)
?>
