<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("กรุณา <a href='login.php'>เข้าสู่ระบบ</a> ก่อนสั่งซื้อ");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $total = 0;

    foreach ($_SESSION['cart'] as $id => $qty) {
        $sql = "SELECT price FROM products WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $total += $row['price'] * $qty;
    }

    mysqli_query($conn, "INSERT INTO orders (user_id,total) VALUES ($user_id,$total)");
    $order_id = mysqli_insert_id($conn);

    foreach ($_SESSION['cart'] as $id => $qty) {
        $sql = "SELECT price FROM products WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $price = $row['price'];

        mysqli_query($conn, "INSERT INTO order_items (order_id,product_id,quantity,price)
                             VALUES ($order_id,$id,$qty,$price)");
    }

    unset($_SESSION['cart']);
    echo "✅ สั่งซื้อเรียบร้อยแล้ว <a href='index.php'>กลับหน้าหลัก</a>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">
<head><meta charset="UTF-8"><title>ชำระเงิน</title></head>
<body>
<h2>ยืนยันการสั่งซื้อ</h2>
<form method="post">
    <button type="submit">ยืนยันสั่งซื้อ</button>
</form>
</body>
</html>