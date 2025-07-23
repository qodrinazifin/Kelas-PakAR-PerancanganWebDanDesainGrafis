<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}
include "koneksi.php";

// Ambil data pembelian dari tabel
$sql = "SELECT * FROM pembelian ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pembelian</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        table {
            width: 90%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #aaa;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #2d89ef;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>
    <h2>Riwayat Pembelian</h2>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Pembeli</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Alamat</th>
            <th>Metode Pembayaran</th>
        </tr>

        <?php
        $no = 1;
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row["nama_pembeli"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["nama_barang"]) . "</td>";
                echo "<td>" . $row["jumlah"] . "</td>";
                echo "<td>" . htmlspecialchars($row["alamat"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["metode_pembayaran"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Belum ada data pembelian.</td></tr>";
        }
        ?>
    </table>
</body>
</html>