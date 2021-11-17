<?php
require_once('conn.php');
header('Content-type:application/json;charset=utf-8');
header('Access-Control-Allow-Origin: *');
if (empty($_GET['id'])) {
    die();
}

$id = $_GET['id'];
$sql = "SELECT todo_list FROM jianna_w12_todos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
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
$todos = array();
while ($row = $result->fetch_assoc()) {
    array_push($todos, $row["todo_list"]);
}

$json = array(
    "ok" => true,
    "todos" => $todos,
);

$response = json_encode($json);
echo $response;
