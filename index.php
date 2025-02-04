<?php

/*
Published by Mizegerd.agency
*/


session_start();
include('captcha/math_captcha.php');
$captchaQuestion = generateCaptcha();
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تماس با ما</title>
    <link rel="icon" href="images/favicon.png">
    <link rel="stylesheet" href="css & js/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="css & js/scripts.js" defer></script>
</head>
<body>
    <div class="contact-container">
        <div class="logo">
            <img src="images/logoC.png" alt="لوگو">
        </div>
        <h1>تماس با ما</h1>
        <form id="contact-form" action="bot/send_message.php" method="post" enctype="multipart/form-data">
            <div class="form-step form-step-active">
                <div class="form-row">
                    <div class="form-group half-width">
                        <label for="email"><i class="fas fa-envelope"></i> ایمیل:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group half-width">
                        <label for="telegram-id"><i class="fas fa-hashtag"></i> آیدی تلگرام:</label>
                        <input type="text" id="telegram-id" name="telegram-id">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group half-width">
                        <label for="name"><i class="fas fa-user"></i> نام:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group half-width">
                        <label for="lastname"><i class="fas fa-user-tag"></i> نام خانوادگی:</label>
                        <input type="text" id="lastname" name="lastname" required>
                    </div>
                </div>
                <div class="btn-container">
                    <button type="button" class="btn-next">بعدی <i class="fas fa-chevron-left" style="margin-left: 5px;"></i></button>
                </div>
            </div>
            <div class="form-step">
                <div class="form-group">
                    <label for="subject"><i class="fas fa-heading"></i> موضوع:</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                <div class="form-group">
                    <label for="message"><i class="fas fa-pencil-alt"></i> پیام:</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                <div class="form-group">
                    <label for="file-upload"><i class="fas fa-upload"></i> آپلود فایل:</label>
                    <input type="file" id="file-upload" name="file-upload">
                    <small class="file-info">فرمت‌های مجاز: JPEG, PNG, MP4</small>
                    <p id="file-error" class="error-message"></p>
                </div>
                <div class="btn-container">
                    <button type="button" class="btn-prev"><i class="fas fa-chevron-right" style="margin-left: 5px;"></i> قبلی</button>
                    <button type="button" class="btn-next">بعدی <i class="fas fa-chevron-left" style="margin-left: 5px;"></i></button>
                </div>
            </div>
            <div class="form-step">
                <div class="form-group">
                    <label for="captcha"><i class="fas fa-puzzle-piece"></i> لطفاً حل کنید: <?php echo $captchaQuestion; ?></label>
                    <input type="text" id="captcha" name="captcha" required>
                </div>
                <div class="btn-container">
                    <button type="button" class="btn-prev"><i class="fas fa-chevron-right" style="margin-left: 5px;"></i> قبلی</button>
                    <button type="submit"><i class="fas fa-paper-plane" style="margin-left: 5px;"></i> ارسال</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
