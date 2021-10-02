<?php
require_once('conn.php');
require_once('utils.php');

if (!empty($_GET['id'])) {
    $comment_id = escape($_GET['id']);
} else {
    $msg = '奇怪耶～沒有參數你要先說～';
    echo '<script type="text/javascript">alert("' . $msg . '");location.href="index.php"</script>';
}

session_start();
check_login_status();
$username = $_SESSION['username'];

if (!check_permission($username, 1)) {
    $query_string = 'UPDATE jianna_w11_comments SET is_deleted=1 where id=? AND username=?';
    $stmt = $conn->prepare($query_string);
    $stmt->bind_param('is', $comment_id, $username);
} else {
    $query_string = 'UPDATE jianna_w11_comments SET is_deleted=1 where id=?';
    $stmt = $conn->prepare($query_string);
    $stmt->bind_param('i', $comment_id);
}
if (!$stmt->execute()) {
    die($stmt->error);
}

if ($stmt->affected_rows == 0) {
    $msg = '刪除失敗：沒有權限或該留言已不存在。';
    echo '<script type="text/javascript">alert("' . $msg . '");location.href="index.php"</script>';
} else {
    header('location: index.php');
}
