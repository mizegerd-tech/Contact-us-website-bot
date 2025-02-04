<?php
/*
Published by Mizegerd.agency
*/


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function generateCaptcha() {
    $num1 = rand(1, 10);
    $num2 = rand(1, 10);
    $operators = ['+', '-', '*'];
    $operator = $operators[array_rand($operators)];

    switch ($operator) {
        case '+':
            $captchaAnswer = $num1 + $num2;
            break;
        case '-':
            $captchaAnswer = $num1 - $num2;
            break;
        case '*':
            $captchaAnswer = $num1 * $num2;
            break;
    }

    $_SESSION['captchaAnswer'] = $captchaAnswer;
    return "$num1 $operator $num2";
}

function verifyCaptcha($userInput) {
    return intval($userInput) === $_SESSION['captchaAnswer'];
}
?>
