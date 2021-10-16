<?php
require_once('conn.php');
require_once('utils.php');

session_start();
check_login_status();
$username = $_SESSION['username'];

if (!check_permission($username, 1)) {
    header('location: index.php');
    exit();
}

if (!empty($_POST)) {
    $query_string = 'UPDATE jianna_w11_users SET role=? WHERE username=?';
    $stmt = $conn->prepare($query_string);
    foreach ($_POST as $key => $value) {
        $stmt->bind_param('is', $value, $key);
        if (!$stmt->execute()) {
            die($stmt->error);
        }
    }
}

header('location: member.php');
