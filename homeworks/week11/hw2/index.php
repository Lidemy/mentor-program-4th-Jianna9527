<?php
require_once('conn.php');
require_once('utils.php');

$query_string = 'SELECT * FROM jianna_w11_posts where is_deleted is NULL ORDER BY create_time DESC LIMIT 5';
$stmt = $conn->prepare($query_string);
if (!$stmt->execute()) {
  die($stmt->error);
}
$result = $stmt->get_result();

$is_admin = false;
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
            }
            echo '<li><a href="handle_logout.php">登出</a></li>';
          } else {
            echo '<li><a href="login.php">登入</a></li>';
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
    <div class="posts">
      <?php while ($row = $result->fetch_assoc()) { ?>
        <article class="post">
          <div class="post__header">
            <div><?php echo escape($row['title']); ?></div>
            <div class="post__actions">
              <?php if ($is_admin) { ?>
                <a class="post__action" href="edit.php?id=<?php echo escape($row['id']); ?>">編輯</a>
              <?php } ?>
            </div>
          </div>
          <div class="post__info">
            <?php echo escape($row['create_time']); ?>
          </div>
          <div class="post__content ellipsis">
            <?php echo escape($row['content']); ?>
          </div>
          <a class="btn-read-more" href="blog.php?id=<?php echo $row['id']; ?>">READ MORE</a>
        </article>
      <?php } ?>
    </div>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>

</html>