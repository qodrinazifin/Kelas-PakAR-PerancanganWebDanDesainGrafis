<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $diskon = $_POST['diskon'] ?? 0;
    $promo = isset($_POST['promo']) ? 1 : 0;

    $nama_file = $_FILES['gambar']['name'];
    $tmp_file = $_FILES['gambar']['tmp_name'];

    $lokasi_simpan = "gambar/" . basename($nama_file);

    if (move_uploaded_file($tmp_file, $lokasi_simpan)) {
        $conn = mysqli_connect("localhost", "root", "", "webku_db");
        $sql = "INSERT INTO produk (nama_barang, harga, gambar, promo, diskon)
                VALUES ('$nama', '$harga', '$nama_file', '$promo', '$diskon')";
        mysqli_query($conn, $sql);
        echo "<p style='text-align:center; color:green;'>✅ Produk berhasil ditambahkan!</p>";
    } else {
        echo "<p style='text-align:center; color:red;'>❌ Gagal upload gambar.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #e3f2fd, #bbdefb);
            margin: 0;
            padding: 0;
        }

        .form-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #1976d2;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        input[type="checkbox"] {
            margin-right: 8px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #1976d2;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #125ea7;
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>🛒 Tambah Produk</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Nama Barang:</label>
        <input type="text" name="nama_barang" required>

        <label>Harga (Rp):</label>
        <input type="number" name="harga" required>

        <label>Diskon (%):</label>
        <input type="number" name="diskon" min="0" max="100" placeholder="0 jika tidak ada" required>

        <label>Gambar:</label>
        <input type="file" name="gambar" accept="image/*" required>

        <label>
            <input type="checkbox" name="promo">
            Tandai sebagai promo
        </label>

        <button type="submit">Tambah Produk</button>
    </form>
</div>

</body>
</html>