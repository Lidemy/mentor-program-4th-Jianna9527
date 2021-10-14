<?php
require_once('conn.php');

// using username to get user data from sql
function get_user_data($username)
{
    global $conn;
    if (!empty($username)) {
        $query_string = 'SELECT * FROM jianna_w11_users WHERE username=?';
        $stmt = $conn->prepare($query_string);
        $stmt->bind_param('s', $username);
        if (!$stmt->execute()) {
            die($stmt->error);
        } else {
            $result = $stmt->get_result();
            $data = $result->fetch_assoc();
        }
        $stmt->close();
        return $data;
    }
}

// 跳脫字元
function escape($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

// 登入 session 異常
function check_login_status()
{
    if (!isset($_SESSION['username'])) {
        $msg = '連線狀態異常，請重新登入';
        echo '<script type="text/javascript">alert("' . $msg . '");location.href="login.php"</script>';
        exit();
    }
}

// 驗證權限
function check_permission($username, $role)
{
    global $conn;
    $query_string = 'SELECT * FROM jianna_w11_users WHERE username=? AND role=?';
    $stmt = $conn->prepare($query_string);
    $stmt->bind_param('si', $username, $role);
    if (!$stmt->execute()) {
        die($stmt->error);
    }
    $result = $stmt->get_result();
    return $result->num_rows != 0;
}

// 驗證登入
function is_logged()
{
    return isset($_SESSION['username']) && !empty($_SESSION['username']);
}

// 驗證登入狀態顯示 navbar
function create_nav()
{
    global $is_admin;
    $is_admin = false;
    // 驗證登入狀態與身份
    if (is_logged()) {
        $username = $_SESSION['username'];
        if (check_permission($username, 1)) {
          $is_admin = true;
          echo '<li><a href="add.php">新增文章</a></li>';
          // echo '<li><a href="admin.php">管理後台</a></li>';
        }
        echo '<li><a href="handle_logout.php">登出</a></li>';
      } else {
        echo '<li><a href="login.php">登入</a></li>';
      }
}
