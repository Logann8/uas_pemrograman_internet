<?php
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM penghuni");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Penghuni Kost</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 32px 40px 40px 40px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        a.button {
            display: inline-block;
            background: #007bff;
            color: #fff;
            padding: 8px 18px;
            border-radius: 4px;
            text-decoration: none;
            margin-bottom: 18px;
            transition: background 0.2s;
        }
        a.button:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px 12px;
            border-bottom: 1px solid #e0e0e0;
            text-align: left;
        }
        th {
            background: #f0f4f8;
        }
        tr:last-child td {
            border-bottom: none;
        }
        a.hapus {
            color: #dc3545;
            text-decoration: none;
            font-weight: bold;
        }
        a.hapus:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Penghuni Kost</h1>
        <a href="tambah.php" class="button">Tambah Penghuni</a>
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kamar</th>
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