<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
// Ambil kamar yang sudah terisi
$kamar_terisi = [];
$res = mysqli_query($conn, "SELECT kamar FROM penghuni");
while ($row = mysqli_fetch_assoc($res)) {
    $kamar_terisi[] = $row['kamar'];
}
$message = '';
$kamar_url = isset($_GET['kamar']) ? (int)$_GET['kamar'] : null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $kamar = (int)$_POST['kamar'];
    if ($kamar < 1 || $kamar > 30) {
        $message = 'Nomor kamar hanya boleh 1 sampai 30!';
    } elseif (in_array($kamar, $kamar_terisi)) {
        $message = 'Kamar sudah terisi!';
    } else {
        mysqli_query($conn, "INSERT INTO penghuni (nama, kamar) VALUES ('$nama', '$kamar')");
        header("Location: dashboard.php");
        exit;
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
        input[type="text"], select {
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
        a {
            display: inline-block;
            margin-top: 18px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
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
        <?php if (count($kamar_terisi) >= 30): ?>
            <div class="info">Semua kamar sudah terisi!</div>
        <?php else: ?>
        <form method="post">
            <label>Nama:
                <input type="text" name="nama" required>
            </label>
            <label>Nomor Kamar:
                <select name="kamar" required <?= $kamar_url ? 'readonly disabled' : '' ?>>
                    <option value="">-- Pilih Kamar --</option>
                    <?php for ($i=1; $i<=30; $i++): ?>
                        <?php if (!in_array($i, $kamar_terisi) || ($kamar_url && $kamar_url == $i)): ?>
                            <option value="<?= $i ?>" <?= ($kamar_url && $kamar_url == $i) ? 'selected' : '' ?>>Kamar <?= $i ?></option>
                        <?php endif; ?>
                    <?php endfor; ?>
                </select>
            </label>
            <button type="submit">Simpan</button>
        </form>
        <?php endif; ?>
        <!-- <a href="dashboard.php">&larr; Kembali ke Dashboard</a> -->
    </div>
</body>
</html> 