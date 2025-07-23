<?php
include "koneksi.php";

$keyword = $_GET['keyword'] ?? '';

$result = mysqli_query($conn, "SELECT * FROM produk WHERE nama_barang LIKE '%$keyword%'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil Pencarian</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            padding: 20px;
        }

        h2 {
            color: #1976d2;
            text-align: center;
        }

        .produk {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .item {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 15px;
            width: 200px;
            text-align: center;
        }

        .item img {
            max-width: 100%;
            border-radius: 8px;
        }

        .item h4 {
            margin: 10px 0 5px;
        }

        .item p {
            margin: 0;
            color: #555;
        }
    </style>
</head>
<body>
    <h2>Hasil Pencarian: <?= htmlspecialchars($keyword) ?></h2>

    <div class="produk">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="item">
                    <img src="gambar/<?= $row['gambar'] ?>" alt="<?= $row['nama_barang'] ?>">
                    <h4><?= $row['nama_barang'] ?></h4>
                    <p>Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Tidak ada hasil untuk kata kunci tersebut.</p>
        <?php endif; ?>
    </div>
</body>
</html>