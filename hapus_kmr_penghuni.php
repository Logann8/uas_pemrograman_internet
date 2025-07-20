<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    mysqli_query($conn, "DELETE FROM tb_kmr_penghuni WHERE id='$id'");
}
header('Location: kelola_kmr_penghuni.php');
exit; 