<?php
require_once('utils.php');

session_start();
if (isset($_SESSION['username'])) {
    header('location: index.php');
}
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言板 - 登入</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</header>
    <div class="wrapper">
        <main class="input-form__wrapper">
            <form method="POST" action="handle_login.php">
                <div class="login_area">
                    <input type="button" value="前往註冊" onclick="location.href='register.php'">
                </div>
                <h1>登入</h1>
                <div class="input-area__wrapper">
                    <div>帳號：<input type="text" name="username"></div>
                    <div>密碼：<input type="password" name="password"></div>
                </div>
                <?php
                if (isset($_GET['errCode'])) {
                    switch (escape($_GET['errCode'])) {
                        case '1':
                            $errMsg = '請輸入帳號密碼';
                            break;
                        case '2':
                            $errMsg = '帳號未註冊';
                            break;
                        case '3':
                            $errMsg = '密碼錯誤';
                            break;
                        default:
                            $errMsg = '';
                    }
                    echo '<p class="error_message">' . $errMsg . '</p>';
                }
                ?>
                <input type="submit" value="登入">
            </form>
        </main>
    </div>
</body>