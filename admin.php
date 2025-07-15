<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Kost - Menu Utama</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 60px auto;
            background: rgba(255,255,255,0.97);
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            padding: 36px 44px 44px 44px;
            border: 2px solid #e3e8f0;
            text-align: center;
        }
        h1 {
            color: #007bff;
            margin-bottom: 28px;
        }
        .menu {
            display: flex;
            flex-direction: column;
            gap: 18px;
            margin: 0 auto;
            max-width: 350px;
        }
        .menu a {
            display: block;
            background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);
            color: #fff;
            padding: 14px 0;
            border-radius: 24px;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(0,123,255,0.10);
            transition: background 0.2s, transform 0.2s;
        }
        .menu a:hover {
            background: linear-gradient(90deg, #0056b3 0%, #0096c7 100%);
            transform: scale(1.04);
        }
        .info-link {
            margin-top: 30px;
            color: #007bff;
            text-decoration: underline;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Menu Admin Kost</h1>
        <div class="menu">
            <a href="kelola_penghuni.php">Data Penghuni</a>
            <a href="kelola_kamar.php">Data Kamar</a>
            <a href="kelola_barang.php">Data Barang</a>
            <a href="kelola_kmr_penghuni.php">Data Kamar-Penghuni</a>
            <a href="kelola_barang_bawaan.php">Data Barang Bawaan</a>
            <a href="kelola_tagihan.php">Data Tagihan</a>
            <a href="kelola_pembayaran.php">Data Pembayaran</a>
            <a href="generate_tagihan.php">Generate Tagihan</a>
        </div>
        <a href="index.php" class="info-link">Lihat Info Kamar & Tagihan (Halaman Depan)</a>
    </div>
</body>
</html> 