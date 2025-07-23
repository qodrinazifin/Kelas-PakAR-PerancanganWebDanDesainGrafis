<?php
session_start();

// Pastikan index yang dimaksud ada
if (isset($_POST['index'])) {
    $index = $_POST['index'];

    // Hapus dari array session keranjang
    if (isset($_SESSION['keranjang'][$index])) {
        unset($_SESSION['keranjang'][$index]);

        // Rapikan ulang array (reset index agar tidak bolong)
        $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);
    }
}

// Kembali ke halaman keranjang
header("Location: keranjang.php");
exit;
?>
