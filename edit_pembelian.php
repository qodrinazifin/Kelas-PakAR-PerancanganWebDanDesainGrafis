 <?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    die("ID tidak valid");
}

$query = "SELECT * FROM pembelian WHERE id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak ditemukan");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pembelian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .form-container {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #1976d2;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            margin-top: 5px;
        }

        textarea {
            resize: vertical;
        }

        button[type="submit"] {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            background-color: #1976d2;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        }

        button[type="submit"]:hover {
            background-color: #125ea7;
        }

        @media (max-width: 500px) {
            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Edit Data Pembelian</h2>
    <form action="update_pembelian.php" method="POST">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <label>Nama Pembeli:</label>
        <input type="text" name="nama_pembeli" value="<?= htmlspecialchars($data['nama_pembeli']) ?>" required>

        <label>Nama Barang:</label>
        <input type="text" name="nama_barang" value="<?= htmlspecialchars($data['nama_barang']) ?>" required>

        <label>Jumlah:</label>
        <input type="number" name="jumlah" value="<?= $data['jumlah'] ?>" required>

        <label>Alamat:</label>
        <textarea name="alamat" required><?= htmlspecialchars($data['alamat']) ?></textarea>

        <label>Metode Pembayaran:</label>
        <select name="metode_pembayaran" required>
            <?php
            $metode = ["COD", "Transfer Bank", "QRIS", "E-Wallet"];
            foreach ($metode as $m) {
                $selected = $data['metode_pembayaran'] == $m ? "selected" : "";
                echo "<option value='$m' $selected>$m</option>";
            }
            ?>
        </select>

        <button type="submit">💾 Simpan Perubahan</button>
    </form>
</div>

</body>
</html>