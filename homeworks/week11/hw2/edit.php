<?php
require_once('utils.php');
require_once('conn.php');

if (!empty($_GET['id'])) {
  $id = escape($_GET['id']);
  session_start();
  $username = $_SESSION['username'];
  $query_string = 'SELECT * FROM jianna_w11_posts WHERE id=? AND username=? AND is_deleted is NULL';
  $stmt = $conn->prepare($query_string);
  $stmt->bind_param('is', $id, $username);
  if (!$stmt->execute()) {
    die($stmt->error);
  }
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  if ($row < 1) {
    $msg = '錯誤：沒有權限或文章不存在！';
    echo '<script type="text/javascript">alert("' . $msg . '");window.history.back()</script>';
    exit();
  }
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
        <div>
          <?php
          /// 驗證登入狀態與身份產生 navbar 內容
          session_start();
          create_nav();
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
        <form action="handle_edit_post.php" method="POST">
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
            <input type="text" name="id" hidden value="<?php echo escape($row['id']); ?>">
            <input class="edit-post__input" name="title" placeholder="請輸入文章標題" value="<?php echo escape($row['title']); ?>" />
          </div>
          <div class="edit-post__input-wrapper">
            <textarea rows="20" class="edit-post__content" name="content"><?php echo escape($row['content']); ?></textarea>
          </div>
          <div class="edit-post__btn-wrapper">
            <input type="submit" class="edit-post__btn" value="送出">
          </div>
        </form>
      </div>
    </div>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>

</html>