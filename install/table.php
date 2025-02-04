<?php

/*
Published by Mizegerd.agency
*/

$pdo = $db_check;

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS bot_info (
        id INT AUTO_INCREMENT PRIMARY KEY,
        bot_token VARCHAR(255) NOT NULL,
        chat_id VARCHAR(255) NOT NULL
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS db_info (
        id INT AUTO_INCREMENT PRIMARY KEY,
        db_host VARCHAR(255) NOT NULL,
        db_name VARCHAR(255) NOT NULL,
        db_user VARCHAR(255) NOT NULL,
        db_pass VARCHAR(255) NOT NULL
    )");
} catch (PDOException $e) {
    die("خطای دیتابیس: " . $e->getMessage());
}
?>
