<?php
require_once('utils.php');
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">

    <title>部落格</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="normalize.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <nav class="navbar">
        <div class="wrapper navbar__wrapper">
            <div class="navbar__site-name">
                <a href='index.php'>Who's Blog</a>
            </div>
            <ul class="navbar__list">
                <div>
                    <li><a href="list.php">文章列表</a></li>
                    <!-- <li><a href="#">分類專區</a></li> -->
                    <!-- <li><a href="#">關於我</a></li> -->
                </div>
                <div>
                    <?php
                    // 驗證登入狀態與身份
                    session_start();
                    if (is_logged()) {
                        $username = $_SESSION['username'];
                        if (check_permission($username, 1)) {
                            $is_admin = true;
                            echo '<li><a href="add.php">新增文章</a></li>';
                            // echo '<li><a href="admin.php">管理後台</a></li>';
                        } else {
                            header('location: index.php');
                            exit();
                        }
                        echo '<li><a href="handle_logout.php">登出</a></li>';
                    } else {
                        echo '<li><a href="login.php">登入</a></li>';
                        header('location: index.php');
                        exit();
                    }
                    ?>
                </div>
            </ul>
        </div>
    </nav>
    <section class="banner">
        <div class="banner__wrapper">
            <h1>存放技術之地</h1>
            <div>Welcome to my blog</div>
        </div>
    </section>
    <div class="container-wrapper">
        <div class="container">
            <div class="edit-post">
                <form action="handle_add_post.php" method="POST">
                    <div class="edit-post__title">
                        <p class="status-text">
                            <?php
                            $errCode = (!empty($_GET['errCode'])) ? $_GET['errCode'] : '';
                            switch ($errCode) {
                                case '1':
                                    echo '請輸入標題與內文';
                                    break;
                                default:
                                    echo '';
                            }
                            ?>
                        </p>
                        發表文章：
                    </div>
                    <div class="edit-post__input-wrapper">
                        <input class="edit-post__input" name="title" placeholder="請輸入文章標題" />
                    </div>
                    <div class="edit-post__input-wrapper">
                        <textarea rows="20" class="edit-post__content" name="content"></textarea>
                    </div>
                    <div class="edit-post__btn-wrapper">
                        <input type="submit" class="edit-post__btn" value="送出">
                        <!-- <div class="edit-post__btn">送出</div> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>

</html>