<?php

/*
Published by Mizegerd.agency
*/

if (!function_exists('get_db_info')) {
    function get_db_info() {
        $json_data = file_get_contents(__DIR__ . '/db_info.json');
        return json_decode($json_data, true);
    }
}

if (!function_exists('connect_db')) {
    function connect_db() {
        $db_info = get_db_info();
        $conn = new mysqli($db_info['db_host'], $db_info['db_user'], $db_info['db_pass'], $db_info['db_name']);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}

if (!function_exists('get_bot_info')) {
    function get_bot_info() {
        $conn = connect_db();
        $sql = "SELECT bot_token, chat_id FROM bot_info ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);
        $bot_info = $result->fetch_assoc();
        $conn->close();
        return $bot_info;
    }
}

if (!function_exists('get_admin_id')) {
    function get_admin_id() {
        $conn = connect_db();
        $sql = "SELECT chat_id FROM bot_info ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);
        $admin_id = $result->fetch_assoc()['chat_id'];
        $conn->close();
        return $admin_id;
    }
}
?>
