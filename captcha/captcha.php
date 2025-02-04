<?php

/*
Published by Mizegerd.agency
*/

session_start();

function generateCaptcha() {
    $num1 = rand(1, 20);
    $num2 = rand(1, 20);
    $operator = rand(1, 3);

    switch ($operator) {
        case 1:
            $captchaQuestion = "$num1 + $num2";
            $_SESSION['captchaAnswer'] = $num1 + $num2;
            break;
        case 2:
            $captchaQuestion = "$num1 - $num2";
            $_SESSION['captchaAnswer'] = $num1 - $num2;
            break;
        case 3:
            $captchaQuestion = "$num1 * $num2";
            $_SESSION['captchaAnswer'] = $num1 * $num2;
            break;
    }
    return $captchaQuestion;
}

function verifyCaptcha($userAnswer) {
    return $userAnswer == $_SESSION['captchaAnswer'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userAnswer = intval(trim($_POST['captcha_answer']));
    if (verifyCaptcha($userAnswer)) {
        echo "CAPTCHA verification successful!";
    } else {
        echo "CAPTCHA verification failed. Please try again.";
    }
}

$captchaQuestion = generateCaptcha();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math CAPTCHA</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Solve the CAPTCHA</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="captcha.php">
                        <div class="form-group">
                            <label for="captcha_question">What is <?php echo $captchaQuestion; ?>?</label>
                            <input type="text" id="captcha_answer" name="captcha_answer" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
