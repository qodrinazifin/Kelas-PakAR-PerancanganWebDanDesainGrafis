<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
$keranjang = $_SESSION['keranjang'] ?? [];
$current_page = 'keranjang'; // untuk dipakai di header.php
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
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

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #1976d2;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #1976d2;
            color: white;
        }

        tr:last-child td {
            border-bottom: none;
        }

       .btn-checkout {
    display: inline-block;
    margin: 30px auto;
    background-color: #1e88e5;
    color: white;
    padding: 10px 20px;
    font-size: 15px;
    font-weight: 600;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    transition: background 0.3s ease, transform 0.2s ease;
}

.btn-checkout:hover {
    background-color: #1565c0;
    transform: translateY(-2px);
}

        .btn-hapus {
            background-color: #e53935;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .btn-hapus:hover {
            background-color: #c62828;
        }

        .qty-btn {
            background-color: #1976d2;
            color: white;
            border: none;
            padding: 6px 10px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 3px;
        }

        @media (max-width: 600px) {
            table, th, td {
                font-size: 14px;
            }

            .btn-checkout {
                width: 90%;
                font-size: 15px;
            }

            .qty-btn {
                padding: 5px 8px;
                font-size: 13px;
            }
        }

        .checkout-wrapper {
    width: 80%;
    margin: 20px auto;
    display: flex;
    justify-content: flex-end;
}

.btn-checkout {
    background-color: #1e88e5;
    color: white;
    padding: 10px 18px;
    font-size: 15px;
    font-weight: 600;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    transition: background 0.3s ease, transform 0.2s ease;
}

.btn-checkout:hover {
    background-color: #1565c0;
    transform: translateY(-2px);
}

@media (max-width: 600px) {
    .checkout-wrapper {
        width: 95%;
        justify-content: center;
    }

    .btn-checkout {
        width: 100%;
        text-align: center;
    }
}
    </style>
</head>
<body>

<?php include "header.php"; ?> 

<?php if (isset($_GET['status']) && $_GET['status'] === 'checkout_sukses') : ?>
    <p style="text-align: center; color: green; font-weight: bold;"> Checkout berhasil! Terima kasih belanjanya!</p>
<?php endif; ?>

<h2>🛒 Keranjang Belanja</h2>

<?php if (empty($keranjang)) : ?>
    <p style="text-align:center;">Keranjang masih kosong.</p>
<?php else: ?>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 1;
        $grand_total = 0;
        foreach ($keranjang as $index => $item) :
            $total = $item['harga'] * $item['qty'];
            $grand_total += $total;
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($item['nama']) ?></td>
            <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
            <td>
                <form action="ubah_jumlah.php" method="POST" style="display:inline;">
                    <input type="hidden" name="index" value="<?= $index ?>">
                    <button type="submit" name="aksi" value="kurang" class="qty-btn">➖</button>
                </form>
                <?= $item['qty'] ?>
                <form action="ubah_jumlah.php" method="POST" style="display:inline;">
                    <input type="hidden" name="index" value="<?= $index ?>">
                    <button type="submit" name="aksi" value="tambah" class="qty-btn">➕</button>
                </form>
            </td>
            <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
            <td>
                <form action="hapus_keranjang.php" method="POST" style="display:inline;">
                    <input type="hidden" name="index" value="<?= $index ?>">
                    <button type="submit" class="btn-hapus">🗑 Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="checkout-wrapper">
    <a href="checkout.php" class="btn-checkout">Checkout Sekarang</a>
</div>
<?php endif; ?>

</body>
</html>