<?php
require_once('conn.php');
$query_string = 'SELECT * FROM jianna_w9_comments ORDER BY id DESC';

$result = $conn->query($query_string);
if (!$result) {
    die($conn->error);
}

while ($row = $result->fetch_assoc()) {
    echo $row['nickname'] . '<br>';
    echo $row['create_time'] . '<br>';
    echo $row['content'] . '<br>';
}
