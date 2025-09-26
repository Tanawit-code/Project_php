<?php
include '../config.php';
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("❌ ไม่อนุญาต กรุณาเข้าสู่ระบบผู้ดูแลก่อน <a href='../admin_login.php'>คลิกที่นี่</a>");
}

// ลบผู้ใช้
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    header("Location: manage_users.php");
    exit;
}

// แก้ไขผู้ใช้
if (isset($_POST['edit'])) {
    $id       = (int)$_POST['id'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    mysqli_query($conn, "UPDATE users SET username='$username', email='$email' WHERE id=$id");
    header("Location: manage_users.php");
    exit;
}

// ดึงผู้ใช้ทั้งหมด
$users = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการผู้ใช้</title>
<style>
body { font-family: Tahoma; padding:20px; background:#f4f6f9; }
table { border-collapse: collapse; width: 100%; background:#fff; }
th, td { border:1px solid #ccc; padding:10px; text-align:center; }
th { background:#007bff; color:white; }
input, button { padding:5px; }
.btn-delete { background:#dc3545; color:white; text-decoration:none; border-radius:4px; padding:5px 10px; }
</style>
</head>
<body>
<h2>👤 จัดการผู้ใช้</h2>
<p><a href="index.php">⬅ กลับ Dashboard</a></p>

<table>
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Email</th>
    <th>จัดการ</th>
</tr>

<?php while($user = mysqli_fetch_assoc($users)) { ?>
<tr>
    <td><?= $user['id'] ?></td>
    <td>
        <form method="post" style="display:inline-block">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
    </td>
    <td>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
    </td>
    <td>
            <button type="submit" name="edit">💾 แก้ไข</button>
        </form>
        <a href="?delete=<?= $user['id'] ?>" class="btn-delete" onclick="return confirm('ต้องการลบผู้ใช้นี้จริงหรือไม่?')">🗑 ลบ</a>
    </td>
</tr>
<?php } ?>
</table>
</body>
</html>
