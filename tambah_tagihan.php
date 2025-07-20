<?php
ob_start();
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
// Relasi kamar-penghuni aktif
$relasi = mysqli_query($conn, "SELECT kp.id, p.nama, k.nomor FROM tb_kmr_penghuni kp JOIN tb_penghuni p ON kp.id_penghuni=p.id JOIN tb_kamar k ON kp.id_kamar=k.id WHERE kp.tgl_keluar IS NULL ORDER BY p.nama, k.nomor");
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kmr_penghuni = (int)($_POST['id_kmr_penghuni'] ?? 0);
    $bulan = $_POST['bulan'] ?? '';
    $jml_tagihan = (int)($_POST['jml_tagihan'] ?? 0);
    if ($id_kmr_penghuni < 1 || !$bulan || $jml_tagihan < 1) {
        $message = 'Lengkapi data!';
    } else {
        mysqli_query($conn, "INSERT INTO tb_tagihan (id_kmr_penghuni, bulan, jml_tagihan) VALUES ('$id_kmr_penghuni', '$bulan', '$jml_tagihan')");
        header('Location: kelola_tagihan.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Tagihan</title>
    <style>
        body { font-family: Arial, sans-serif; background: url('background.jpg') no-repeat center center fixed; background-size: cover; margin: 0; padding: 0; }
        .container { max-width: 400px; margin: 60px auto; background: rgba(255,255,255,0.92); border-radius: 14px; box-shadow: 0 4px 24px rgba(0,0,0,0.10); padding: 32px 32px 24px 32px; }
        h1 { text-align: center; color: #007bff; }
        form { display: flex; flex-direction: column; gap: 14px; }
        select, input[type="month"], input[type="number"] { padding: 8px 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px; }
        button { background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%); color: #fff; border: none; padding: 10px 0; border-radius: 24px; font-size: 16px; cursor: pointer; margin-top: 8px; transition: background 0.2s; }
        button:hover { background: linear-gradient(90deg, #0056b3 0%, #0096c7 100%); }
        .info { color: #dc3545; text-align: center; margin-bottom: 10px; }
        a { display: inline-block; margin-top: 18px; color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Tagihan</h1>
        <?php if ($message): ?>
            <div class="info"><?= $message ?></div>
        <?php endif; ?>
        <form method="post">
            <label>Penghuni & Kamar:
                <select name="id_kmr_penghuni" required>
                    <option value="">-- Pilih Penghuni & Kamar --</option>
                    <?php while($r = mysqli_fetch_assoc($relasi)): ?>
                        <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['nama']) ?> (Kamar <?= htmlspecialchars($r['nomor']) ?>)</option>
                    <?php endwhile; ?>
                </select>
            </label>
            <label>Bulan:
                <input type="month" name="bulan" required>
            </label>
            <label>Jumlah Tagihan:
                <input type="number" name="jml_tagihan" min="1" required>
            </label>
            <button type="submit">Simpan</button>
        </form>
        <a href="kelola_tagihan.php">&larr; Kembali ke Tagihan</a>
    </div>
<?php ob_end_flush(); ?>
</body>
</html> 