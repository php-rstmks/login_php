<?php

session_start();
require_once('../classes/UserLogic.php');
require_once('../functions.php');

if (!$deleteUser = filter_input(INPUT_POST, 'resign'))
{
    exit('不正なリクエストです。');
    // instead of using exit function redirect a user to sign-in form with session msg.
    // $_SESSION['unexpected_request'] = 'You can\'t that page.';
    // header('Location signup-form_blade.php');
}

// @var bool
$result = UserLogic::checkAuthenticated();

if (!$result) {
    $_SESSION['login_error'] = '一定期間経過したので再ログインが必要です。';
    header('Location: login-form_blade.php');
    return;
}

$userid = $_SESSION['login_user']['id'];

try{
    UserLogic::deleteUser($userid);
} catch(Exception $e) {
    exit('処理に失敗しました。もう一度はじめからやり直してください。');
}

UserLogic::logout();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>退会が完了しました。</div>
    <a href="signup-form_blade.php">登録フォームへ</a>
</body>
</html>