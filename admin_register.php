<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // ตรวจสอบว่า username หรือ email มีอยู่แล้วหรือไม่
    $check = mysqli_query($conn, "SELECT * FROM admins WHERE username='$username' OR email='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "❌ ชื่อผู้ใช้หรืออีเมลนี้ถูกใช้แล้ว กรุณาเลือกใหม่";
    } else {
        $sql = "INSERT INTO admins (username, password, email) VALUES ('$username', '$password', '$email')";
        if (mysqli_query($conn, $sql)) {
            echo "✅ สมัครแอดมินสำเร็จ <a href='admin_login.php'>เข้าสู่ระบบ</a>";
            exit;
        } else {
            echo "❌ เกิดข้อผิดพลาด: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>สมัครแอดมิน</title>
<style>
    body { font-family: Tahoma; background:#f4f4f4; }
    .box { width:320px; margin:50px auto; padding:20px; background:#fff; border:1px solid #ccc; }
</style>
</head>
<body>
<div class="box">
    <h2>🛠 สมัครแอดมินใหม่</h2>
    <form method="post">
        <label>ชื่อผู้ใช้:</label><br>
        <input type="text" name="username" required><br><br>

        <label>อีเมล:</label><br>
        <input type="email" name="email" required><br><br>

        <label>รหัสผ่าน:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">สมัครแอดมิน</button>
    </form>
    <p><a href="index.php">⬅ กลับหน้าหลัก</a></p>
</div>
</body>
</html>
