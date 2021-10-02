<?php
require_once('conn.php');
require_once('utils.php');

if (!empty($_POST['nickname_new'])) {
    $nickname = escape($_POST['nickname_new']);
} else {
    header('location: index.php?errCode=2');
}

session_start();
check_login_status();
$username = $_SESSION['username'];

$query_string = 'UPDATE jianna_w11_users SET nickname=? WHERE username=?';
$stmt = $conn->prepare($query_string);
$stmt->bind_param('ss', $nickname, $username);
if (!$stmt->execute()) {
    die($stmt->error);
}

$msg = '暱稱已變更！';
echo '<script type="text/javascript">alert("' . $msg . '");location.href="index.php"</script>';
