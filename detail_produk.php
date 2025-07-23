 <?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: shop.php");
    exit;
}

include "koneksi.php";

$id = (int) $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id = $id");
$produk = mysqli_fetch_assoc($query);

if (!$produk) {
    echo "<p style='text-align:center;'>Produk tidak ditemukan.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Produk</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            width: 60%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-top: 30px;
            box-shadow: 1px 1px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        img {
            width: 300px;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
        }

        .btn {
            margin: 10px 5px;
            padding: 10px 15px;
            border: none;
            color: white;
            background-color: #28a745;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn-keranjang {
            background-color: #007bff;
        }

        .btn-beli {
            background-color: #28a745;
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>

    <div class="container">
        <h2><?= htmlspecialchars($produk['nama_barang']) ?></h2>
        <img src="gambar/<?= htmlspecialchars($produk['gambar']) ?>" alt="<?= $produk['nama_barang'] ?>">
        <p style="font-size: 18px; margin-top: 20px;"><strong>Harga:</strong> Rp <?= number_format($produk['harga'], 0, ',', '.') ?></p>

        <div style="margin-top: 20px;">
            <!-- Beli Sekarang -->
            <a class="btn btn-beli" href="checkout.php?barang=<?= urlencode($produk['nama_barang']) ?>&harga=<?= $produk['harga'] ?>">🛒 Beli Sekarang</a>

            <!-- Tambah ke Keranjang -->
            <form action="tambah_keranjang.php" method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?= $produk['id'] ?>">
                <input type="hidden" name="nama" value="<?= $produk['nama_barang'] ?>">
                <input type="hidden" name="harga" value="<?= $produk['harga'] ?>">
                <button type="submit" class="btn btn-keranjang">+ Tambah ke Keranjang</button>
            </form>
        </div>
    </div>
</body>
</html>