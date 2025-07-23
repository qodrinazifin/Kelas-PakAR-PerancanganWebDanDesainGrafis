<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Lucide Icons CDN -->
<script src="https://unpkg.com/lucide@latest"></script>

<style>
    .header-wrapper {
        background: #e3f2fd;
        padding: 10px 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        font-family: 'Segoe UI', sans-serif;
    }

    .navbar-atas,
    .navbar-bawah {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .logo {
        font-size: 24px;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 8px;
        color: #1976d2;
    }

    .logo img {
        width: 28px;
        height: 28px;
    }

    .search-box {
        flex: 1;
        max-width: 400px;
        display: flex;
        margin: 10px;
        background-color: white;
        border-radius: 25px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .search-box input {
        flex: 1;
        padding: 10px 15px;
        border: none;
        outline: none;
        font-size: 14px;
        background: none;
    }

    .search-box button {
        background-color: #1976d2;
        color: white;
        border: none;
        padding: 10px 16px;
        font-size: 16px;
        cursor: pointer;
    }

    .user-icons {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-icons a {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #1976d2;
        text-decoration: none;
        font-weight: 500;
    }

    .user-icons i {
        width: 24px;
        height: 24px;
    }

    .navbar-bawah {
        justify-content: center;
        gap: 25px;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .navbar-bawah a {
        text-decoration: none;
        color: #333;
        font-weight: 600;
        padding: 8px 10px;
        transition: 0.2s;
    }

    .navbar-bawah a:hover {
        color: #1976d2;
    }

    @media (max-width: 768px) {
        .navbar-atas {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            width: 100%;
            margin: 10px 0;
        }

        .user-icons {
            justify-content: center;
            margin-top: 10px;
        }

        .navbar-bawah {
            font-size: 14px;
            gap: 12px;
        }
    }

    @media (max-width: 480px) {
        .navbar-bawah {
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
    }
</style>

<div class="header-wrapper">
    <!-- Navbar Atas -->
    <div class="navbar-atas">
        <!-- Logo -->
        <div class="logo">
            <i data-lucide="home"></i>
            PARABOTAN KU
        </div>

        <!-- Search Box -->
        <?php if ($current_page !== 'chat_cs.php') : ?>
        <form class="search-box" action="pencarian.php" method="GET">
            <input type="text" name="keyword" placeholder="Cari..." required>
            <button type="submit">🔍</button>
        </form>
        <?php endif; ?>

        <!-- Icon User & Cart -->
        <div class="user-icons">
            <a href="akun.php"><i data-lucide="user-round"></i> <span>Akun</span></a>
            <a href="keranjang.php"><i data-lucide="shopping-cart"></i> <span>Keranjang</span></a>
        </div>
    </div>

    <!-- Navbar Bawah -->
    <div class="navbar-bawah">
        <a href="promo.php">Promo</a>
        <a href="index.php">Shop</a>
        <a href="riwayat.php">Riwayat</a>
        <a href="chat_cs.php">Chat CS</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- Inisialisasi Lucide -->
<script>
    lucide.createIcons();
</script>