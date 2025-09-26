<?php
include '../config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("❌ ไม่อนุญาต กรุณาเข้าสู่ระบบผู้ดูแลก่อน <a href='../admin_login.php'>คลิกที่นี่</a>");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO products (name,price,stock) VALUES ('$name',$price,$stock)";
    mysqli_query($conn, $sql);

    header("Location: index.php");
    exit;
}
?>
<form method="post">
    ชื่อสินค้า: <input type="text" name="name" required><br>
    ราคา: <input type="number" name="price" step="0.01" required><br>
    คงเหลือ: <input type="number" name="stock" required><br>
    <button type="submit">บันทึก</button>
</form>