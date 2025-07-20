<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
// Query pembayaran
$q = mysqli_query($conn, "SELECT b.id, p.nama AS penghuni, k.nomor AS kamar, t.bulan, t.jml_tagihan, b.jml_bayar, b.tgl_bayar FROM tb_bayar b JOIN tb_tagihan t ON b.id_tagihan=t.id JOIN tb_kmr_penghuni kp ON t.id_kmr_penghuni=kp.id JOIN tb_penghuni p ON kp.id_penghuni=p.id JOIN tb_kamar k ON kp.id_kamar=k.id ORDER BY b.tgl_bayar DESC, p.nama");
if ($q === false) { die('Query error: ' . mysqli_error($conn)); }
$data = [];
while($row = mysqli_fetch_assoc($q)) $data[] = $row;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; background: url('background.jpg') no-repeat center center fixed; background-size: cover; margin: 0; padding: 0; }
        .container { max-width: 950px; margin: 60px auto; background: rgba(255,255,255,0.92); border-radius: 14px; box-shadow: 0 4px 24px rgba(0,0,0,0.10); padding: 32px 32px 24px 32px; }
        h1 { text-align: center; color: #007bff; }
        .button { background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%); color: #fff; border: none; padding: 8px 18px; border-radius: 24px; font-size: 15px; cursor: pointer; margin-bottom: 18px; text-decoration: none; display: inline-block; transition: background 0.2s; }
        .button:hover { background: linear-gradient(90deg, #0056b3 0%, #0096c7 100%); }
        table { width: 100%; border-collapse: collapse; margin-top: 18px; }
        th, td { border: 1px solid #ddd; padding: 8px 10px; text-align: left; }
        th { background: #f0f8ff; color: #007bff; }
        td { background: #fff; }
        .aksi-btn { margin-right: 6px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kelola Pembayaran</h1>
        <a href="tambah_pembayaran.php" class="button">+ Tambah Pembayaran</a>
        <a href="admin.php" class="button" style="background:#6c757d;">&larr; Kembali ke Menu Admin</a>
        <table>
            <thead>
                <tr>
                    <th>Penghuni</th>
                    <th>Kamar</th>
                    <th>Bulan</th>
                    <th>Tagihan</th>
                    <th>Jumlah Bayar</th>
                    <th>Tanggal Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['penghuni']) ?></td>
                    <td><?= htmlspecialchars($row['kamar']) ?></td>
                    <td><?= htmlspecialchars($row['bulan']) ?></td>
                    <td>Rp <?= number_format($row['jml_tagihan'],0,',','.') ?></td>
                    <td>Rp <?= number_format($row['jml_bayar'],0,',','.') ?></td>
                    <td><?= htmlspecialchars($row['tgl_bayar']) ?></td>
                    <td>
                        <a href="edit_pembayaran.php?id=<?= $row['id'] ?>" class="button" style="background:#ffc107; color:#222;">Edit</a>
                        <a href="hapus_pembayaran.php?id=<?= $row['id'] ?>" class="button" style="background:#dc3545;" onclick="return confirm('Yakin ingin menghapus pembayaran ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html> 