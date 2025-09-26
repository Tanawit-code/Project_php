<?php
$base_url = 'http://localhost/Project_php';

$host = "localhost";
$user = "root";  // เปลี่ยนตาม XAMPP ของคุณ
$pass = "";      // ใส่รหัสผ่านถ้ามี
$db   = "shopdb";

// เริ่ม session อย่างปลอดภัย
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("เชื่อมต่อฐานข้อมูลไม่สำเร็จ: " . mysqli_connect_error());
}
?>
