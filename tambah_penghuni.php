<?php
ob_start();
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'] ?? '';
    $no_ktp = $_POST['no_ktp'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    $tgl_masuk = $_POST['tgl_masuk'] ?? '';
    $tgl_keluar = $_POST['tgl_keluar'] ?? null;
    if ($nama && $no_ktp && $no_hp && $tgl_masuk) {
        $tgl_keluar_sql = $tgl_keluar ? "'$tgl_keluar'" : 'NULL';
        mysqli_query($conn, "INSERT INTO tb_penghuni (nama, no_ktp, no_hp, tgl_masuk, tgl_keluar) VALUES ('$nama', '$no_ktp', '$no_hp', '$tgl_masuk', $tgl_keluar_sql)");
        header('Location: dashboard.php');
        exit;
    } else {
        $message = 'Semua field wajib diisi kecuali tanggal keluar.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Penghuni</title>
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
        input[type="text"], input[type="date"] {
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Penghuni Kost</h1>
        <?php if ($message): ?>
            <div class="info"><?= $message ?></div>
        <?php endif; ?>
        <form method="post">
            <label>Nama:
                <input type="text" name="nama" required>
            </label>
            <label>No. KTP:
                <input type="text" name="no_ktp" required>
            </label>
            <label>No. HP:
                <input type="text" name="no_hp" required>
            </label>
            <label>Tanggal Masuk:
                <input type="date" name="tgl_masuk" value="<?= date('Y-m-d') ?>" readonly>
            </label>
            <label>Tanggal Keluar:
                <input type="date" name="tgl_keluar">
            </label>
            <button type="submit">Simpan</button>
        </form>
    </div>
<?php ob_end_flush(); ?>
</body>
</html> 