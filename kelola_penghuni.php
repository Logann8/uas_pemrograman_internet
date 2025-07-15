<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
$penghuni = mysqli_query($conn, "SELECT * FROM tb_penghuni ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Data Penghuni</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            background: rgba(255,255,255,0.97);
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            padding: 36px 44px 44px 44px;
            border: 2px solid #e3e8f0;
        }
        h1 {
            color: #007bff;
            margin-bottom: 24px;
            text-align: center;
        }
        .button {
            display: inline-block;
            background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);
            color: #fff;
            padding: 10px 28px;
            border-radius: 24px;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            border: none;
            margin-bottom: 18px;
            margin-right: 10px;
            box-shadow: 0 2px 8px rgba(0,123,255,0.10);
            transition: background 0.2s, transform 0.2s;
        }
        .button:hover {
            background: linear-gradient(90deg, #0056b3 0%, #0096c7 100%);
            transform: scale(1.04);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }
        th, td {
            padding: 12px 14px;
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
        .aksi-btn {
            background: #ffeaea;
            color: #dc3545;
            border: none;
            border-radius: 8px;
            padding: 6px 14px;
            font-size: 1rem;
            font-weight: bold;
            margin-right: 6px;
            transition: background 0.2s, color 0.2s;
            cursor: pointer;
        }
        .aksi-btn:hover {
            background: #ffb3b3;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kelola Data Penghuni</h1>
        <a href="tambah_penghuni.php" class="button">+ Tambah Penghuni</a>
        <a href="admin.php" class="button" style="background:#6c757d;">&larr; Kembali ke Menu Admin</a>
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No. KTP</th>
                <th>No. HP</th>
                <th>Tgl Masuk</th>
                <th>Tgl Keluar</th>
                <th>Aksi</th>
            </tr>
            <?php $no=1; while($row = mysqli_fetch_assoc($penghuni)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['no_ktp']) ?></td>
                <td><?= htmlspecialchars($row['no_hp']) ?></td>
                <td><?= htmlspecialchars($row['tgl_masuk']) ?></td>
                <td><?= htmlspecialchars($row['tgl_keluar']) ?></td>
                <td>
                    <a href="edit_penghuni.php?id=<?= $row['id'] ?>" class="aksi-btn">Edit</a>
                    <button class="aksi-btn" disabled>Hapus</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html> 