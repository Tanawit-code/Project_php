<?php
include '../config.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("❌ ไม่อนุญาต กรุณาเข้าสู่ระบบผู้ดูแลก่อน <a href='../admin_login.php'>คลิกที่นี่</a>");
}

// เพิ่มสินค้า
if (isset($_POST['add'])) {
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $imageName = null;

    // อัปโหลดรูปถ้ามี
    if (!empty($_FILES['image']['name'])) {
        $imageName = time().'_'.basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/'.$imageName);
    }

    mysqli_query($conn, "INSERT INTO products (name, price, stock, image) VALUES ('$name',$price,$stock,'$imageName')");
    header("Location: manage_products.php");
    exit;
}

// แก้ไขสินค้า
if (isset($_POST['edit'])) {
    $id    = (int)$_POST['id'];
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];

    $imageSql = "";
    if (!empty($_FILES['image']['name'])) {
        $imageName = time().'_'.basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/'.$imageName);
        $imageSql = ", image='$imageName'";
    }

    mysqli_query($conn, "UPDATE products SET name='$name', price=$price, stock=$stock $imageSql WHERE id=$id");
    header("Location: manage_products.php");
    exit;
}

// ลบสินค้า
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    // ลบไฟล์รูปด้วย
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM products WHERE id=$id"));
    if ($row['image'] && file_exists('../uploads/'.$row['image'])) {
        unlink('../uploads/'.$row['image']);
    }

    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: manage_products.php");
    exit;
}

// ดึงรายการสินค้า
$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการสินค้า</title>
<style>
body { font-family: Tahoma; background:#f4f6f9; padding:20px; }
table { border-collapse: collapse; width: 100%; background:#fff; }
th, td { border:1px solid #ccc; padding:10px; text-align:center; }
th { background:#007bff; color:white; }
input { padding:5px; }
.btn { padding:5px 10px; margin:2px; text-decoration:none; border-radius:4px; }
.btn-edit { background:#ffc107; color:black; }
.btn-delete { background:#dc3545; }
</style>
</head>
<body>
<h2>📦 จัดการสินค้า</h2>
<p><a href="index.php">⬅ กลับ Dashboard</a></p>

<h3>เพิ่มสินค้าใหม่</h3>
<form method="post" enctype="multipart/form-data">
    ชื่อสินค้า: <input type="text" name="name" required>
    ราคา: <input type="number" name="price" step="0.01" required>
    คงเหลือ: <input type="number" name="stock" required>
    รูปสินค้า: <input type="file" name="image" accept="image/*"><br><br>
    <button type="submit" name="add">➕ เพิ่ม</button>
</form>

<hr>
<h3>รายการสินค้า</h3>
<table>
<tr>
    <th>ID</th>
    <th>รูป</th>
    <th>ชื่อสินค้า</th>
    <th>ราคา</th>
    <th>คงเหลือ</th>
    <th>จัดการ</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($products)) { ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td>
        <?php if ($row['image'] && file_exists('../uploads/'.$row['image'])): ?>
            <img src="../uploads/<?= $row['image'] ?>" width="50">
        <?php else: ?>
            ไม่มีรูป
        <?php endif; ?>
    </td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= number_format($row['price'],2) ?> ฿</td>
    <td><?= $row['stock'] ?></td>
    <td>
        <form method="post" class="inline" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required>
            <input type="number" name="price" step="0.01" value="<?= $row['price'] ?>" required>
            <input type="number" name="stock" value="<?= $row['stock'] ?>" required>
            <input type="file" name="image" accept="image/*">
            <button type="submit" name="edit" class="btn btn-edit">✏ แก้ไข</button>
        </form>
        <a href="?delete=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('ต้องการลบสินค้านี้จริงหรือไม่?')">🗑 ลบ</a>
    </td>
</tr>
<?php } ?>
</table>
</body>
</html>
