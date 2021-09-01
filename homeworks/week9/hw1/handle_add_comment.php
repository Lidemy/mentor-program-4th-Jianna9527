<?php
require_once('conn.php');
require_once('utils.php');
session_start();
if (!empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $data = get_user_data($user_id);
    $nickname = $data['nickname'];
}
if (empty($nickname)) {
    $nickname = '路人甲';
}
$content = $_POST['content'];
$query_string = sprintf(
    'INSERT INTO jianna_w9_comments(nickname, content) VALUES ("%s", "%s")',
    $nickname,
    $content
);

$result = $conn->query($query_string);
if (!$result) {
    die($conn->error);
}

header('Location: index.php');
