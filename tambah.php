<?php
include 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $kamar = $_POST['kamar'];
    mysqli_query($conn, "INSERT INTO penghuni (nama, kamar) VALUES ('$nama', '$kamar')");
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Penghuni</title>
</head>
<body>
    <h1>Tambah Penghuni Kost</h1>
    <form method="post">
        Nama: <input type="text" name="nama" required><br>
        Kamar: <input type="text" name="kamar" required><br>
        <button type="submit">Simpan</button>
    </form>
    <a href="index.php">Kembali</a>
</body>
</html> 