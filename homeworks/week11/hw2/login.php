<?php
require_once('utils.php');

session_start();
if (is_logged()) {
  header('location: index.php');
  exit();
}
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
      </ul>
    </div>
  </nav>
  <section class="banner">
    <div class="banner__wrapper">
      <h1>存放技術之地</h1>
      <div>Welcome to my blog</div>
    </div>
  </section>
  <div class="login-wrapper">
    <h2>Login</h2>
    <form action="handle_login.php" method="POST">
      <div class="input__wrapper">
        <div class="input__label">USERNAME</div>
        <input class="input__field" type="text" name="username" />
      </div>

      <div class="input__wrapper">
        <div class="input__label">PASSWORD</div>
        <input class="input__field" type="password" name="password" />
      </div>
      <input type='submit' value="登入" />
      <p class="status-text">
        <?php
        $errCode = (!empty($_GET['errCode'])) ? $_GET['errCode'] : '';
        switch ($errCode) {
          case '1':
            echo '請輸入帳號密碼';
            break;
          case '2':
            echo '無此帳號';
            break;
          case '3':
            echo '密碼錯誤';
            break;
          default:
            echo '';
        }
        ?>
      </p>
    </form>

  </div>
</body>

</html>