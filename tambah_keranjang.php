<?php
session_start();

// Ambil data dari form
$id    = $_POST['id'];
$nama  = $_POST['nama'];
$harga = $_POST['harga'];

// Siapkan data keranjang
$item = [
    'id'    => $id,
    'nama'  => $nama,
    'harga' => $harga,
    'qty'   => 1
];

// Cek apakah keranjang sudah ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Cek apakah produk sudah ada di keranjang
$found = false;
foreach ($_SESSION['keranjang'] as &$produk) {
    if ($produk['id'] == $id) {
        $produk['qty']++;
        $found = true;
        break;
    }
}

if (!$found) {
    $_SESSION['keranjang'][] = $item;
}

// Kembali ke halaman shop
header("Location: index.php");
exit;
?>