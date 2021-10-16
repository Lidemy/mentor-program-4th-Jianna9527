<?php
require_once('conn.php');
require_once('utils.php');

session_start();
if (!empty($_GET['id'])) {
    $comment_id = escape($_GET['id']);
} else {
    $msg = '奇怪耶～沒有參數你要先說～';
    echo '<script type="text/javascript">alert("' . $msg . '");location.href="index.php"</script>';
}

session_start();
check_login_status();
$username = $_SESSION['username'];

$query_string = 'SELECT username, content FROM jianna_w11_comments WHERE id=? AND username=? AND is_deleted is NULL';
$stmt = $conn->prepare($query_string);
$stmt->bind_param('is', $comment_id, $username);
if (!$stmt->execute()) {
    die($stmt->error);
}
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    $msg = '載入失敗：沒有編輯權限或該留言不存在。';
    echo '<script type="text/javascript">alert("' . $msg . '");location.href="index.php"</script>';
}
$row = $result->fetch_assoc();
$old_comment = $row['content'];
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言板 - 編輯留言</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</header>
    <div class="wrapper">
        <main class="input-form__wrapper">
            <form method="POST" action="handle_edit_comment.php">
                <div class="login_area">
                    <input type="button" value="回留言板" onclick="location.href='index.php'">
                </div>
                <h1>編輯留言</h1>
                <input type="text" name="id" id="id" style="visibility: hidden;" value="<?php echo $comment_id; ?>">
                <textarea name="content" cols="50" rows="10" placeholder="在想什麼呢？留個言吧！"><?php echo escape($old_comment); ?></textarea>
                <input class="submit_new_comment" type="submit" value="提交">
                <?php
                if (isset($_GET['errCode'])) {
                    switch (escape($_GET['errCode'])) {
                        case '1':
                            $errMsg = '別醬～還是先打個字再提交吧！';
                            break;
                        default:
                            $errMsg = '';
                    }
                    echo '<p class="error_message">' . $errMsg . '</p>';
                }
                ?>
            </form>
        </main>
    </div>
    <script src="utils.js"></script>
</body>