<?php
include '../config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("❌ ไม่อนุญาต กรุณาเข้าสู่ระบบผู้ดูแลก่อน <a href='../admin_login.php'>คลิกที่นี่</a>");
}
$id = (int)$_GET['id'];
mysqli_query($conn, "DELETE FROM products WHERE id=$id");
header("Location: index.php");
exit;