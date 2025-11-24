<?php
session_start();
require_once "connect.php";

mysqli_report(MYSQLI_REPORT_OFF);

$message = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";

    if (mysqli_multi_query($conn, $query)) {

        $rows = [];

        do {
            if ($result = mysqli_store_result($conn)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $rows[] = $row;
                }
                mysqli_free_result($result);
            }
        } while (mysqli_next_result($conn));

        // TEST 4 – UNION
        if (stripos($username, "union") !== false || stripos($password, "union") !== false) {
            $_SESSION['test_case'] = "union";
            $_SESSION['result_data'] = $rows;
            header("Location: result.php");
            exit();
        }

        // TEST 5 – DROP TABLE
        if (stripos($username, "drop") !== false || stripos($password, "drop") !== false) {
            $_SESSION['test_case'] = "drop";
            $_SESSION['result_data'] = "DROP TABLE đã chạy! Bảng users có thể đã bị xóa.";
            header("Location: result.php");
            exit();
        }

        // TEST 1–3 – BYPASS LOGIN
        if (count($rows) >= 1) {

            $user = $rows[0];

            $_SESSION['username'] = $user['username'];

            if ($user['username'] === 'admin') {
                header("Location: admin.php");
                exit();
            }

            header("Location: user.php");
            exit();
        }

        $message = "Sai tài khoản hoặc mật khẩu!";

    } else {
        $_SESSION['test_case'] = "sql_error";
        $_SESSION['result_data'] = "Lỗi SQL câu lệnh không thể thực thi.";
        header("Location: result.php");
        exit();
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