<?php
// connect.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "idkpw";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Lỗi kết nối database: " . mysqli_connect_error());
}
?>
