<?php
require_once('conn.php');

// using user_id to get user data from sql
function get_user_data($user_id)
{
    global $conn;
    if (!empty($user_id)) {
        $query_string = sprintf(
            'SELECT * FROM jianna_w9_users where id="%d"',
            $user_id
        );
        $result = $conn->query($query_string);
        if (!$result) {
            die($conn->error);
        } else {
            $data = $result->fetch_assoc();
        }
        return $data;
    }
}
