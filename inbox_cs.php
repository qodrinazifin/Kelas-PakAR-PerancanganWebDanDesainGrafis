 <?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

// Ambil semua pesan dari database
$pesan = mysqli_query($conn, "SELECT * FROM pesan_cs ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Inbox CS - Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin-top: 20px;
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

        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>



<div class="container">
    <h2>📬 Inbox Customer Service</h2>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Pengirim</th>
            <th>Isi Pesan</th>
            <th>Tanggal</th>
        </tr>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($pesan)) {
            echo "<tr>";
            echo "<td>$no</td>";
            echo "<td>" . htmlspecialchars($row['nama_pengirim']) . "</td>";
            echo "<td>" . htmlspecialchars($row['isi_pesan']) . "</td>";
            echo "<td>" . $row['tanggal'] . "</td>";
            echo "</tr>";
            $no++;
        }
        ?>
    </table>
</div>

</body>
</html>