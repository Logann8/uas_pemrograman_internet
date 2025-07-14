<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
$penghuni = [];
$res = mysqli_query($conn, "SELECT * FROM penghuni");
while ($row = mysqli_fetch_assoc($res)) {
    $penghuni[$row['kamar']] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Kamar Kost</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            background: rgba(255,255,255,0.95);
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            padding: 36px 44px 44px 44px;
            border: 2px solid #e3e8f0;
            animation: fadeIn 1.2s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 28px;
        }
        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            justify-content: center;
        }
        .kamar-box {
            width: 90px;
            height: 110px;
            background: #f7fafd;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .nomor {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .status {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            margin-bottom: 8px;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #e3e8f0;
        }
        .isi {
            background: #28a745;
        }
        .kosong {
            background: #dc3545;
        }
        .nama {
            font-size: 0.95rem;
            color: #333;
            text-align: center;
            margin-bottom: 6px;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);
            color: #fff;
            padding: 5px 14px;
            border-radius: 12px;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            border: none;
            box-shadow: 0 2px 8px rgba(0,123,255,0.10);
            transition: background 0.2s, transform 0.2s;
            cursor: pointer;
        }
        .btn:hover {
            background: linear-gradient(90deg, #0056b3 0%, #0096c7 100%);
            transform: scale(1.04);
        }
        @media (max-width: 600px) {
            .container {
                padding: 16px 2vw 24px 2vw;
            }
            .grid {
                gap: 10px;
            }
            .kamar-box {
                width: 70px;
                height: 90px;
            }
            .nomor {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard Kamar Kost</h1>
        <div class="grid">
            <?php for ($i=1; $i<=30; $i++): ?>
            <div class="kamar-box">
                <div class="nomor"><?= $i ?></div>
                <div class="status <?= isset($penghuni[$i]) ? 'isi' : 'kosong' ?>"></div>
                <?php if (isset($penghuni[$i])): ?>
                    <div class="nama">ISI<br><?= htmlspecialchars($penghuni[$i]['nama']) ?></div>
                <?php else: ?>
                    <div class="nama" style="color:#dc3545;">KOSONG</div>
                    <a href="tambah.php?kamar=<?= $i ?>" class="btn">Isi Data</a>
                <?php endif; ?>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</body>
</html> 