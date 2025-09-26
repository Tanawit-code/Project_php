<?php
$base_url = 'http://localhost/';

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = '';

// เชื่อมต่อ + เลือกฐานข้อมูล
$conn = mysqli_connect();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

