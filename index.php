<?php
include 'koneksi.php';
// Ambil kamar kosong: kamar yang tidak ada di tb_kmr_penghuni dengan tgl_keluar NULL
$q = mysqli_query($conn, "SELECT k.nomor, k.harga FROM tb_kamar k LEFT JOIN tb_kmr_penghuni kp ON k.id = kp.id_kamar AND kp.tgl_keluar IS NULL WHERE kp.id IS NULL");
$kamar_kosong = [];
while ($row = mysqli_fetch_assoc($q)) {
    $kamar_kosong[] = $row;
}
// Ambil kamar harus bayar bulan ini
$bulan_ini = date('Y-m');
$q2 = mysqli_query($conn, "SELECT k.nomor, t.bulan FROM tb_tagihan t JOIN tb_kmr_penghuni kp ON t.id_kmr_penghuni = kp.id JOIN tb_kamar k ON kp.id_kamar = k.id WHERE t.bulan = '$bulan_ini' AND t.id NOT IN (SELECT id_tagihan FROM tb_bayar WHERE status = 'lunas')");
$kamar_bayar = [];
while ($row = mysqli_fetch_assoc($q2)) {
    $kamar_bayar[] = $row;
}
// Ambil kamar terlambat bayar: tagihan bulan lalu yang belum lunas
$bulan_lalu = date('Y-m', strtotime('first day of last month'));
$q3 = mysqli_query($conn, "SELECT k.nomor, t.bulan FROM tb_tagihan t JOIN tb_kmr_penghuni kp ON t.id_kmr_penghuni = kp.id JOIN tb_kamar k ON kp.id_kamar = k.id WHERE t.bulan = '$bulan_lalu' AND t.id NOT IN (SELECT id_tagihan FROM tb_bayar WHERE status = 'lunas')");
$kamar_telat = [];
$awal_bulan_ini = strtotime(date('Y-m-01'));
while ($row = mysqli_fetch_assoc($q3)) {
    $tgl_jatuh_tempo = $awal_bulan_ini; // anggap jatuh tempo awal bulan ini
    $hari_telat = floor((time() - $tgl_jatuh_tempo) / 86400);
    $row['hari_telat'] = $hari_telat;
    $kamar_telat[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Selamat Datang di Aplikasi Kost</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 60px auto;
            background: rgba(255,255,255,0.95);
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            padding: 36px 44px 44px 44px;
            border: 2px solid #e3e8f0;
            text-align: center;
        }
        h1 {
            color: #007bff;
            margin-bottom: 18px;
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
            margin-bottom: 24px;
            margin-top: 10px;
            box-shadow: 0 2px 8px rgba(0,123,255,0.10);
            transition: background 0.2s, transform 0.2s;
        }
        .button:hover {
            background: linear-gradient(90deg, #0056b3 0%, #0096c7 100%);
            transform: scale(1.04);
        }
        .section {
            background: #f7fafd;
            border-radius: 12px;
            margin: 18px 0;
            padding: 18px 18px 10px 18px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
            text-align: left;
        }
        .section h2 {
            color: #007bff;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }
        ul {
            margin: 0 0 0 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang di Aplikasi Kost</h1>
        <a href="login.php" class="button">Login Admin</a>
        <div class="section">
            <h2>Kamar Kosong & Harga Sewa</h2>
            <ul>
                <?php if (count($kamar_kosong) === 0): ?>
                    <li>Tidak ada kamar kosong saat ini.</li>
                <?php else: ?>
                    <?php foreach ($kamar_kosong as $k): ?>
                        <li>Kamar <?= htmlspecialchars($k['nomor']) ?> - Rp <?= number_format($k['harga'],0,',','.') ?></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <div class="section">
            <h2>Kamar Harus Bayar Bulan Ini</h2>
            <ul>
                <?php if (count($kamar_bayar) === 0): ?>
                    <li>Tidak ada kamar yang harus bayar bulan ini.</li>
                <?php else: ?>
                    <?php foreach ($kamar_bayar as $k): ?>
                        <li>Kamar <?= htmlspecialchars($k['nomor']) ?> - Jatuh tempo <?= htmlspecialchars($k['bulan']) ?></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <div class="section">
            <h2>Kamar Terlambat Bayar</h2>
            <ul>
                <?php if (count($kamar_telat) === 0): ?>
                    <li>Tidak ada kamar yang terlambat bayar.</li>
                <?php else: ?>
                    <?php foreach ($kamar_telat as $k): ?>
                        <li>Kamar <?= htmlspecialchars($k['nomor']) ?> - Telat <?= $k['hari_telat'] ?> hari</li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</body>
</html> 