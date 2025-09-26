<?php
include '../config.php';

// ตรวจสอบสิทธิ์แอดมิน
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("❌ ไม่อนุญาต กรุณาเข้าสู่ระบบผู้ดูแลก่อน <a href='../admin_login.php'>คลิกที่นี่</a>");
}

// อัปเดตสถานะคำสั่งซื้อ
if (isset($_POST['update_status'])) {
    $order_id = (int)$_POST['order_id'];
    $status   = $_POST['status'];
    mysqli_query($conn, "UPDATE orders SET status='$status' WHERE id=$order_id");
    header("Location: manage_orders.php");
    exit;
}

// ดึงคำสั่งซื้อทั้งหมด
$orders = mysqli_query($conn, "
    SELECT o.*, u.username 
    FROM orders o 
    LEFT JOIN users u ON o.user_id=u.id
    ORDER BY o.id DESC
");
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการคำสั่งซื้อ</title>
<style>
body { font-family: Tahoma; padding:20px; background:#f4f6f9; }
table { border-collapse: collapse; width: 100%; background:#fff; }
th, td { border:1px solid #ccc; padding:10px; text-align:center; }
th { background:#007bff; color:white; }
select, button { padding:5px; }
</style>
</head>
<body>
<h2>🛒 จัดการคำสั่งซื้อ</h2>
<p><a href="index.php">⬅ กลับ Dashboard</a></p>

<table>
<tr>
    <th>ID</th>
    <th>ผู้สั่งซื้อ</th>
    <th>รวมราคา</th>
    <th>สถานะ</th>
    <th>วันที่</th>
    <th>จัดการ</th>
</tr>

<?php while($order = mysqli_fetch_assoc($orders)) { ?>
<tr>
    <td><?= $order['id'] ?></td>
    <td><?= htmlspecialchars($order['username']) ?></td>
    <td><?= number_format($order['total'],2) ?> ฿</td>
    <td><?= $order['status'] ?></td>
    <td><?= $order['created_at'] ?></td>
    <td>
        <form method="post">
            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
            <select name="status">
                <option value="pending" <?= $order['status']=='pending'?'selected':''?>>รอดำเนินการ</option>
                <option value="paid" <?= $order['status']=='paid'?'selected':''?>>ชำระแล้ว</option>
                <option value="shipped" <?= $order['status']=='shipped'?'selected':''?>>จัดส่งแล้ว</option>
                <option value="completed" <?= $order['status']=='completed'?'selected':''?>>เสร็จสิ้น</option>
                <option value="canceled" <?= $order['status']=='canceled'?'selected':''?>>ยกเลิก</option>
            </select>
            <button type="submit" name="update_status">💾 อัปเดต</button>
        </form>
    </td>
</tr>
<?php } ?>
</table>
</body>
</html>
