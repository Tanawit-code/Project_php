<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username='$username'";
    $query = mysqli_query($conn, $sql);
    $admin = mysqli_fetch_assoc($query);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['is_admin'] = true;

        header("Location: admin/index.php");
        exit;
    } else {
        $error = "❌ ชื่อผู้ใช้หรือรหัสผ่านแอดมินไม่ถูกต้อง";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>เข้าสู่ระบบแอดมิน</title>
<style>
    body { font-family: Tahoma; background:#f4f4f4; }
    .box { width:300px; margin:100px auto; padding:20px; background:#fff; border:1px solid #ddd; }
</style>
</head>
<body>
<div class="box">
    <h2>🔑 เข้าสู่ระบบผู้ดูแล</h2>
    <?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="post">
        ชื่อผู้ใช้: <input type="text" name="username" required><br><br>
        รหัสผ่าน: <input type="password" name="password" required><br><br>
        <button type="submit">เข้าสู่ระบบ</button>
    </form>
    <p><a href="index.php">⬅ กลับหน้าหลัก</a></p>
</div>
</body>
</html>
