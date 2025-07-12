<?php
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM penghuni");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Penghuni Kost</title>
</head>
<body>
    <h1>Daftar Penghuni Kost</h1>
    <a href="tambah.php">Tambah Penghuni</a>
    <table border="1" cellpadding="8">
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
                <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html> 