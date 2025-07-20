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
    header('Location: kelola_kmr_penghuni.php');
    exit;
}
// Ambil data relasi
$q = mysqli_query($conn, "SELECT kp.*, p.nama, k.nomor FROM tb_kmr_penghuni kp JOIN tb_penghuni p ON kp.id_penghuni=p.id JOIN tb_kamar k ON kp.id_kamar=k.id WHERE kp.id='$id'");
$data = mysqli_fetch_assoc($q);
if (!$data) {
    header('Location: kelola_kmr_penghuni.php');
    exit;
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tgl_keluar = $_POST['tgl_keluar'] ?? null;
    if ($tgl_keluar) {
        mysqli_query($conn, "UPDATE tb_kmr_penghuni SET tgl_keluar='$tgl_keluar' WHERE id='$id'");
    }
    header('Location: kelola_kmr_penghuni.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Relasi Kamar-Penghuni</title>
    <style>
        body { font-family: Arial, sans-serif; background: url('background.jpg') no-repeat center center fixed; background-size: cover; margin: 0; padding: 0; }
        .container { max-width: 400px; margin: 60px auto; background: rgba(255,255,255,0.92); border-radius: 14px; box-shadow: 0 4px 24px rgba(0,0,0,0.10); padding: 32px 32px 24px 32px; }
        h1 { text-align: center; color: #007bff; }
        form { display: flex; flex-direction: column; gap: 14px; }
        input[type="date"] { padding: 8px 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px; }
        button { background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%); color: #fff; border: none; padding: 10px 0; border-radius: 24px; font-size: 16px; cursor: pointer; margin-top: 8px; transition: background 0.2s; }
        button:hover { background: linear-gradient(90deg, #0056b3 0%, #0096c7 100%); }
        .info { color: #dc3545; text-align: center; margin-bottom: 10px; }
        a { display: inline-block; margin-top: 18px; color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .readonly { background: #f5f5f5; color: #555; border: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Relasi Kamar - Penghuni</h1>
        <form method="post">
            <label>Penghuni:
                <input type="text" value="<?= htmlspecialchars($data['nama']) ?>" class="readonly" readonly>
            </label>
            <label>Kamar:
                <input type="text" value="Kamar <?= htmlspecialchars($data['nomor']) ?>" class="readonly" readonly>
            </label>
            <label>Tanggal Masuk:
                <input type="date" value="<?= htmlspecialchars($data['tgl_masuk']) ?>" class="readonly" readonly>
            </label>
            <label>Tanggal Keluar:
                <input type="date" name="tgl_keluar" value="<?= htmlspecialchars($data['tgl_keluar'] ?? '') ?>">
            </label>
            <button type="submit">Simpan</button>
        </form>
        <a href="kelola_kmr_penghuni.php">&larr; Kembali ke Relasi Kamar-Penghuni</a>
    </div>
<?php ob_end_flush(); ?>
</body>
</html> 