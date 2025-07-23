 <?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "user") {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

// Proses kirim pesan jika form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama_pengirim = $_SESSION["username"];
    $isi_pesan = mysqli_real_escape_string($conn, $_POST["isi_pesan"]);

    // Simpan ke database
    $query = "INSERT INTO pesan_cs (nama_pengirim, isi_pesan) VALUES ('$nama_pengirim', '$isi_pesan')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('✅ Pesan berhasil dikirim ke CS!'); window.location.href='chat_cs.php';</script>";
        exit;
    } else {
        echo "<script>alert('❌ Gagal mengirim pesan. Coba lagi.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Chat ke CS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #e3f2fd, #bbdefb);
            margin: 0;
            padding: 0;
        }

        .container {
            width: 95%;
            max-width: 600px;
            margin: 120px auto 50px;
            background: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            color: #1976d2;
            margin-bottom: 25px;
            font-size: 22px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 16px;
        }

        textarea {
            width: 100%;
            height: 160px;
            padding: 15px;
            font-size: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            resize: vertical;
            background-color: #f9f9f9;
            transition: 0.3s ease;
        }

        textarea:focus {
            border-color: #1976d2;
            outline: none;
            background-color: #fff;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #1976d2;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #1565c0;
        }

        @media (max-width: 600px) {
            .container {
                margin: 100px 15px 40px;
                padding: 20px;
            }

            textarea {
                height: 130px;
            }

            h2 {
                font-size: 20px;
            }

            button {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="container">
    <h2>💬 Kirim Pesan ke Customer Service</h2>
    <form method="POST">
        <label for="isi_pesan">Pesan Anda:</label>
        <textarea name="isi_pesan" id="isi_pesan" placeholder="Tulis pesan Anda di sini..." required></textarea>
        <button type="submit">📨 Kirim Pesan</button>
    </form>
</div>

</body>
</html>