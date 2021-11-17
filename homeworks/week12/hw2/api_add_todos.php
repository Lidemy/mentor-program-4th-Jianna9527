<?php
require_once('conn.php');
header('Content-type:application/json;charset=utf-8');
header('Access-Control-Allow-Origin: *');
if (empty($_POST['todos'])) {
    $json = array(
        "ok" => false,
        "message" => "請輸入完整資訊"
    );
    $response = json_encode($json);
    echo $response;
    die();
}

$todos = $_POST['todos'];

$sql = "INSERT INTO jianna_w12_todos(todo_list) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $todos);
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
$json = array(
    "ok" => true,
    "message" => "successfully saved!",
    "id" => $conn->insert_id,
);

$response = json_encode($json);
echo $response;
