<?php
session_start();
include 'config.php';

if (empty($_SESSION[WP . 'checklogin'])) {
    $_SESSION['message'] = 'คุณไม่ได้รับอนุญาต!';
    header("location:{$base_url}/login.php");
}
