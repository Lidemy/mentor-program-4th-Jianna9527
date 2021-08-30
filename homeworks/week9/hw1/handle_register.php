<?php
require_once('conn.php');

if (empty($_POST['nickname']) || empty($_POST['username']) || empty($_POST['password'])) {
    header('location: register.php?errCode=1');
    die();
}

$nickname = $_POST['nickname'];
$username = $_POST['username'];
$password = $_POST['password'];

$query_string = sprintf(
    'INSERT INTO jianna_w9_users (nickname, username, password) VALUES ("%s","%s","%s")',
    $nickname,
    $username,
    $password
);

$result = $conn->query($query_string);
if (!$result) {
    $err_code = $conn->errno;
    if ($err_code === 1062) {
        header('location: register.php?errCode=1062');
    }

    die($conn->error);
}

$msg = '註冊成功！';
echo '<script type="text/javascript">alert("' . $msg . '");location.href="index.php"</script>';
