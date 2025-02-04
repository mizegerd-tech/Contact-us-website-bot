<?php
/*
Published by Mizegerd.agency
*/

include 'get_info.php';

function send_telegram_message($text) {
    $bot_info = get_bot_info();
    $url = "https://api.telegram.org/bot" . $bot_info['bot_token'] . "/sendMessage";

    $postFields = [
        'chat_id' => $bot_info['chat_id'],
        'text' => $text
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

function send_telegram_file($filePath) {
    $bot_info = get_bot_info();
    $url = "https://api.telegram.org/bot" . $bot_info['bot_token'] . "/sendDocument";

    $postFields = [
        'chat_id' => $bot_info['chat_id'],
        'document' => new CURLFile(realpath($filePath))
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type:multipart/form-data"
    ));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

function set_webhook($bot_token) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domain = $protocol . $_SERVER['HTTP_HOST'];
    $webhook_url = $domain . '/project-root/bot/bot.php';

    $url = "https://api.telegram.org/bot$bot_token/setWebhook?url=$webhook_url";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

function handle_start_message($chat_id) {
    $start_message = "ربات روشن است! 👋";
    $bot_info = get_bot_info();
    $url = "https://api.telegram.org/bot" . $bot_info['bot_token'] . "/sendMessage";

    $postFields = [
        'chat_id' => $chat_id,
        'text' => $start_message
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (isset($update["message"])) {
    $message = $update["message"];
    $chat_id = $message["chat"]["id"];
    $text = $message["text"];

    $admin_id = get_admin_id();
    if ($chat_id != $admin_id) {
        send_telegram_message("شما دسترسی به این ربات ندارید.");
        exit;
    }

    if ($text == "/start") {
        handle_start_message($chat_id);
    }
}
?>
