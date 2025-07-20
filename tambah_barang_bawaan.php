<?php
ob_start();
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
// Penghuni
$penghuni = mysqli_query($conn, "SELECT id, nama FROM tb_penghuni ORDER BY nama");
// Barang
$barang = mysqli_query($conn, "SELECT id, nama FROM tb_barang ORDER BY nama");
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_penghuni = (int)($_POST['id_penghuni'] ?? 0);
    $id_barang = (int)($_POST['id_barang'] ?? 0);
    $jumlah = (int)($_POST['jumlah'] ?? 0);
    if ($id_penghuni < 1 || $id_barang < 1 || $jumlah < 1) {
        $message = 'Lengkapi data!';
    } else {
        mysqli_query($conn, "INSERT INTO tb_brng_bawaan (id_penghuni, id_barang, jumlah) VALUES ('$id_penghuni', '$id_barang', '$jumlah')");
        header('Location: kelola_barang_bawaan.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang Bawaan</title>
    <style>
        body { font-family: Arial, sans-serif; background: url('background.jpg') no-repeat center center fixed; background-size: cover; margin: 0; padding: 0; }
        .container { max-width: 400px; margin: 60px auto; background: rgba(255,255,255,0.92); border-radius: 14px; box-shadow: 0 4px 24px rgba(0,0,0,0.10); padding: 32px 32px 24px 32px; }
        h1 { text-align: center; color: #007bff; }
        form { display: flex; flex-direction: column; gap: 14px; }
        select, input[type="number"] { padding: 8px 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px; }
        button { background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%); color: #fff; border: none; padding: 10px 0; border-radius: 24px; font-size: 16px; cursor: pointer; margin-top: 8px; transition: background 0.2s; }
        button:hover { background: linear-gradient(90deg, #0056b3 0%, #0096c7 100%); }
        .info { color: #dc3545; text-align: center; margin-bottom: 10px; }
        a { display: inline-block; margin-top: 18px; color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Barang Bawaan</h1>
        <?php if ($message): ?>
            <div class="info"><?= $message ?></div>
        <?php endif; ?>
        <form method="post">
            <label>Penghuni:
                <select name="id_penghuni" required>
                    <option value="">-- Pilih Penghuni --</option>
                    <?php while($p = mysqli_fetch_assoc($penghuni)): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
                    <?php endwhile; ?>
                </select>
            </label>
            <label>Barang:
                <select name="id_barang" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php while($b = mysqli_fetch_assoc($barang)): ?>
                        <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['nama']) ?></option>
                    <?php endwhile; ?>
                </select>
            </label>
            <label>Jumlah:
                <input type="number" name="jumlah" min="1" required>
            </label>
            <button type="submit">Simpan</button>
        </form>
        <a href="kelola_barang_bawaan.php">&larr; Kembali ke Barang Bawaan</a>
    </div>
<?php ob_end_flush(); ?>
</body>
</html> 