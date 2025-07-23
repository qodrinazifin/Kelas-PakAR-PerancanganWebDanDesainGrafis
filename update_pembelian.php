<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "webku_db";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data dari form
$id = (int)($_POST['id'] ?? 0);
$nama_pembeli = mysqli_real_escape_string($conn, $_POST['nama_pembeli'] ?? '');
$nama_barang = mysqli_real_escape_string($conn, $_POST['nama_barang'] ?? '');
$jumlah = (int)($_POST['jumlah'] ?? 0);
$alamat = mysqli_real_escape_string($conn, $_POST['alamat'] ?? '');
$metode = mysqli_real_escape_string($conn, $_POST['metode_pembayaran'] ?? '');

if ($id > 0 && $jumlah > 0 && $nama_pembeli && $nama_barang && $alamat && $metode) {
    $query = "UPDATE pembelian SET
                nama_pembeli = '$nama_pembeli',
                nama_barang = '$nama_barang',
                jumlah = $jumlah,
                alamat = '$alamat',
                metode_pembayaran = '$metode'
              WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: dashboard_admin.php");
        exit;
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
} else {
    echo "Data tidak lengkap atau tidak valid.";
}

mysqli_close($conn);
?>