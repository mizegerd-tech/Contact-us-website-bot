
# 📱 Contact Bot Website
A simple contact form website that connects to a Telegram bot for message forwarding and automated responses.
![Banner](https://github.com/user-attachments/assets/ddd7b1e8-7854-4103-b444-157b6ff86624)

### Table of Contents
1. [Install & Run](#install--run)
2. [Features](#features)
3. [Contributing](#contributing)
4. [License](#license)

### Install & Run

#### Prerequisites
1. Install **PHP** (version 7.4+ recommended).
2. Install a web server like **Apache** or use built-in PHP development server.
3. Set up **Telegram Bot API Token**.
4. Ensure **cURL** and **GD** extensions are enabled in PHP.

#### Steps

1. **Install PHP & Apache**  
   ```bash
   sudo apt update
   sudo apt install apache2 php libapache2-mod-php php-curl php-gd
   ```

2. **Clone the Repository**  
   ```bash
   git clone https://github.com/your-repo/contact-bot-site.git
   cd contact-bot-site
   ```

3. **Configure the Bot**  
   Open `bot.php` and update the **Telegram Bot Token** and **Chat ID**:
   ```php
   $botToken = "YOUR_BOT_TOKEN";
   $chatId = "YOUR_CHAT_ID";
   ```

4. **Run PHP Server**  
   ```bash
   php -S localhost:8000
   ```

5. **Access the Website**  
   Open `http://localhost:8000/index.php` in your browser.

### Features
- 📩 **Contact Form Submission**: Users can send messages via the form.
- 🤖 **Telegram Bot Integration**: Messages are forwarded to a Telegram bot.
- 🔐 **Captcha Verification**: Protects against spam with mathematical captchas.
- 🌐 **Easy Deployment**: Simple to set up and deploy.
- 🚀 **Fast & Secure**: Lightweight with security measures in place.

---

## فارسی (Persian)

### عنوان پروژه
**سایت ارتباط با ما و متصل به ربات**  
یک وب‌سایت ساده برای ارسال پیام از طریق فرم تماس که به یک ربات تلگرام متصل است و پیام‌ها را به صورت خودکار ارسال می‌کند.

---

### فهرست مطالب
1. [نصب و اجرا](#نصب-و-اجرا)
2. [ویژگی‌ها](#ویژگی‌ها)
3. [مشارکت](#مشارکت)
4. [مجوز](#مجوز)

### نصب و اجرا

#### پیش‌نیازها
1. نصب **PHP** (ترجیحاً نسخه 7.4+).
2. نصب **Apache** یا استفاده از سرور داخلی PHP.
3. تنظیم **توکن ربات تلگرام**.
4. فعال‌سازی افزونه‌های **cURL** و **GD** در PHP.

#### مراحل

1. **نصب PHP و Apache**  
   ```bash
   sudo apt update
   sudo apt install apache2 php libapache2-mod-php php-curl php-gd
   ```

2. **کلون کردن ریپازیتوری**  
   ```bash
   git clone https://github.com/your-repo/contact-bot-site.git
   cd contact-bot-site
   ```

3. **پیکربندی ربات**  
   فایل `bot.php` را باز کرده و **توکن ربات تلگرام** و **Chat ID** را به‌روز کنید:
   ```php
   $botToken = "توکن_ربات_شما";
   $chatId = "شناسه_چت_شما";
   ```

4. **اجرای سرور PHP**  
   ```bash
   php -S localhost:8000
   ```

5. **دسترسی به سایت**  
   مرورگر خود را باز کنید و به `http://localhost:8000/index.php` بروید.

### ویژگی‌ها
- 📩 **ارسال پیام از فرم تماس**: کاربران می‌توانند از طریق فرم پیام ارسال کنند.
- 🤖 **اتصال به ربات تلگرام**: پیام‌ها به ربات تلگرام ارسال می‌شوند.
- 🔐 **تأیید امنیتی Captcha**: جلوگیری از اسپم با کپچای ریاضی.
- 🌐 **راه‌اندازی آسان**: ساده و سریع برای اجرا و استفاده.
- 🚀 **سبک و امن**: عملکرد بهینه با اقدامات امنیتی مناسب.

---

### Contributing (مشارکت)
1. Fork the repository.  
   ریپازیتوری را فورک کنید.
   
2. Create a new branch: `git checkout -b feature-branch`.  
   یک شاخه جدید ایجاد کنید: `git checkout -b feature-branch`.
   
3. Make your changes and commit: `git commit -m 'Add new feature'`.  
   تغییرات خود را اعمال کنید و کامیت بزنید: `git commit -m 'افزودن ویژگی جدید'`.
   
4. Push to the branch: `git push origin feature-branch`.  
   تغییرات را پوش کنید: `git push origin feature-branch`.
   
5. Submit a pull request.  
   درخواست Pull Request ارسال کنید.

---

### License (مجوز)
This project is licensed under the MIT License.  
این پروژه تحت مجوز MIT ارائه شده است.
