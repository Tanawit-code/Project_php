<?php
include 'config.php';

// ถ้าไม่มีตะกร้าให้สร้างใหม่
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// เพิ่มสินค้าเข้าตะกร้า
if (isset($_GET['add'])) {
    $id = (int) $_GET['add'];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['cart'][$id] = 1;
    }
    header("Location: cart.php");
    exit;
}

// ลบสินค้าออกจากตะกร้า
if (isset($_GET['remove'])) {
    $id = (int) $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ตะกร้าสินค้า</title>
</head>
<body>
<h2>ตะกร้าสินค้า</h2>
<a href="index.php">🛍️ เลือกซื้อสินค้าต่อ</a> | 
<a href="checkout.php">✔ ดำเนินการสั่งซื้อ</a>
<hr>
<?php
$total = 0;
if ($_SESSION['cart']) {
    foreach ($_SESSION['cart'] as $id => $qty) {
        $sql = "SELECT * FROM products WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        $product = mysqli_fetch_assoc($result);

        $sum = $product['price'] * $qty;
        $total += $sum;

        echo "<p><b>{$product['name']}</b> x $qty = $sum บาท
              <a href='cart.php?remove=$id'>❌ ลบ</a></p>";
    }
    echo "<hr><b>รวมทั้งหมด: $total บาท</b>";
} else {
    echo "ยังไม่มีสินค้าในตะกร้า";
}
?>
</body>
</html>