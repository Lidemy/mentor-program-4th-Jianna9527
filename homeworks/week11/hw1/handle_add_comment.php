<?php
require_once('conn.php');
require_once('utils.php');

$content = $_POST['content'];
if (empty($content)) {
    header('location: index.php?errCode=1');
    exit();
}

session_start();
if (!empty($_SESSION['username'])) {
    $username = $_SESSION['username'];
    // get_user_data($data = $username);
    // $nickname = $data['nickname'];
} else {
    header('location: login.php');
    exit();
    // 原先構想是不需要登入也可以留言
    // $username = NULL;
    // $nickname = '路人甲';
}

if (!check_permission($username, 0)) {
    $query_string = 'INSERT INTO jianna_w11_comments(username, content) VALUES (?, ?)';
    $stmt = $conn->prepare($query_string);
    $stmt->bind_param('ss', $username, $content);
    if (!$stmt->execute()) {
        die($conn->error);
    }
    $stmt->close();
} else {
    header('location: index.php?errCode=suspended');
    exit();
}

header('location: index.php');
