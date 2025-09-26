<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username','$email','$password')";
    if (mysqli_query($conn, $sql)) {
        echo "สมัครสมาชิกสำเร็จ <a href='login.php'>เข้าสู่ระบบ</a>";
    } else {
        echo "ผิดพลาด: " . mysqli_error($conn);
    }
}
?>
<form method="post">
    ชื่อผู้ใช้: <input type="text" name="username" required><br>
    อีเมล: <input type="email" name="email" required><br>
    รหัสผ่าน: <input type="password" name="password" required><br>
    <button type="submit">สมัครสมาชิก</button>
</form>