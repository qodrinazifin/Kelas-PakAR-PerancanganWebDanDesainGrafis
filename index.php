 <?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php"; // Pakai koneksi.php

$produk = mysqli_query($conn, "SELECT * FROM produk");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Shop - Toko Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #e3f2fd, #bbdefb);
            margin: 0;
            padding: 0;
        }

        .produk {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 30px;
            justify-content: center;
        }

        .card {
            width: 100%;
            max-width: 250px;
            background: white;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card a {
            text-decoration: none;
            color: inherit;
        }

        .card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .card h3 {
            margin: 15px 0 10px;
            font-size: 18px;
            color: #1976d2;
        }

        .card p {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 12px;
            color: #444;
        }

        .tombol-aksi {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-beli {
            background-color: #4caf50;
            color: white;
        }

        .btn-beli:hover {
            background-color: #388e3c;
        }

        .btn-keranjang {
            background-color: #ff9800;
            color: white;
        }

        .btn-keranjang:hover {
            background-color: #fb8c00;
        }

        @media (max-width: 768px) {
            .produk {
                padding: 20px;
            }
            .card {
                max-width: 45%;
            }
        }

        @media (max-width: 480px) {
            .card {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="produk">
    <?php while ($p = mysqli_fetch_assoc($produk)) : ?>
        <div class="card">
            <a href="detail_produk.php?id=<?= $p['id'] ?>">
                <?php if ($p['gambar']) : ?>
                    <img src="gambar/<?= htmlspecialchars($p['gambar']) ?>" alt="<?= htmlspecialchars($p['nama_barang']) ?>">
                <?php else: ?>
                    <img src="gambar/default.jpg" alt="Tidak ada gambar">
                <?php endif; ?>

                <h3><?= htmlspecialchars($p['nama_barang']) ?></h3>
                <p>Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
            </a>

            <div class="tombol-aksi">
                <form action="beli_sekarang.php" method="POST">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <input type="hidden" name="nama" value="<?= $p['nama_barang'] ?>">
                    <input type="hidden" name="harga" value="<?= $p['harga'] ?>">
                    <button type="submit" class="btn btn-beli">Beli</button>
                </form>

                <form action="tambah_keranjang.php" method="POST">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <input type="hidden" name="nama" value="<?= $p['nama_barang'] ?>">
                    <input type="hidden" name="harga" value="<?= $p['harga'] ?>">
                    <button type="submit" class="btn btn-keranjang">+ Keranjang</button>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>