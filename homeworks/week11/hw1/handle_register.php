<?php
require_once('conn.php');
require_once('utils.php');

if (empty($_POST['nickname']) || empty($_POST['username']) || empty($_POST['password'])) {
    header('location: register.php?errCode=1');
    exit();
}

$nickname = $_POST['nickname'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$query_string = 'INSERT INTO jianna_w11_users (nickname, username, password) VALUES (?, ?, ?)';
$stmt = $conn->prepare($query_string);
$stmt->bind_param('sss', $nickname, $username, $password);

if (!$stmt->execute()) {
    $err_code = $conn->errno;
    if ($err_code === 1062) {
        header('location: register.php?errCode=1062');
        exit();
    }
    die($conn->error);
}
$stmt->close();

session_start();
$_SESSION['username'] = $username;
$msg = '註冊成功！';
echo '<script type="text/javascript">alert("' . $msg . '");location.href="index.php"</script>';
