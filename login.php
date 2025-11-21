<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost", "root", "", "idkpw");

if (!$conn) {
    die("Lỗi kết nối database: " . mysqli_connect_error());
}

$message = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if ($result->num_rows > 0) {
        header("Location: index.php");
        exit();
    } else {
        $message = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Demo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <h2>Đăng nhập</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username"><br>
        <input type="password" name="password" placeholder="Password"><br>
        <button name="login">Login</button>
    </form>
    <p class="error"><?php echo $message; ?></p>
</div>

</body>
</html>
