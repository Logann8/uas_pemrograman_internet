<?php
ob_start();
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
// Penghuni yang belum menempati kamar aktif
$penghuni = mysqli_query($conn, "SELECT p.id, p.nama FROM tb_penghuni p WHERE p.id NOT IN (SELECT id_penghuni FROM tb_kmr_penghuni WHERE tgl_keluar IS NULL)");
// Kamar kosong
$kamar = mysqli_query($conn, "SELECT k.id, k.nomor FROM tb_kamar k WHERE k.id NOT IN (SELECT id_kamar FROM tb_kmr_penghuni WHERE tgl_keluar IS NULL)");
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_penghuni = (int)($_POST['id_penghuni'] ?? 0);
    $id_kamar = (int)($_POST['id_kamar'] ?? 0);
    $tgl_masuk = $_POST['tgl_masuk'] ?? date('Y-m-d');
    if ($id_penghuni < 1 || $id_kamar < 1) {
        $message = 'Pilih penghuni dan kamar!';
    } else {
        mysqli_query($conn, "INSERT INTO tb_kmr_penghuni (id_penghuni, id_kamar, tgl_masuk) VALUES ('$id_penghuni', '$id_kamar', '$tgl_masuk')");
        header('Location: kelola_kmr_penghuni.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Relasi Kamar-Penghuni</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 60px auto;
            background: rgba(255,255,255,0.92);
            border-radius: 14px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            padding: 32px 32px 24px 32px;
        }
        h1 {
            text-align: center;
            color: #007bff;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        select, input[type="date"] {
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 15px;
        }
        button {
            background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);
            color: #fff;
            border: none;
            padding: 10px 0;
            border-radius: 24px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 8px;
            transition: background 0.2s;
        }
        button:hover {
            background: linear-gradient(90deg, #0056b3 0%, #0096c7 100%);
        }
        .info {
            color: #dc3545;
            text-align: center;
            margin-bottom: 10px;
        }
        a {
            display: inline-block;
            margin-top: 18px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Relasi Kamar - Penghuni</h1>
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
            <label>Kamar:
                <select name="id_kamar" required>
                    <option value="">-- Pilih Kamar --</option>
                    <?php while($k = mysqli_fetch_assoc($kamar)): ?>
                        <option value="<?= $k['id'] ?>">Kamar <?= htmlspecialchars($k['nomor']) ?></option>
                    <?php endwhile; ?>
                </select>
            </label>
            <label>Tanggal Masuk:
                <input type="date" name="tgl_masuk" value="<?= date('Y-m-d') ?>" required>
            </label>
            <button type="submit">Simpan</button>
        </form>
        <a href="kelola_kmr_penghuni.php">&larr; Kembali ke Relasi Kamar-Penghuni</a>
    </div>
<?php ob_end_flush(); ?>
</body>
</html> 