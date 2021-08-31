<?php
require_once('conn.php');
require_once('utils.php');
$query_string = 'SELECT * FROM jianna_w9_comments ORDER BY id DESC';

$result = $conn->query($query_string);
if (!$result) {
    die($conn->error);
}

session_start();
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$data = get_user_data($user_id);
$nickname = $data['nickname'];
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言板</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</header>
    <div class="wrapper">
        <main class="form_wrapper">
            <form method="POST" action="handle_add_comment.php">
                <div class="login_area">
                    <?php
                    if ($nickname && $nackname !== '') {
                    ?>
                        <input type="button" value="登出" onclick="location.href='handle_logout.php'">
                        <p>嗨，<?php echo $nickname ?>～快來留言吧！</p>
                    <?php
                    } else {
                    ?>
                        <input type="button" value="登入" onclick="location.href='login.php'">
                        <p>不想再當路人甲？立即
                            <a href="register.php">註冊</a>
                        </p>
                    <?php
                    }
                    ?>
                </div>
                <h1>Comments</h1>
                <textarea name="content" cols="50" rows="10" placeholder="在想什麼呢？留個言吧！"></textarea>
                <br>
                <input type="submit" value="提交">
            </form>
            <div class="divider"></div>
            <?php
            while ($row = $result->fetch_assoc()) {
            ?>
                <div class="comment_block">
                    <!-- <img src="" alt="使用者頭像"> -->
                    <div class="img"></div>
                    <div>
                        <div class="comment_info">
                            <div class="comment_username"><?php echo $row['nickname']; ?></div>
                            <div class="comment_time"><?php echo $row['create_time']; ?></div>
                        </div>
                        <div class="comment_text"><?php echo $row['content']; ?></div>
                    </div>
                </div>
            <?php
            }
            ?>
        </main>
    </div>
</body>