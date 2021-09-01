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
        <main class="register-form__wrapper">
            <form method="POST" action="handle_login.php">
                <div class="login_area">
                    <input type="button" value="前往註冊" onclick="location.href='register.php'">
                </div>
                <h1>登入</h1>
                <div class="register-info__wrapper">
                    <div>帳號：<input type="text" name="username"></div>
                    <div>密碼：<input type="password" name="password"></div>
                </div>
                <?php
                switch ($_GET['errCode']) {
                    case '1':
                        $errMsg = '請輸入帳號密碼';
                        break;
                    case '2':
                        $errMsg = '帳號密碼輸入錯誤或未註冊';
                        break;
                }
                echo '<p class="error_message">' . $errMsg . '</p>';
                ?>
                <input type="submit" value="登入">
            </form>
        </main>
    </div>
</body>