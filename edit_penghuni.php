<?php
ob_start();
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id < 1) {
    header('Location: kelola_penghuni.php');
    exit;
}
// Ambil data penghuni
$q = mysqli_query($conn, "SELECT * FROM tb_penghuni WHERE id='$id'");
$data = mysqli_fetch_assoc($q);
if (!$data) {
    header('Location: kelola_penghuni.php');
    exit;
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'] ?? '';
    $no_ktp = $_POST['no_ktp'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    $tgl_masuk = $_POST['tgl_masuk'] ?? '';
    $tgl_keluar = $_POST['tgl_keluar'] ?? null;
    if (!$nama || !$no_ktp || !$no_hp || !$tgl_masuk) {
        $message = 'Semua field wajib diisi kecuali tanggal keluar.';
    } else {
        // Cek No. KTP unik (kecuali milik sendiri)
        $cek = mysqli_query($conn, "SELECT id FROM tb_penghuni WHERE no_ktp='$no_ktp' AND id!='$id'");
        if (mysqli_num_rows($cek) > 0) {
            $message = 'No. KTP sudah terdaftar!';
        } else {
            $tgl_keluar_sql = $tgl_keluar ? "'$tgl_keluar'" : 'NULL';
            mysqli_query($conn, "UPDATE tb_penghuni SET nama='$nama', no_ktp='$no_ktp', no_hp='$no_hp', tgl_masuk='$tgl_masuk', tgl_keluar=$tgl_keluar_sql WHERE id='$id'");
            header('Location: kelola_penghuni.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Penghuni</title>
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
        <h1>Edit Penghuni</h1>
        <?php if ($message): ?>
            <div class="info"><?= $message ?></div>
        <?php endif; ?>
        <form method="post">
            <label>Nama:
                <input type="text" name="nama" required value="<?= htmlspecialchars($data['nama']) ?>">
            </label>
            <label>No. KTP:
                <input type="text" name="no_ktp" required value="<?= htmlspecialchars($data['no_ktp']) ?>">
            </label>
            <label>No. HP:
                <input type="text" name="no_hp" required value="<?= htmlspecialchars($data['no_hp']) ?>">
            </label>
            <label>Tanggal Masuk:
                <input type="date" name="tgl_masuk" required value="<?= htmlspecialchars($data['tgl_masuk']) ?>">
            </label>
            <label>Tanggal Keluar:
                <input type="date" name="tgl_keluar" value="<?= htmlspecialchars($data['tgl_keluar']) ?>">
            </label>
            <button type="submit">Simpan Perubahan</button>
        </form>
        <a href="kelola_penghuni.php">&larr; Kembali ke Data Penghuni</a>
    </div>
<?php ob_end_flush(); ?>
</body>
</html> 