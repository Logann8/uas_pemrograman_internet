<?php
ob_start();
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
$kamar_url = isset($_GET['kamar']) ? (int)$_GET['kamar'] : null;
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'] ?? '';
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $alamat = isset($_POST['alamat']) ? mysqli_real_escape_string($conn, $_POST['alamat']) : '';
    $kamar = isset($_POST['kamar']) ? (int)$_POST['kamar'] : 0;
    if ($kamar < 1 || $kamar > 30) {
        $message = 'Nomor kamar hanya boleh 1 sampai 30!';
    } elseif (in_array($kamar, $kamar_terisi)) {
        $message = 'Kamar sudah terisi!';
    } else {
        mysqli_query($conn, "INSERT INTO penghuni (nama, kamar, jenis_kelamin, alamat) VALUES ('$nama', '$kamar', '$jenis_kelamin', '$alamat')");
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
        input[type="text"], select, textarea {
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 15px;
        }
        textarea {
            resize: vertical;
            min-height: 50px;
        }
        .radio-group {
            display: flex;
            gap: 18px;
            align-items: center;
        }
        .radio-group label {
            font-size: 15px;
            color: #333;
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
            <label>Jenis Kelamin:
                <div class="radio-group">
                    <label><input type="radio" name="jenis_kelamin" value="Laki-laki" required> Laki-laki</label>
                    <label><input type="radio" name="jenis_kelamin" value="Perempuan" required> Perempuan</label>
                </div>
            </label>
            <label>Alamat:
                <textarea name="alamat" required></textarea>
            </label>
            <label>Nomor Kamar:
                <?php if ($kamar_url): ?>
                    <input type="hidden" name="kamar" value="<?= $kamar_url ?>">
                    <input type="text" value="Kamar <?= $kamar_url ?>" readonly>
                <?php else: ?>
                    <select name="kamar" required>
                        <option value="">-- Pilih Kamar --</option>
                        <?php for ($i=1; $i<=30; $i++): ?>
                            <?php if (!in_array($i, $kamar_terisi)): ?>
                                <option value="<?= $i ?>">Kamar <?= $i ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                <?php endif; ?>
            </label>
            <button type="submit">Simpan</button>
        </form>
    </div>
<?php ob_end_flush(); ?>
</body>
</html> 