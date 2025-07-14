<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include 'koneksi.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM penghuni WHERE id=$id");
header("Location: index.php");
exit;
?> 