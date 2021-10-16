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

if (empty($_POST['title']) || empty($_POST['content'])) {
    header('location: edit.php?id=' . $_POST['id'] . '&errCode=1');
    exit();
}

$query_string = 'UPDATE jianna_w11_posts SET title=?, content=? WHERE id=? AND username=? AND is_deleted is NULL';
$stmt = $conn->prepare($query_string);
$stmt->bind_param('ssis', $_POST['title'], $_POST['content'], $_POST['id'], $username);
if (!$stmt->execute()) {
    die($stmt->error);
    exit();
}

if ($stmt->affected_rows == 0) {
    $msg = '錯誤：內容未變更、沒有權限或文章不存在！';
    echo '<script type="text/javascript">alert("' . $msg . '");location.href="index.php"</script>';
    exit();
}

header('location: index.php');
