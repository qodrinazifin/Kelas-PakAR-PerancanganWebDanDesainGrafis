 <?php
session_start();

// Cek apakah user sudah login dan role-nya "user"
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "user") {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

// Ambil data transaksi milik user yang sedang login
$username = $_SESSION['username'];
$query = "SELECT * FROM pembelian WHERE nama_pembeli = '$username' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pembelian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #e3f2fd, #bbdefb);
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #1976d2;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow-x: auto;
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #1976d2;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f7faff;
        }

        tr:hover {
            background-color: #e3f2fd;
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }

            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                display: none;
            }

            tr {
                margin-bottom: 15px;
                background: white;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                border-radius: 8px;
                padding: 10px;
            }

            td {
                padding: 10px;
                border: none;
                position: relative;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                display: block;
                margin-bottom: 5px;
                color: #1976d2;
            }
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="container">
    <h2>🧾 Riwayat Pembelian Anda</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Alamat</th>
                <th>Metode Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td data-label='No'>$no</td>";
                echo "<td data-label='Nama Barang'>" . htmlspecialchars($row['nama_barang']) . "</td>";
                echo "<td data-label='Jumlah'>" . $row['jumlah'] . "</td>";
                echo "<td data-label='Alamat'>" . htmlspecialchars($row['alamat']) . "</td>";
                echo "<td data-label='Metode Pembayaran'>" . htmlspecialchars($row['metode_pembayaran']) . "</td>";
                echo "</tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>