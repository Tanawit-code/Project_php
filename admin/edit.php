<?php
include '../config.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("❌ ไม่อนุญาต กรุณาเข้าสู่ระบบผู้ดูแลก่อน <a href='../admin_login.php'>คลิกที่นี่</a>");
}
$id = (int)$_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$product = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    mysqli_query($conn, "UPDATE products SET name='$name',price=$price,stock=$stock WHERE id=$id");
    header("Location: index.php");
    exit;
}
?>
<form method="post">
    ชื่อสินค้า: <input type="text" name="name" value="<?= $product['name'] ?>"><br>
    ราคา: <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>"><br>
    คงเหลือ: <input type="number" name="stock" value="<?= $product['stock'] ?>"><br>
    <button type="submit">อัพเดต</button>
</form>