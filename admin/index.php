<?php
include '../config.php';

// ตรวจสอบสิทธิ์แอดมิน
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("❌ ไม่อนุญาต กรุณาเข้าสู่ระบบผู้ดูแลก่อน <a href='../admin_login.php'>คลิกที่นี่</a>");
}

// ดึงจำนวนข้อมูลจากฐานข้อมูล
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM users"))['cnt'];
$totalProducts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM products"))['cnt'];
$totalOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM orders"))['cnt'];
$totalSales = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(total),0) as sum FROM orders"))['sum'];
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 0; }
        .header { background: #343a40; color: white; padding: 15px; text-align: center; }
        .container { padding: 20px; }
        .card {
            background: white; padding: 20px; margin: 10px;
            border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: inline-block; width: 22%; vertical-align: top; text-align: center;
        }
        .card h2 { margin: 0; color: #333; }
        .menu { margin: 20px 0; }
        .menu a {
            display: inline-block; margin: 5px; padding: 10px 15px;
            background: #007bff; color: white; text-decoration: none;
            border-radius: 5px;
        }
        .menu a:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="header">
        <h1>แผงควบคุมผู้ดูแลระบบ</h1>
        <p>ยินดีต้อนรับ, <?php echo htmlspecialchars($_SESSION['admin_username']); ?> | 
           <a href="../logout.php" style="color: #ffc107;">ออกจากระบบ</a></p>
    </div>

    <div class="container">
        <div class="card">
            <h2><?php echo $totalUsers; ?></h2>
            <p>ผู้ใช้งาน</p>
        </div>
        <div class="card">
            <h2><?php echo $totalProducts; ?></h2>
            <p>สินค้า</p>
        </div>
        <div class="card">
            <h2><?php echo $totalOrders; ?></h2>
            <p>คำสั่งซื้อ</p>
        </div>
        <div class="card">
            <h2><?php echo number_format($totalSales, 2); ?> ฿</h2>
            <p>ยอดขายรวม</p>
        </div>

        <div class="menu">
            <a href="manage_products.php">จัดการสินค้า</a>
            <a href="manage_orders.php">จัดการคำสั่งซื้อ</a>
            <a href="manage_users.php">จัดการผู้ใช้</a>
        </div>
    </div>
</body>
</html>