<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Proses upload foto jika ada
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    $foto = $_FILES['foto'];
    $fotoName = time() . "_" . basename($foto['name']);
    $tmp = $foto['tmp_name'];
    $target = "gambar/" . $fotoName;

    if (move_uploaded_file($tmp, $target)) {
        mysqli_query($conn, "UPDATE users SET foto = '$fotoName' WHERE username = '$username'");
        header("Location: akun.php");
        exit;
    } else {
        echo "<script>alert('Gagal upload foto.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil Akun</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #e3f2fd, #bbdefb);
            margin: 0;
            padding: 0;
        }

        .akun-container {
            max-width: 450px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            text-align: center;
        }

        .akun-container h2 {
            color: #1976d2;
            margin-bottom: 25px;
        }

        .foto-profil {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
            box-shadow: 0 0 8px rgba(0,0,0,0.15);
            cursor: pointer;
            border: 3px solid #e0e0e0;
        }

        .akun-container p {
            font-size: 16px;
            margin: 10px 0;
        }

        .logout-btn {
            background: #dc3545;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            display: inline-block;
            margin-top: 20px;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: #c82333;
        }

        input[type="file"] {
            display: none;
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="akun-container">
    <h2>👤 Profil Akun</h2>

    <!-- Form tersembunyi untuk upload gambar -->
    <form method="POST" enctype="multipart/form-data" id="uploadForm">
        <label for="foto">
            <img src="gambar/<?= $data['foto'] ?? 'profil.jpg' ?>" class="foto-profil" alt="Foto Profil">
        </label>
        <input type="file" name="foto" id="foto" accept="image/*" onchange="document.getElementById('uploadForm').submit();">
    </form>

    <p><strong>Username:</strong> <?= htmlspecialchars($data['username']) ?></p>
    <p><strong>Password:</strong> <?= str_repeat("•", 10) ?></p>
    <p><strong>Alamat:</strong> <?= $data['alamat'] ?? 'Belum diisi' ?></p>
    <p><strong>Metode Pembayaran:</strong> <?= $data['metode_pembayaran'] ?? 'Belum diatur' ?></p>

    <a href="logout.php" class="logout-btn">Keluar</a>
</div>

</body>
</html>