 <?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Ambil data keranjang
$keranjang = $_SESSION['keranjang'] ?? [];

// Kalau keranjang kosong, kembali ke halaman keranjang
if (empty($keranjang)) {
    header("Location: keranjang.php");
    exit;
}

// Ambil data dari form
$alamat = $_POST['alamat'] ?? '';
$metode = $_POST['metode_pembayaran'] ?? '';

// Validasi form
if (empty($alamat) || empty($metode)) {
    header("Location: checkout.php");
    exit;
}

include "koneksi.php";

// Simpan semua item di keranjang ke database
foreach ($keranjang as $item) {
    $nama_pembeli = $_SESSION['username'];
    $nama_barang  = mysqli_real_escape_string($conn, $item['nama']);
    $jumlah       = (int)$item['qty'];
    $alamat_simpan = mysqli_real_escape_string($conn, $alamat);
    $metode_simpan = mysqli_real_escape_string($conn, $metode);

    $sql = "INSERT INTO pembelian (nama_pembeli, nama_barang, jumlah, alamat, metode_pembayaran)
            VALUES ('$nama_pembeli', '$nama_barang', $jumlah, '$alamat_simpan', '$metode_simpan')";

    mysqli_query($conn, $sql);
}

// Kosongkan keranjang
unset($_SESSION['keranjang']);

// Arahkan kembali ke halaman keranjang dengan notifikasi sukses
header("Location: keranjang.php?status=checkout_sukses");
exit;
?>