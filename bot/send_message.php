<?php

/*
Published by Mizegerd.agency
*/


include 'get_info.php';
include 'bot.php';
include '../captcha/math_captcha.php';

function getUserIP() {
    $ip = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function isValidFile($file) {
    $allowedTypes = ['image/jpeg', 'image/png', 'video/mp4'];
    return in_array($file['type'], $allowedTypes) && $file['size'] <= 5242880;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $telegramID = htmlspecialchars($_POST['telegram-id']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
    $captcha = htmlspecialchars($_POST['captcha']);
    $userIP = getUserIP();

    if (!verifyCaptcha($captcha)) {
        die("پاسخ کپچا نادرست است. ❌");
    }

    $text = "📩 پیام جدید از فرم تماس با ما:\n";
    $text .= "👤 نام: $name\n";
    $text .= "👥 نام خانوادگی: $lastname\n";
    $text .= "📧 ایمیل: $email\n";
    $text .= "🆔 آیدی تلگرام: $telegramID\n";
    $text .= "📝 موضوع: $subject\n";
    $text .= "💬 پیام: $message\n";
    $text .= "🌐 آدرس IP: $userIP";

    $fileURL = null;

    if (isset($_FILES['file-upload']) && isValidFile($_FILES['file-upload'])) {
        $uploadDir = '../uploads/';
        $uploadFile = $uploadDir . basename($_FILES['file-upload']['name']);

        if (move_uploaded_file($_FILES['file-upload']['tmp_name'], $uploadFile)) {
            $fileURL = $uploadFile;
        } else {
            die("بارگذاری فایل شکست خورد. 📂");
        }
    }

    if ($fileURL) {
        $text .= "\n📎 فایل: $fileURL";
    }

    send_telegram_message($text);

    if ($fileURL) {
        send_telegram_file($fileURL);
        unlink($fileURL);
    }

    header("Location: ../success.php");
    exit();
}
?>
