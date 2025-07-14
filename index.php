<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM penghuni ORDER BY kamar ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Penghuni Kost</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 40px auto;
            background: rgba(255,255,255,0.90);
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
        .button {
            display: inline-block;
            background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);
            color: #fff;
            padding: 10px 28px;
            border-radius: 24px;
            text-decoration: none;
            margin-bottom: 22px;
            font-size: 1.1rem;
            font-weight: 500;
            border: none;
            box-shadow: 0 2px 8px rgba(0,123,255,0.10);
            transition: background 0.2s, transform 0.2s;
        }
        .button:hover {
            background: linear-gradient(90deg, #0056b3 0%, #0096c7 100%);
            transform: scale(1.04);
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: rgba(255,255,255,0.95);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }
        th, td {
            padding: 13px 14px;
            border-bottom: 1px solid #e0e0e0;
            text-align: left;
        }
        th {
            background: linear-gradient(90deg, #e3f0ff 0%, #f0fcff 100%);
            color: #007bff;
            font-size: 1.05rem;
            letter-spacing: 1px;
        }
        tr:last-child td {
            border-bottom: none;
        }
        tr:hover td {
            background: #f3faff;
            transition: background 0.2s;
        }
        a.hapus {
            color: #dc3545;
            text-decoration: none;
            font-weight: bold;
            border-radius: 4px;
            padding: 6px 14px;
            background: #ffeaea;
            transition: background 0.2s, color 0.2s;
        }
        a.hapus:hover {
            background: #ffb3b3;
            color: #fff;
        }
        @media (max-width: 600px) {
            .container {
                padding: 16px 4vw 24px 4vw;
            }
            th, td {
                padding: 8px 6px;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Penghuni Kost</h1>
        <a href="tambah.php" class="button">+ Tambah Penghuni</a>
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nomor Kamar</th>
                <th>Aksi</th>
            </tr>
            <?php $no=1; while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['kamar']) ?></td>
                <td>
                    <a href="hapus.php?id=<?= $row['id'] ?>" class="hapus" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html> 