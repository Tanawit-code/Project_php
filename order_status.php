<?php
include 'config.php';

// ตรวจสอบผู้ใช้ login
if (!isset($_SESSION['user_id'])) {
    die("❌ กรุณาเข้าสู่ระบบก่อน <a href='login.php'>คลิกที่นี่</a>");
}

$user_id = $_SESSION['user_id'];

// ดึงคำสั่งซื้อของผู้ใช้
$orders = mysqli_query($conn, "
    SELECT * FROM orders 
    WHERE user_id=$user_id 
    ORDER BY id DESC
");
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>สถานะคำสั่งซื้อของฉัน</title>
<style>
body { font-family: Tahoma; padding:20px; background:#f4f6f9; }
table { border-collapse: collapse; width: 100%; background:#fff; margin-bottom:30px; }
th, td { border:1px solid #ccc; padding:10px; text-align:center; }
th { background:#007bff; color:white; }
h2 { margin-top:40px; }
</style>
</head>
<body>
<h1>📦 สถานะคำสั่งซื้อของฉัน</h1>
<p><a href="index.php">⬅ กลับหน้าหลัก</a></p>

<?php while($order = mysqli_fetch_assoc($orders)) { ?>
<h2>คำสั่งซื้อ #<?= $order['id'] ?> | วันที่: <?= $order['created_at'] ?> | สถานะ: <strong><?= $order['status'] ?></strong></h2>

<table>
<tr>
    <th>สินค้า</th>
    <th>รูป</th>
    <th>จำนวน</th>
    <th>ราคา/ชิ้น</th>
    <th>รวม</th>
</tr>

<?php
// ดึงสินค้าของคำสั่งซื้อนี้
$items = mysqli_query($conn, "
    SELECT oi.*, p.name, p.image 
    FROM order_items oi 
    LEFT JOIN products p ON oi.product_id=p.id
    WHERE oi.order_id=".$order['id']
);

$order_total = 0;
while($item = mysqli_fetch_assoc($items)) {
    $total = $item['quantity'] * $item['price'];
    $order_total += $total;
?>
<tr>
    <td><?= htmlspecialchars($item['name']) ?></td>
    <td>
        <?php if($item['image'] && file_exists('uploads/'.$item['image'])): ?>
            <img src="uploads/<?= $item['image'] ?>" width="50">
        <?php else: ?>
            ไม่มีรูป
        <?php endif; ?>
    </td>
    <td><?= $item['quantity'] ?></td>
    <td><?= number_format($item['price'],2) ?> ฿</td>
    <td><?= number_format($total,2) ?> ฿</td>
</tr>
<?php } ?>
<tr>
    <td colspan="4" style="text-align:right"><strong>รวมทั้งหมด:</strong></td>
    <td><strong><?= number_format($order_total,2) ?> ฿</strong></td>
</tr>
</table>
<?php } ?>

<?php if(mysqli_num_rows($orders) == 0) echo "<p>คุณยังไม่มีคำสั่งซื้อ</p>"; ?>
</body>
</html>
