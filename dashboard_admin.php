 <?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

// Statistik
$totalUser = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$totalProduk = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM produk"));
$total_transaksi = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pembelian"));

$result_barang = mysqli_query($conn, "SELECT SUM(jumlah) AS total FROM pembelian");
$data_barang = mysqli_fetch_assoc($result_barang);
$total_barang = $data_barang['total'] ?? 0;

$result_pembeli = mysqli_query($conn, "SELECT COUNT(DISTINCT nama_pembeli) AS total FROM pembelian");
$data_pembeli = mysqli_fetch_assoc($result_pembeli);
$total_pembeli = $data_pembeli['total'] ?? 0;

$cari = $_GET['cari'] ?? '';
if ($cari !== '') {
    $cari_aman = mysqli_real_escape_string($conn, $cari);
    $query = "SELECT * FROM pembelian 
              WHERE nama_pembeli LIKE '%$cari_aman%' 
              OR nama_barang LIKE '%$cari_aman%' 
              ORDER BY id DESC";
} else {
    $query = "SELECT * FROM pembelian ORDER BY id DESC";
}
$semua_data = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Lucide Icon CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: 30px auto;
        }

        h2 {
            text-align: center;
            color: #1976d2;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .stat-box {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .box {
            flex: 1 1 200px;
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .box h3 {
            margin: 10px 0;
            color: #2d89ef;
        }

        .box p {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        th {
            background-color: #1976d2;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .btn-hapus, .btn-edit {
            padding: 6px 12px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn-hapus {
            background-color: #e53935;
        }

        .btn-hapus:hover {
            background-color: #c62828;
        }

        .btn-edit {
            background-color: #fbc02d;
            color: black;
        }

        .btn-edit:hover {
            background-color: #f9a825;
        }

        form input[type="text"] {
            padding: 8px;
            width: 250px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-right: 8px;
        }

        form button {
            padding: 8px 16px;
            background-color: #1976d2;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #125ea7;
        }

        .top-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .top-buttons a {
            background-color: #1976d2;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .top-buttons a:nth-child(1) {
            background-color: #28a745;
        }

        .top-buttons a:nth-child(2) {
            background-color: #17a2b8;
        }

        .top-buttons a:nth-child(3) {
            background-color: #e53935;
        }

        @media (max-width: 768px) {
            .stat-box {
                flex-direction: column;
                align-items: center;
            }

            table {
                font-size: 14px;
            }

            form input[type="text"] {
                width: 100%;
                margin-bottom: 10px;
            }

            form {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .top-buttons {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2><i data-lucide="layout-dashboard"></i> Dashboard Admin</h2>

    <!-- Tombol atas -->
    <div class="top-buttons">
        <a href="tambah_produk.php"><i data-lucide="plus-circle"></i> Tambah Produk</a>
        <a href="inbox_cs.php"><i data-lucide="inbox"></i> Inbox CS</a>
        <a href="logout.php"><i data-lucide="log-out"></i> Logout</a>
    </div>

    <!-- KOTAK STATISTIK -->
    <div class="stat-box">
        <div class="box">
            <h3>Total Transaksi</h3>
            <p><?= $total_transaksi ?></p>
        </div>
        <div class="box">
            <h3>Total Barang Terjual</h3>
            <p><?= $total_barang ?></p>
        </div>
        <div class="box">
            <h3>Jumlah Pembeli</h3>
            <p><?= $total_pembeli ?></p>
        </div>
    </div>

    <h3>Daftar Semua Pembelian</h3>

    <!-- FORM CARI -->
    <form method="GET" style="margin-bottom: 20px; text-align:center;">
        <input type="text" name="cari" placeholder="Cari nama atau barang..." value="<?= htmlspecialchars($cari) ?>">
        <button type="submit"><i data-lucide="search"></i> Cari</button>
    </form>

    <!-- TABEL PEMBELIAN -->
    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Alamat</th>
            <th>Metode</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($semua_data)) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_pembeli']) ?></td>
                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= htmlspecialchars($row['metode_pembayaran']) ?></td>
                <td>
                    <a class="btn-edit" href="edit_pembelian.php?id=<?= $row['id'] ?>">Edit</a>
                    &nbsp;
                    <a class="btn-hapus" href="hapus_pembelian.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin mau hapus data ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- Aktifkan ikon lucide -->
<script>
    lucide.createIcons();
</script>
</body>
</html>