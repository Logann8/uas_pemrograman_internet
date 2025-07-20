<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
$info = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bulan = date('Y-m');
    $q = mysqli_query($conn, "SELECT kp.id AS id_kmr_penghuni, k.harga FROM tb_kmr_penghuni kp JOIN tb_kamar k ON kp.id_kamar=k.id WHERE kp.tgl_keluar IS NULL");
    $count = 0;
    while ($row = mysqli_fetch_assoc($q)) {
        $id_kmr_penghuni = $row['id_kmr_penghuni'];
        $harga = $row['harga'];
        // Cek sudah ada tagihan bulan ini?
        $cek = mysqli_query($conn, "SELECT 1 FROM tb_tagihan WHERE id_kmr_penghuni='$id_kmr_penghuni' AND bulan='$bulan'");
        if (mysqli_num_rows($cek) == 0) {
            mysqli_query($conn, "INSERT INTO tb_tagihan (id_kmr_penghuni, bulan, jml_tagihan) VALUES ('$id_kmr_penghuni', '$bulan', '$harga')");
            $count++;
        }
    }
    $info = "Tagihan baru berhasil dibuat: $count";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Generate Tagihan Bulan Ini</title>
    <style>
        body { font-family: Arial, sans-serif; background: url('background.jpg') no-repeat center center fixed; background-size: cover; margin: 0; padding: 0; }
        .container { max-width: 400px; margin: 60px auto; background: rgba(255,255,255,0.92); border-radius: 14px; box-shadow: 0 4px 24px rgba(0,0,0,0.10); padding: 32px 32px 24px 32px; }
        h1 { text-align: center; color: #007bff; }
        form { display: flex; flex-direction: column; gap: 14px; align-items: center; }
        button { background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%); color: #fff; border: none; padding: 12px 0; border-radius: 24px; font-size: 18px; cursor: pointer; width: 100%; margin-top: 18px; transition: background 0.2s; }
        button:hover { background: linear-gradient(90deg, #0056b3 0%, #0096c7 100%); }
        .info { color: #28a745; text-align: center; margin-bottom: 10px; font-weight: bold; }
        a { display: inline-block; margin-top: 18px; color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Generate Tagihan Bulan Ini</h1>
        <?php if ($info): ?>
            <div class="info"><?= $info ?></div>
        <?php endif; ?>
        <form method="post">
            <button type="submit">Generate Tagihan Bulan <?= date('Y-m') ?></button>
        </form>
        <a href="admin.php">&larr; Kembali ke Menu Admin</a>
    </div>
</body>
</html> 