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
    header('Location: kelola_barang.php');
    exit;
}
// Ambil data barang
$q = mysqli_query($conn, "SELECT * FROM tb_barang WHERE id='$id'");
$data = mysqli_fetch_assoc($q);
if (!$data) {
    header('Location: kelola_barang.php');
    exit;
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = trim($_POST['nama_barang'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');
    if ($nama_barang === '') {
        $message = 'Nama barang wajib diisi!';
    } else {
        mysqli_query($conn, "UPDATE tb_barang SET nama_barang='$nama_barang', keterangan='$keterangan' WHERE id='$id'");
        header('Location: kelola_barang.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
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
        input[type="text"], textarea {
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 15px;
        }
        textarea {
            resize: vertical;
            min-height: 50px;
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
        <h1>Edit Barang</h1>
        <?php if ($message): ?>
            <div class="info"><?= $message ?></div>
        <?php endif; ?>
        <form method="post">
            <label>Nama Barang:
                <input type="text" name="nama_barang" required value="<?= htmlspecialchars($data['nama_barang']) ?>">
            </label>
            <label>Keterangan:
                <textarea name="keterangan"><?= htmlspecialchars($data['keterangan']) ?></textarea>
            </label>
            <button type="submit">Simpan Perubahan</button>
        </form>
        <a href="kelola_barang.php">&larr; Kembali ke Data Barang</a>
    </div>
<?php ob_end_flush(); ?>
</body>
</html> 