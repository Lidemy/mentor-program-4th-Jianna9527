<?php
require_once('conn.php');
require_once('utils.php');

$query_string = 'SELECT * FROM jianna_w11_posts WHERE is_deleted is NULL ORDER BY create_time DESC';
$stmt = $conn->prepare($query_string);
if (!$stmt->execute()) {
  die($stmt->error);
}
$result = $stmt->get_result();
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
          // 驗證登入狀態與身份產生 navbar 內容
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
      <div class="admin-posts">
        <?php while ($row = $result->fetch_assoc()) { ?>
          <div class="admin-post">
            <div class="admin-post__title">
              <a href="blog.php?id=<?php echo escape($row['id']) ?>"><?php echo escape($row['title']); ?></a>
            </div>
            <div class="admin-post__info">
              <div class="admin-post__created-at">
                <?php echo escape($row['create_time']); ?>
              </div>
              <?php if ($is_admin) { ?>
                <a class="admin-post__btn" href="edit.php?id=<?php echo escape($row['id']); ?>">
                  編輯
                </a>
                <a class="admin-post__btn" href="handle_delete_post.php?id=<?php echo escape($row['id']); ?>">
                  刪除
                </a>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <footer>Copyright © 2020 Who's Blog All Rights Reserved.</footer>
</body>

</html>