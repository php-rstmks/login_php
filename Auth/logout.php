<?php

session_start();
require_once('../classes/UserLogic.php');
require_once('../functions.php');

$msg = [];

// logout.phpにアドレスバーから入ろうと試みたとき
// sign-in_formにリダイレクトさせる
if (!$logout = filter_input(INPUT_POST, 'logout'))
{
    exit('不正なリクエストです。');
    // instead of using exit function redirect a user to sign-in form with session msg.
    // $_SESSION['unexpected_request'] = 'You can\'t that page.';
    // header('Location signup-form_blade.php');
}

// ログインしているか判定する、セッションが切れていたらログインしてくださいとメッセージを出す。
$result = UserLogic::checkAuthenticated();

if (!$result) {
    // $_SESSION['logout_msg'] = '一定期間経過したので再ログインが必要です。';
    $msg['logout_msg'] = '一定期間経過したので再ログインが必要です。';
    header('Location: login-form_blade.php');
    return;
}

UserLogic::logout();

$msg['logout_msg'] = 'ログアウトが完了しました';
// $_SESSION['logout_msg'] = 'ログアウトが完了しました';
$_SESSION = $msg;
header('Location: login-form_blade.php');

// なぜかログアウトからのメッセージ($msg['logout_msg']が送れない
// I don't know why but, I can't send the session msg to login-form_blade.php.
// 原因はsession_destroyしてたから