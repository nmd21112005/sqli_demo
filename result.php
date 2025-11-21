<?php
session_start(); // bắt buộc để lấy session

require_once "connect.php";

$resultMessage = "";

// Nếu login.php đã lưu dữ liệu SQL Injection vào session
if (isset($_SESSION['result_data'])) {
    $data = $_SESSION['result_data'];

    if (is_array($data)) {
        $resultMessage .= "<h3>Dữ liệu trả về từ truy vấn:</h3><ul>";
        foreach ($data as $row) {
            $resultMessage .= "<li>";
            foreach ($row as $key => $value) {
                $resultMessage .= "<strong>$key</strong>: $value &nbsp; ";
            }
            $resultMessage .= "</li>";
        }
        $resultMessage .= "</ul>";
    } else {
        // nếu result_data là string thông báo (DROP TABLE)
        $resultMessage .= "<p>$data</p>";
    }

    // xóa session để tránh in lại khi reload
    unset($_SESSION['result_data']);
}

// Nếu có action qua GET (ví dụ delete/show)
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == "show") {
        $query = "SELECT id, username FROM users";
        $res = mysqli_query($conn, $query);

        if ($res && $res->num_rows > 0) {
            $resultMessage .= "<h3>Danh sách user:</h3><ul>";
            while($row = mysqli_fetch_assoc($res)) {
                $resultMessage .= "<li>ID: {$row['id']} - Username: {$row['username']}</li>";
            }
            $resultMessage .= "</ul>";
        } else {
            $resultMessage .= "<p>Không có dữ liệu nào.</p>";
        }
    } elseif ($action == "delete" && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $query = "DELETE FROM users WHERE id=$id";
        if (mysqli_query($conn, $query)) {
            $resultMessage .= "<p>Đã xóa user ID = $id thành công.</p>";
        } else {
            $resultMessage .= "<p>Xóa thất bại: " . mysqli_error($conn) . "</p>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả thao tác</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="index-box">
        <h1>Kết quả</h1>
        <?php
            if ($resultMessage != "") {
                echo $resultMessage;
            } else {
                echo "<p>Không có dữ liệu để hiển thị.</p>";
            }
        ?>
        <a href="login.php" class="logout-btn">Quay lại Trang chủ</a>
    </div>
</body>
</html>
