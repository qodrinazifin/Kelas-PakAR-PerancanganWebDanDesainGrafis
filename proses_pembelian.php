<?php
// Aktifkan error supaya kelihatan kalau ada yang salah
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "koneksi.php";

// Ambil dan amankan data dari form
$nama_pembeli       = mysqli_real_escape_string($conn, $_POST['nama_pembeli'] ?? '');
$nama_barang        = mysqli_real_escape_string($conn, $_POST['nama_barang'] ?? '');
$jumlah             = (int)($_POST['jumlah'] ?? 0);
$alamat             = mysqli_real_escape_string($conn, $_POST['alamat'] ?? '');
$metode_pembayaran  = mysqli_real_escape_string($conn, $_POST['metode_pembayaran'] ?? '');

// Validasi input
if (
    empty($nama_pembeli) ||
    empty($nama_barang) ||
    $jumlah < 1 ||
    empty($alamat) ||
    empty($metode_pembayaran)
) {
    echo "❌ Gagal: Semua data wajib diisi dan jumlah minimal 1.";
    exit;
}

// Simpan ke tabel pembelian
$sql = "INSERT INTO pembelian (nama_pembeli, nama_barang, jumlah, alamat, metode_pembayaran)
        VALUES ('$nama_pembeli', '$nama_barang', $jumlah, '$alamat', '$metode_pembayaran')";

if (mysqli_query($conn, $sql)) {
    // Setelah berhasil, balik lagi ke form_pembelian.php dengan status 
    header("Location: pembayaran.php?metode=$metode_pembayaran&nama=$nama_pembeli");
    exit;
} else {
    echo "❌ Gagal menyimpan data: " . mysqli_error($conn);
}

mysqli_close($conn);
?>