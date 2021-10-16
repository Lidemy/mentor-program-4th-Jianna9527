<?php
require_once('conn.php');
require_once('utils.php');

if (empty($_POST['username']) || empty($_POST['password'])) {
    header('location: login.php?errCode=1');
    die();
}

$username = escape($_POST['username']);
$password = escape($_POST['password']);

$query_string = 'SELECT * FROM jianna_w11_users WHERE username=?';
$stmt = $conn->prepare($query_string);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    die($conn->error);
}
$stmt->close();

if ($result->num_rows) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) { // 帳號密碼正確，登入成功
        session_start();
        $_SESSION['username'] = $username;
        $msg = '登入成功！';
        echo '<script type="text/javascript">alert("' . $msg . '");location.href="index.php"</script>';
    } else { // 帳號正確，密碼錯誤
        header('location: login.php?errCode=3');
    }
} else { // 無此帳號
    header('location: login.php?errCode=2');
}
