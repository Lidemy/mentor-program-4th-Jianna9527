<?php
require_once('conn.php');

if (empty($_POST['username']) || empty($_POST['password'])) {
    header('location: login.php?errCode=1');
    die();
}

$username = $_POST['username'];
$password = $_POST['password'];

$query_string = sprintf(
    'SELECT * FROM jianna_w9_users where username="%s" and password="%s"',
    $username,
    $password
);

$result = $conn->query($query_string);
if (!$result) {
    die($conn->error);
}

if ($result->num_rows) { // 登入成功
    $row = $result->fetch_assoc();
    $user_id = $row['id'];
    session_start();
    $_SESSION['user_id'] = $user_id;
    $msg = '登入成功！';
    echo '<script type="text/javascript">alert("' . $msg . '");location.href="index.php"</script>';
} else {
    header('location: login.php?errCode=2');
}
