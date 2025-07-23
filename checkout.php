 <?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Ambil data keranjang
$keranjang = $_SESSION['keranjang'] ?? [];

// Kalau keranjang kosong, kembali ke halaman keranjang
if (empty($keranjang)) {
    header("Location: keranjang.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #2d89ef;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        label {
            font-weight: bold;
        }

        textarea, select, button {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        button:hover {
            background-color: #218838;
        }

        .btn-lokasi {
            background-color: #007bff;
        }

        .btn-lokasi:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>


<div class="container">
    <h2><i data-lucide="shopping-cart-check"></i> Checkout Pembelian</h2>

    <form action="proses_checkout.php" method="POST">
        <label for="alamat">Alamat Pengiriman:</label>
        <textarea name="alamat" id="alamat" rows="4" placeholder="Masukkan alamat lengkap..." required></textarea>

        <button type="button" class="btn-lokasi" onclick="getLocation()">
            <i data-lucide="map-pin"></i> Gunakan Lokasi Saat Ini
        </button>

        <label for="metode_pembayaran">Metode Pembayaran:</label>
        <select name="metode_pembayaran" id="metode_pembayaran" required>
            <option value="">-- Pilih Metode --</option>
            <option value="COD">COD</option>
            <option value="Transfer Bank">Transfer Bank</option>
            <option value="QRIS">QRIS</option>
            <option value="E-Wallet">E-Wallet</option>
        </select>

        <button type="submit">
            <i data-lucide="check-circle"></i> Konfirmasi Checkout
        </button>
    </form>
</div>

<script>
    lucide.createIcons();

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showAddress, showError);
        } else {
            alert("Geolocation tidak didukung di browser ini.");
        }
    }

    function showAddress(position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const alamatLengkap = data.display_name;
                document.getElementById("alamat").value = alamatLengkap;
            })
            .catch(error => {
                alert("Gagal mengambil alamat. Coba lagi.");
                console.error(error);
            });
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                alert("❌ Akses lokasi ditolak.");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("❌ Informasi lokasi tidak tersedia.");
                break;
            case error.TIMEOUT:
                alert("❌ Waktu pengambilan lokasi habis.");
                break;
            default:
                alert("❌ Terjadi kesalahan saat mengambil lokasi.");
        }
    }
</script>

</body>
</html>