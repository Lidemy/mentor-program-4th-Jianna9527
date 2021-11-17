<?php
require_once('conn.php');
header('Content-type:application/json;charset=utf-8');
header('Access-Control-Allow-Origin: *');
if (empty($_GET['site_key'])) {
    $json = array(
        "ok" => false,
        "message" => "請在 url 提供留言板代碼"
    );

    $response = json_encode($json);
    echo $response;
    die();
}

$site_key = $_GET['site_key'];
// 取得第一筆 id，在「載入更多」時使用
$sql = "SELECT id FROM jianna_w12_comments WHERE site_key = ? ORDER BY id LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $site_key);
$result = $stmt->execute();
if(!$result){
    $json = array(
        "ok" => false,
        "message" => $conn->error
    );
    $response = json_encode($json);
    echo $response;
    die();
}
$result = $stmt->get_result();
$first_id = $result->fetch_assoc()['id'];

// 載入五筆留言
$offset = empty($_GET['offset']) ? 0 : (int)$_GET['offset'];
$sql = "SELECT * FROM jianna_w12_comments WHERE site_key = ? ORDER BY id DESC LIMIT 5 OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $site_key, $offset);
$result = $stmt->execute();

if (!$result) {
    $json = array(
        "ok" => false,
        "message" => $conn->error
    );
    $response = json_encode($json);
    echo $response;
    die();
}

$result = $stmt->get_result();
$comments = array();
while ($row = $result->fetch_assoc()) {
    array_push($comments, array(
        "id" => $row["id"],
        "nickname" => $row["nickname"],
        "content" => $row["content"],
        "created_at" => $row["created_at"]
    ));
}

$json = array(
    "ok" => true,
    "comments" => $comments,
    "first_id" => $first_id,
);

$response = json_encode($json);
echo $response;
