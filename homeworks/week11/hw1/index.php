<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once 'conn.php';
require_once 'utils.php';

//總留言數
$stmt = $conn->prepare('SELECT count(id) AS count FROM jianna_w11_comments WHERE is_deleted IS NULL');
if ($stmt->execute()) {
    // die($stmt->errno);
}
$total = $stmt->get_result()->fetch_assoc()['count'];
$limit = 5;
$page_total = ceil(intval($total) / $limit);

// 頁數控制
$page_now = empty($_GET['page']) ? 1 : intval($_GET['page']);
$offset = ($page_now - 1) * $limit;

setcookie('page', $page_now, time() + 60);

$query_string =
    'SELECT comments.id, comments.username, comments.content, comments.create_time, users.nickname ' .
    'FROM jianna_w11_comments AS comments ' .
    'LEFT JOIN jianna_w11_users AS users ' .
    'ON comments.username = users.username ' .
    'WHERE comments.is_deleted IS NULL ' .
    'ORDER BY comments.id DESC ' .
    'LIMIT ? OFFSET ?';

$stmt = $conn->prepare($query_string);
$stmt->bind_param('ii', $limit, $offset);
if (!$stmt->execute()) {
    die($stmt->error);
}
$result = $stmt->get_result();

$has_logged = false;
session_start();
if (isset($_SESSION['username'])) { //已登入
    $username = $_SESSION['username'];
    $data = get_user_data($username);
    $nickname = $data['nickname'];
    $has_logged = true;
    $role = $data['role'];
}
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
                    if ($has_logged) {
                    ?>
                        <input type="button" value="登出" onclick="location.href='handle_logout.php'">
                        <input type="button" value="編輯暱稱" onclick="showModal()">
                        <?php if (!empty($role) && $role == 1) { ?>
                            <input class="btn-warning" type="button" value="權限管理" onclick="location.href='member.php'">
                        <?php } ?>
                        <p>嗨～<span class="login_username"><?php echo escape($nickname); ?></span>，快來留言吧！</p>
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
                <?php
                if (!$has_logged) {
                ?>
                    <textarea disabled name="content" cols="50" rows="10" placeholder="登入後才能留言哦！"></textarea>
                <?php
                } else {
                ?>
                    <textarea name="content" cols="50" rows="10" placeholder="在想什麼呢？留個言吧！"></textarea>
                <?php
                }
                ?>
                <div class="submit_wrapper">
                    <?php
                    if (!$has_logged) {
                    ?>
                        <input disabled type="submit" value="請先登入">
                    <?php
                    } else {
                    ?>
                        <input type="submit" value="提交">
                    <?php
                    }
                    ?>
                    <?php
                    if (isset($_GET['errCode'])) {
                        switch (escape($_GET['errCode'])) {
                            case '1':
                                $errMsg = '別醬～還是先打個字再提交吧！';
                                break;
                            case 'suspended':
                                $errMsg = '您已被停權，無法新增留言';
                                break;
                            default:
                                $errMsg = '';
                        }
                        echo '<p class="error_message">' . $errMsg . '</p>';
                    }
                    ?>
                </div>
            </form>
            <div class="divider"></div>
            <?php
            while ($row = $result->fetch_assoc()) {
            ?>
                <div class="comment_block">
                    <div class="flex">
                        <!-- <img src="" alt="使用者頭像"> -->
                        <div class="comment_avatar"></div>
                        <div>
                            <div class="comment_info">
                                <div class="comment_username">
                                    <?php
                                    $str_nickname = (empty($row['nickname'])) ? '路人甲' : escape($row['nickname']);
                                    $str_username = (empty($row['username'])) ? '' : ' (@' . escape($row['username']) . ')';
                                    echo  $str_nickname . $str_username ?>
                                </div>
                                <div class="comment_time"><?php echo escape($row['create_time']); ?></div>
                            </div>
                            <div class="comment_text"><?php echo escape($row['content']); ?></div>
                        </div>
                    </div>
                    <?php if (isset($_SESSION['username']) && $_SESSION['username'] === $row['username']) { ?>
                        <div class="comment_action">
                            <a class="btn-normal" href="edit_comment.php?id=<?php echo $row['id']; ?>">編輯</a>
                            <a class="btn-warning" href="handle_delete_comment.php?id=<?php echo $row['id']; ?>">刪除</a>
                        </div>
                    <?php } elseif (!empty($role) && $role == 1) { ?>
                        <div class="comment_action">
                            <a class="btn-normal hide" href="edit_comment.php?id=<?php echo $row['id']; ?>">編輯</a>
                            <a class="btn-warning" href="handle_delete_comment.php?id=<?php echo $row['id']; ?>">刪除</a>
                        </div>
                    <?php } ?>
                </div>
            <?php
            }
            ?>
            <div class="modal_wrapper hide"></div>
            <div class="modal hide">
                <form method="POST" action="handle_edit_nickname.php">
                    <h1>編輯暱稱</h1>
                    <div class="input-area__wrapper">
                        <div>新暱稱：<input type="text" name="nickname_new"></div>
                    </div>
                    <script>
                        function showModal() {
                            document.querySelector('.modal').classList.remove('hide');
                            document.querySelector('.modal_wrapper').classList.remove('hide');
                        }

                        function cancelModal() {
                            document.querySelector('.modal').classList.add('hide');
                            document.querySelector('.modal_wrapper').classList.add('hide');
                            if (location.search == '?errCode=2') { // 避免顯示錯誤訊息
                                window.location.href = 'index.php';
                            }
                        }

                        const element = document.querySelector('.modal_wrapper');
                        element.addEventListener('click', function(e) {
                            document.querySelector('.modal').classList.add('hide');
                            document.querySelector('.modal_wrapper').classList.add('hide');
                            if (location.search == '?errCode=2') { // 避免顯示錯誤訊息
                                window.location.href = 'index.php';
                            }
                        });
                    </script>
                    <?php
                    if (isset($_GET['errCode'])) {
                        switch (escape($_GET['errCode'])) {
                            case '2':
                                $errMsg = '請輸入新暱稱';
                                echo '<script>showModal();</script>';
                                break;
                            default:
                                $errMsg = '';
                        }
                        echo '<p class="error_message">' . $errMsg . '</p>';
                    }
                    ?>
                    <input type="button" value="取消" onclick="cancelModal()">
                    <input type="submit" value="送出">
                </form>
            </div>
            <div class="page">
                <p><?php echo '共有 ' . $total . ' 筆留言，頁數：' . $page_now . '／' . $page_total ?></p>
                <div class="page_btn">
                    <?php
                    if ($page_now != 1) {
                        echo '<a class="btn-normal" href="index.php">首頁</a>';
                        echo '<a class="btn-normal" href="index.php?page=' . $page_now - 1 . '">上一頁</a>';
                    }
                    if ($page_now != $page_total) {
                        echo '<a class="btn-normal" href="index.php?page=' . $page_now + 1 . '">下一頁</a>';
                        echo '<a class="btn-normal" href="index.php?page=' . $page_total . '">最末頁</a>';
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>
    <script src="utils.js"></script>
</body>