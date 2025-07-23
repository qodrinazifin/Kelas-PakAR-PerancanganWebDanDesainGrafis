<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

$metode = $_GET['metode'] ?? '';
$nama   = $_GET['nama'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Pembayaran</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        .box {
            width: 400px;
            margin: 50px auto;
            padding: 30px;
            border: 2px solid #ccc;
            border-radius: 15px;
            background-color: #f9f9f9;
            text-align: center;
        }

        img {
            width: 200px;
            margin: 20px 0;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #2d89ef;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1a5fb4;
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>

    <div class="box">
        <h2>Halo <?= htmlspecialchars($nama) ?> 👋</h2>
        <p>Silakan lakukan pembayaran dengan metode:</p>
        <h3><?= htmlspecialchars($metode) ?></h3>

        <?php if ($metode === "QRIS" || $metode === "E-Wallet"): ?>
            <img src="qris_dummy.png" alt="QRIS Code">
            <p><strong>Scan QR di atas untuk bayar</strong></p>
        <?php else: ?>
            <p><strong>Pembayaran akan dilakukan saat barang tiba.</strong></p>
        <?php endif; ?>

        <br>
        <a href="riwayat_pembelian.php">
            <button>Selesai</button>
        </a>
    </div>
</body>
</html>