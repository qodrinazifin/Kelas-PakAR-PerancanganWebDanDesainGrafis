<?php
session_start();

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

$id    = $_POST['id'];
$nama  = $_POST['nama'];
$harga = $_POST['harga'];

// Tambahkan langsung ke keranjang
$_SESSION['keranjang'][] = [
    'id'    => $id,
    'nama'  => $nama,
    'harga' => $harga,
    'qty'   => 1
];

// Redirect langsung ke halaman checkout
header("Location: checkout.php");
exit;