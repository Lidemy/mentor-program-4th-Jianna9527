<?php
require_once('conn.php');
require_once('utils.php');
session_start();
if (is_logged()) {
    $username = $_SESSION['username'];
    if (!check_permission($username, 1)) {
        header('location: index.php');
        exit();
    }
}

if (empty($_POST['title']) || empty($_POST['content'])) {
    header('location: add.php?errCode=1');
    exit();
}

$query_string = 'INSERT INTO jianna_w11_posts(username, title, content) VALUES (?, ?, ?)';
$stmt = $conn->prepare($query_string);
$stmt->bind_param('sss', $username, $_POST['title'], $_POST['content']);
if (!$stmt->execute()) {
    die($stmt->error);
    exit();
}

header('location: index.php');
