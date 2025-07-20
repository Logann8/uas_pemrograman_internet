<?php
ob_start();
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
// Tagihan yang belum lunas (belum ada pembayaran status 'lunas')
$tagihan = mysqli_query($conn, "SELECT t.id, p.nama, k.nomor, t.bulan, t.jml_tagihan FROM tb_tagihan t JOIN tb_kmr_penghuni kp ON t.id_kmr_penghuni=kp.id JOIN tb_penghuni p ON kp.id_penghuni=p.id JOIN tb_kamar k ON kp.id_kamar=k.id WHERE t.id NOT IN (SELECT id_tagihan FROM tb_bayar WHERE status='lunas') ORDER BY p.nama, t.bulan");
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tagihan = (int)($_POST['id_tagihan'] ?? 0);
    $jml_bayar = (int)($_POST['jml_bayar'] ?? 0);
    $tgl_bayar = $_POST['tgl_bayar'] ?? date('Y-m-d');
    $status = $_POST['status'] ?? '';
    if ($id_tagihan < 1 || $jml_bayar < 1 || !$tgl_bayar || ($status != 'lunas' && $status != 'cicil')) {
        $message = 'Lengkapi data!';
    } else {
        mysqli_query($conn, "INSERT INTO tb_bayar (id_tagihan, jml_bayar, tgl_bayar, status) VALUES ('$id_tagihan', '$jml_bayar', '$tgl_bayar', '$status')");
        header('Location: kelola_pembayaran.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; background: url('background.jpg') no-repeat center center fixed; background-size: cover; margin: 0; padding: 0; }
        .container { max-width: 400px; margin: 60px auto; background: rgba(255,255,255,0.92); border-radius: 14px; box-shadow: 0 4px 24px rgba(0,0,0,0.10); padding: 32px 32px 24px 32px; }
        h1 { text-align: center; color: #007bff; }
        form { display: flex; flex-direction: column; gap: 14px; }
        select, input[type="number"], input[type="date"] { padding: 8px 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px; }
        button { background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%); color: #fff; border: none; padding: 10px 0; border-radius: 24px; font-size: 16px; cursor: pointer; margin-top: 8px; transition: background 0.2s; }
        button:hover { background: linear-gradient(90deg, #0056b3 0%, #0096c7 100%); }
        .info { color: #dc3545; text-align: center; margin-bottom: 10px; }
        a { display: inline-block; margin-top: 18px; color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Pembayaran</h1>
        <?php if ($message): ?>
            <div class="info"><?= $message ?></div>
        <?php endif; ?>
        <form method="post">
            <label>Tagihan:
                <select name="id_tagihan" required>
                    <option value="">-- Pilih Tagihan --</option>
                    <?php while($t = mysqli_fetch_assoc($tagihan)): ?>
                        <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nama']) ?> (Kamar <?= htmlspecialchars($t['nomor']) ?>, Bulan <?= htmlspecialchars($t['bulan']) ?>, Rp <?= number_format($t['jml_tagihan'],0,',','.') ?>)</option>
                    <?php endwhile; ?>
                </select>
            </label>
            <label>Jumlah Bayar:
                <input type="number" name="jml_bayar" min="1" required>
            </label>
            <label>Tanggal Bayar:
                <input type="date" name="tgl_bayar" value="<?= date('Y-m-d') ?>" required>
            </label>
            <label>Status:
                <select name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="lunas">Lunas</option>
                    <option value="cicil">Cicil</option>
                </select>
            </label>
            <button type="submit">Simpan</button>
        </form>
        <a href="kelola_pembayaran.php">&larr; Kembali ke Pembayaran</a>
    </div>
<?php ob_end_flush(); ?>
</body>
</html> 