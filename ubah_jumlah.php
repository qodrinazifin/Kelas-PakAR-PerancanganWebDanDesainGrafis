<?php
session_start();

$index = $_POST['index'] ?? null;
$aksi  = $_POST['aksi'] ?? '';

if (isset($_SESSION['keranjang'][$index])) {
    if ($aksi === 'tambah') {
        $_SESSION['keranjang'][$index]['qty']++;
    } elseif ($aksi === 'kurang') {
        $_SESSION['keranjang'][$index]['qty']--;
        if ($_SESSION['keranjang'][$index]['qty'] <= 0) {
            unset($_SESSION['keranjang'][$index]);
        }
    }
    $_SESSION['keranjang'] = array_values($_SESSION['keranjang']); // reset index
}

header("Location: keranjang.php");
exit;
?>