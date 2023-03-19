<?php

session_start();

require_once('../classes/UserLogic.php');

var_dump($_SESSION);

// login-form_blade.phpからではなく、ユーザがログインした状態でこのページにアクセスした場合
// マイページにリダイレクトさせる。
$result = UserLogic::checkAuthenticated();

if ($result)
{
    header('Location: mypage_blade.php');
    return;
}
// --------------------------


$err = [];

$email = filter_input(INPUT_POST, 'email');

// if email is empty
if (!$email = filter_input(INPUT_POST, 'email'))
{
    // $errはsession variableにいれるために、連想配列の形式にする。
    // セッションは連想配列で入るため
    $err['email'] = 'Please enter your email';
}

$password = filter_input(INPUT_POST, 'password');

if (!$password = filter_input(INPUT_POST, 'password'))
{
    // $errはsession variableにいれるために、連想配列の形式にする。
    // セッションは連想配列で入るため
    $err['password'] = 'Please enter your password';
}

if (count($err) > 0)
{
    // if a error is exist, return the to login.php
    $_SESSION = $err;
    header('Location: login-form_blade.php');

    return;
}

// ログイン成功時の処理
$result = UserLogic::login($email, $password);

// ログイン失敗時の処理
if (!$result) {
  header('Location: login-form_blade.php');
} else {
    header('Location: mypage_blade.php');
}
?>
