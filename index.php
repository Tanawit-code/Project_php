<?php
include 'config.php'; // session เริ่มจากไฟล์นี้

// ดึงสินค้าจากฐานข้อมูล
$result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ร้านค้าออนไลน์</title>
    <style>
        body { font-family: Tahoma; background: #f5f5f5; }
        .product { border:1px solid #ccc; padding:10px; margin:10px; background:#fff; display:inline-block; width:200px; vertical-align:top; }
        .menu { background:#333; padding:10px; color:#fff; }
        .menu a { color:white; margin-right:15px; text-decoration:none; }
    </style>
</head>
<body>
    <div class="menu">
        <a href="index.php">หน้าแรก</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <span>สวัสดี, <?= $_SESSION['username'] ?> </span>
            <a href="logout.php"><button>🚪 ออกจากระบบ</button></a>
        <?php else: ?>
            <a href="login.php">เข้าสู่ระบบ</a>
            <a href="register.php">สมัครสมาชิก</a>
        <?php endif; ?>
    </div>
    <p>
        <a href="cart.php"><button>🛒 ตะกร้าสินค้า</button></a>
        <a href="order_status.php"><button>📦 ดูสถานะคำสั่งซื้อ</button></a>
    </p>
    <h2>สินค้าทั้งหมด</h2>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="product">
            <img src="uploads/<?= $row['image'] ?>" width="150"><br>
            <strong><?= $row['name'] ?></strong><br>
            ราคา: <?= $row['price'] ?> บาท<br>
            <a href="cart.php?add=<?= $row['id'] ?>"><button>หยิบใส่ตะกร้า</button></a>
        </div>
    <?php endwhile; ?>
</body>
</html>
