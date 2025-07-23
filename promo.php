<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";
$produk = mysqli_query($conn, "SELECT * FROM produk WHERE promo = 1");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Promo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #e3f2fd, #bbdefb);
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #d32f2f;
            margin: 30px 0 10px;
        }

        .produk {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
            gap: 20px;
        }

        .card {
            background: #fff9c4;
            border-radius: 12px;
            padding: 15px;
            width: 100%;
            max-width: 250px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s ease;
            position: relative;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card a.link-produk {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .badge-promo {
            position: absolute;
            top: 10px;
            left: 10px;
            background: red;
            color: white;
            font-size: 12px;
            padding: 5px 8px;
            border-radius: 5px;
            font-weight: bold;
        }

        .label-diskon {
            margin-top: 5px;
            background-color: #ef5350;
            color: white;
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 13px;
            display: inline-block;
        }

        .card h3 {
            margin: 15px 0 8px;
            color: #e65100;
        }

        .card p {
            font-weight: bold;
            color: #c62828;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .tombol-aksi {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 10px;
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
            background-color: #2e7d32;
            color: white;
        }

        .btn-beli:hover {
            background-color: #1b5e20;
        }

        .btn-keranjang {
            background-color: #fb8c00;
            color: white;
        }

        .btn-keranjang:hover {
            background-color: #ef6c00;
        }

        @media (max-width: 768px) {
            .produk { padding: 15px; }
            .card { max-width: 45%; }
        }

        @media (max-width: 480px) {
            .card { max-width: 100%; }
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<h2>🔥 Promo Terbaik Hari Ini 🔥</h2>

<div class="produk">
    <?php while ($p = mysqli_fetch_assoc($produk)) :
        $harga_asli = $p['harga'];
        $diskon = $p['diskon'] ?? 0;
        $harga_setelah_diskon = ($diskon > 0) ? $harga_asli - ($harga_asli * $diskon / 100) : $harga_asli;
    ?>
        <div class="card">
            <div class="badge-promo">PROMO</div>
            <a class="link-produk" href="detail_produk.php?id=<?= $p['id'] ?>">
                <img src="gambar/<?= htmlspecialchars($p['gambar'] ?: 'default.jpg') ?>" alt="<?= htmlspecialchars($p['nama_barang']) ?>">
                <h3><?= htmlspecialchars($p['nama_barang']) ?></h3>
                <p>Rp <?= number_format($harga_setelah_diskon, 0, ',', '.') ?></p>
                <?php if ($diskon > 0): ?>
                    <div class="label-diskon">Diskon <?= $diskon ?>%</div>
                <?php endif; ?>
            </a>

            <div class="tombol-aksi">
                <form action="beli_sekarang.php" method="POST">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <input type="hidden" name="nama" value="<?= $p['nama_barang'] ?>">
                    <input type="hidden" name="harga" value="<?= $harga_setelah_diskon ?>">
                    <button type="submit" class="btn btn-beli">Beli</button>
                </form>

                <form action="tambah_keranjang.php" method="POST">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <input type="hidden" name="nama" value="<?= $p['nama_barang'] ?>">
                    <input type="hidden" name="harga" value="<?= $harga_setelah_diskon ?>">
                    <button type="submit" class="btn btn-keranjang">+ Keranjang</button>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>