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
    header('Location: kelola_barang_bawaan.php');
    exit;
}
// Ambil data barang bawaan
$q = mysqli_query($conn, "SELECT bb.*, p.nama AS penghuni FROM tb_brng_bawaan bb JOIN tb_penghuni p ON bb.id_penghuni=p.id WHERE bb.id='$id'");
$data = mysqli_fetch_assoc($q);
if (!$data) {
    header('Location: kelola_barang_bawaan.php');
    exit;
}
// Barang
$barang = mysqli_query($conn, "SELECT id, nama FROM tb_barang ORDER BY nama");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_barang = (int)($_POST['id_barang'] ?? 0);
    $jumlah = (int)($_POST['jumlah'] ?? 0);
    if ($id_barang > 0 && $jumlah > 0) {
        mysqli_query($conn, "UPDATE tb_brng_bawaan SET id_barang='$id_barang', jumlah='$jumlah' WHERE id='$id'");
        header('Location: kelola_barang_bawaan.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang Bawaan</title>
    <style>
        body { font-family: Arial, sans-serif; background: url('background.jpg') no-repeat center center fixed; background-size: cover; margin: 0; padding: 0; }
        .container { max-width: 400px; margin: 60px auto; background: rgba(255,255,255,0.92); border-radius: 14px; box-shadow: 0 4px 24px rgba(0,0,0,0.10); padding: 32px 32px 24px 32px; }
        h1 { text-align: center; color: #007bff; }
        form { display: flex; flex-direction: column; gap: 14px; }
        select, input[type="number"] { padding: 8px 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px; }
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
        <h1>Edit Barang Bawaan</h1>
        <form method="post">
            <label>Penghuni:
                <input type="text" value="<?= htmlspecialchars($data['penghuni']) ?>" readonly>
            </label>
            <label>Barang:
                <select name="id_barang" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php while($b = mysqli_fetch_assoc($barang)): ?>
                        <option value="<?= $b['id'] ?>" <?= $b['id']==$data['id_barang']?'selected':'' ?>><?= htmlspecialchars($b['nama']) ?></option>
                    <?php endwhile; ?>
                </select>
            </label>
            <label>Jumlah:
                <input type="number" name="jumlah" min="1" value="<?= htmlspecialchars($data['jumlah']) ?>" required>
            </label>
            <button type="submit">Simpan</button>
        </form>
        <a href="kelola_barang_bawaan.php">&larr; Kembali ke Barang Bawaan</a>
    </div>
<?php ob_end_flush(); ?>
</body>
</html> 