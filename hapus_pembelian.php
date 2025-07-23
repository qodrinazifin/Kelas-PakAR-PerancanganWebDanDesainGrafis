<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

// Ambil ID dari URL
$id = $_GET['id'] ?? 0;
$id = (int)$id;

if ($id > 0) {
    $query = "DELETE FROM pembelian WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: dashboard_admin.php");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak valid.";
}

mysqli_close($conn);
?>