$(document).ready(function() {
    /*
Published by Mizegerd.agency
*/
    console.log("فایل جاوااسکریپت با موفقیت بارگذاری شد.");

    $('.animated-panel').css('animation', 'slideIn 1s ease-out');

    $('#install-form').on('submit', function(e) {
        const botToken = $('#bot_token').val();
        const chatId = $('#chat_id').val();
        const dbHost = $('#db_host').val();
        const dbName = $('#db_name').val();
        const dbUser = $('#db_user').val();
        const dbPass = $('#db_pass').val();

        if (!botToken || !chatId || !dbHost || !dbName || !dbUser || !dbPass) {
            e.preventDefault();
            alert('لطفاً تمامی فیلدها را پر کنید.');
        }
    });

    if ($('.error-message').length) {
        alert($('.error-message').text());
    }
});
