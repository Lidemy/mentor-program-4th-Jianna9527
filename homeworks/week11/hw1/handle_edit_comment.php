<?php
require_once('conn.php');
require_once('utils.php');

if (!empty($_POST['id'])) {
    $id = escape($_POST['id']);
} else {
    $msg = '錯誤：遺漏 id，請重新操作！';
    echo '<script type="text/javascript">alert("' . $msg . '");location.href="index.php"</script>';
}

if (!empty($_POST['content'])) {
    $content = $_POST['content'];
} else {
    header('location: edit_comment.php?id=' . $id . '&errCode=1');
    exit();
}

session_start();
check_login_status();
$username = $_SESSION['username'];

$query_string = 'UPDATE jianna_w11_comments SET content=? WHERE id=? AND username=? AND is_deleted is NULL';
$stmt = $conn->prepare($query_string);
$stmt->bind_param('sis', $content, $id, $username);
if (!$stmt->execute()) {
    die($stmt->error);
}

$result = $stmt->get_result();
if ($stmt->affected_rows == 0) {
    $msg = '編輯失敗：內容未變更、沒有權限或該留言不存在。';
    echo '<script type="text/javascript">alert("' . $msg . '");location.href="index.php"</script>';
} else {
    header('location: index.php?page=' . $_COOKIE['page']);
}
