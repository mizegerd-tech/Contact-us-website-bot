<?php

/*
Published by Mizegerd.agency
*/

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function checkToken($bot_token) {
    $url = "https://api.telegram.org/bot$bot_token/getMe";
    $response = @file_get_contents($url);
    if ($response === FALSE) {
        return false;
    }
    $result = json_decode($response, true);
    return isset($result["ok"]) && $result["ok"];
}

function checkChatId($bot_token, $chat_id) {
    $url = "https://api.telegram.org/bot$bot_token/getChat?chat_id=$chat_id";
    $response = @file_get_contents($url);
    if ($response === FALSE) {
        return false;
    }
    $result = json_decode($response, true);
    return isset($result["ok"]) && $result["ok"];
}

function checkDatabase($db_host, $db_name, $db_user, $db_pass) {
    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("توکن CSRF نامعتبر است.");
    }

    $bot_token = htmlspecialchars(trim($_POST["bot_token"]));
    $chat_id = htmlspecialchars(trim($_POST["chat_id"]));
    $db_host = htmlspecialchars(trim($_POST["db_host"]));
    $db_name = htmlspecialchars(trim($_POST["db_name"]));
    $db_user = htmlspecialchars(trim($_POST["db_user"]));
    $db_pass = htmlspecialchars(trim($_POST["db_pass"]));

    $persianPattern = '/[آ-ی۰-۹]/u';
    if (preg_match($persianPattern, $bot_token) || preg_match($persianPattern, $chat_id) || preg_match($persianPattern, $db_host) || preg_match($persianPattern, $db_name) || preg_match($persianPattern, $db_user) || preg_match($persianPattern, $db_pass)) {
        die("لطفاً از کیبورد انگلیسی استفاده کنید و مطمئن شوید که هیچ کاراکتر فارسی یا عدد فارسی وارد نشده باشد.");
    }

    if (!checkToken($bot_token)) {
        die("توکن ربات نامعتبر است. لطفاً توکن خود را بررسی کنید و دوباره امتحان کنید.");
    }

    if (!checkChatId($bot_token, $chat_id)) {
        die("آیدی عددی مدیر ارائه شده ربات را شروع نکرده است یا آن را مسدود کرده است. لطفاً ربات را شروع کنید و دوباره امتحان کنید.");
    }

    $db_check = checkDatabase($db_host, $db_name, $db_user, $db_pass);
    if (is_string($db_check)) {
        die("خطای دیتابیس: " . $db_check);
    }

    include('table.php');

    try {
        $sql = "SELECT COUNT(*) FROM bot_info";
        $stmt = $db_check->query($sql);
        $count_bot_info = $stmt->fetchColumn();

        if ($count_bot_info > 0) {
            $sql = "UPDATE bot_info SET bot_token = :bot_token, chat_id = :chat_id WHERE id = 1";
            $stmt = $db_check->prepare($sql);
            $stmt->execute(['bot_token' => $bot_token, 'chat_id' => $chat_id]);
            $message = "ربات شما بروز رسانی شد";
        } else {
            $sql = "INSERT INTO bot_info (bot_token, chat_id) VALUES (:bot_token, :chat_id)";
            $stmt = $db_check->prepare($sql);
            $stmt->execute(['bot_token' => $bot_token, 'chat_id' => $chat_id]);
            $message = "ربات شما ساخته شد";
        }

        file_get_contents("https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=" . urlencode($message));

        $sql = "SELECT COUNT(*) FROM db_info";
        $stmt = $db_check->query($sql);
        $count_db_info = $stmt->fetchColumn();

        if ($count_db_info > 0) {
            $sql = "UPDATE db_info SET db_host = :db_host, db_name = :db_name, db_user = :db_user, db_pass = :db_pass WHERE id = 1";
            $stmt = $db_check->prepare($sql);
            $stmt->execute(['db_host' => $db_host, 'db_name' => $db_name, 'db_user' => $db_user, 'db_pass' => $db_pass]);
        } else {
            $sql = "INSERT INTO db_info (db_host, db_name, db_user, db_pass) VALUES (:db_host, :db_name, :db_user, :db_pass)";
            $stmt = $db_check->prepare($sql);
            $stmt->execute(['db_host' => $db_host, 'db_name' => $db_name, 'db_user' => $db_user, 'db_pass' => $db_pass]);
        }

        $db_info = [
            'db_host' => $db_host,
            'db_name' => $db_name,
            'db_user' => $db_user,
            'db_pass' => $db_pass
        ];

        $json_file_path = '../bot/db_info.json';

        if (file_exists($json_file_path)) {
            unlink($json_file_path);
        }

        file_put_contents($json_file_path, json_encode($db_info));

    } catch (PDOException $e) {
        die("خطای دیتابیس: " . $e->getMessage());
    }

    set_webhook($bot_token);

    $install_data_path = 'install_data.json';
    if (file_exists($install_data_path)) {
        unlink($install_data_path);
    }

    header("Location: ../install/success.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه نصب</title>
    <link rel="stylesheet" href="../css & js/install.css">
    <link rel="icon" href="../images/favicon.png" type="image/png">
    <link rel="shortcut icon" href="../images/favicon.png" type="image/png">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../css & js/install.js"></script>
</head>
<body>
    <div class="container justify-content-center align-items-center min-vh-100" id="main-content">
        <div class="contact-container shadow-lg animated-panel text-center">
            <div class="logo">
                <img src="../images/logo.png" alt="لوگو" class="card-logo">
            </div>
            <form id="install-form" action="install.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <div class="form-row">
                    <div class="form-group">
                        <label for="bot_token">توکن ربات</label>
                        <input type="text" id="bot_token" name="bot_token" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="chat_id">آیدی عددی مدیر</label>
                        <input type="text" id="chat_id" name="chat_id" class="form-control" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="db_host">میزبان دیتابیس</label>
                        <input type="text" id="db_host" name="db_host" class="form-control" value="localhost" required>
                    </div>
                    <div class="form-group">
                        <label for="db_name">نام دیتابیس</label>
                        <input type="text" id="db_name" name="db_name" class="form-control" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="db_user">کاربر دیتابیس</label>
                        <input type="text" id="db_user" name="db_user" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="db_pass">گذرواژه دیتابیس</label>
                        <input type="password" id="db_pass" name="db_pass" class="form-control" required>
                    </div>
                </div>
                <button type="submit" class="btn">نصب</button>
            </form>
        </div>
    </div>
</body>
</html>
