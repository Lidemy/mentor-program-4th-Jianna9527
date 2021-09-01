<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言板 - 註冊帳號</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>注意！本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。</header>
    <div class="wrapper">
        <main class="register-form__wrapper">
            <form method="POST" action="handle_register.php">
                <div class="login_area">
                    <input type="button" value="回留言板" onclick="location.href='index.php'">
                </div>
                <h1>註冊資訊</h1>
                <div class="register-info__wrapper">
                    <div>暱稱：<input type="text" name="nickname"></div>
                    <div>帳號：<input type="text" name="username"></div>
                    <div>密碼：<input type="password" name="password"></div>
                </div>
                <?php
                switch ($_GET['errCode']) {
                    case '1':
                        $errMsg = '請完整輸入註冊資訊';
                        break;
                    case '1062':
                        $errMsg = '帳號已被註冊';
                        break;
                }
                echo '<p class="error_message">' . $errMsg . '</p>';
                ?>
                <input type="submit" value="註冊">
            </form>
        </main>
    </div>
</body>