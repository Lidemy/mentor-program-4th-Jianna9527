<?php
require_once('conn.php');
require_once('utils.php');
session_start();
if (is_logged()) {
    $username = $_SESSION['username'];
    if (!check_permission($username, 1)) {
        header('location: index.php');
        exit();
    }
}

if (empty($_GET['id'])) {
    header('location: list.php');
    exit();
}

$query_string = 'UPDATE jianna_w11_posts SET is_deleted=1 WHERE id=? AND username=?';
$stmt = $conn->prepare($query_string);
$stmt->bind_param('ss', $_GET['id'], $username);
if (!$stmt->execute()) {
    die($stmt->error);
}

if ($stmt->affected_rows == 0) {
    $msg = '錯誤：沒有權限或文章不存在！';
    echo '<script type="text/javascript">alert("' . $msg . '");window.history.back()</script>';
    exit();
}

header('location: list.php');
