<?php
ob_start();
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
$id = (int)($_GET['id'] ?? 0);
if ($id < 1) {
    header('Location: kelola_pembayaran.php');
    exit;
}
// Ambil data pembayaran
$q = mysqli_query($conn, "SELECT b.*, p.nama AS penghuni, k.nomor AS kamar, t.bulan, t.jml_tagihan FROM tb_bayar b JOIN tb_tagihan t ON b.id_tagihan=t.id JOIN tb_kmr_penghuni kp ON t.id_kmr_penghuni=kp.id JOIN tb_penghuni p ON kp.id_penghuni=p.id JOIN tb_kamar k ON kp.id_kamar=k.id WHERE b.id='$id'");
$data = mysqli_fetch_assoc($q);
if (!$data) {
    header('Location: kelola_pembayaran.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jml_bayar = (int)($_POST['jml_bayar'] ?? 0);
    $tgl_bayar = $_POST['tgl_bayar'] ?? date('Y-m-d');
    $status = $_POST['status'] ?? '';
    if ($jml_bayar > 0 && $tgl_bayar && ($status == 'lunas' || $status == 'cicil')) {
        mysqli_query($conn, "UPDATE tb_bayar SET jml_bayar='$jml_bayar', tgl_bayar='$tgl_bayar', status='$status' WHERE id='$id'");
        header('Location: kelola_pembayaran.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; background: url('background.jpg') no-repeat center center fixed; background-size: cover; margin: 0; padding: 0; }
        .container { max-width: 400px; margin: 60px auto; background: rgba(255,255,255,0.92); border-radius: 14px; box-shadow: 0 4px 24px rgba(0,0,0,0.10); padding: 32px 32px 24px 32px; }
        h1 { text-align: center; color: #007bff; }
        form { display: flex; flex-direction: column; gap: 14px; }
        input[type="number"], input[type="date"], select, input[readonly] { padding: 8px 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px; }
        input[readonly] { background: #f5f5f5; color: #555; border: none; }
        button { background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%); color: #fff; border: none; padding: 10px 0; border-radius: 24px; font-size: 16px; cursor: pointer; margin-top: 8px; transition: background 0.2s; }
        button:hover { background: linear-gradient(90deg, #0056b3 0%, #0096c7 100%); }
        .info { color: #dc3545; text-align: center; margin-bottom: 10px; }
        a { display: inline-block; margin-top: 18px; color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Pembayaran</h1>
        <form method="post">
            <label>Tagihan:
                <input type="text" value="<?= htmlspecialchars($data['penghuni']) ?> (Kamar <?= htmlspecialchars($data['kamar']) ?>, Bulan <?= htmlspecialchars($data['bulan']) ?>, Rp <?= number_format($data['jml_tagihan'],0,',','.') ?>)" readonly>
            </label>
            <label>Jumlah Bayar:
                <input type="number" name="jml_bayar" min="1" value="<?= htmlspecialchars($data['jml_bayar']) ?>" required>
            </label>
            <label>Tanggal Bayar:
                <input type="date" name="tgl_bayar" value="<?= htmlspecialchars($data['tgl_bayar']) ?>" required>
            </label>
            <label>Status:
                <select name="status" required>
                    <option value="lunas" <?= $data['status']=='lunas'?'selected':'' ?>>Lunas</option>
                    <option value="cicil" <?= $data['status']=='cicil'?'selected':'' ?>>Cicil</option>
                </select>
            </label>
            <button type="submit">Simpan</button>
        </form>
        <a href="kelola_pembayaran.php">&larr; Kembali ke Pembayaran</a>
    </div>
<?php ob_end_flush(); ?>
</body>
</html> 