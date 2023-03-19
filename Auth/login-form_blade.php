<?php

session_start();

// var_dump($_SESSION);

require_once('../classes/UserLogic.php');

//------------------------------
// ユーザがログイン状態（$resultがtrue)ならリダイレクト
$result = UserLogic::checkAuthenticated();

if ($result)
{
    header('Location: mypage_blade.php');
    return;
}
//-------------------------------

$err = $_SESSION;
var_dump($err);

// エラー表示をリロードしたときに再表示させないようにするためにセッションを削除する
// このふたつセットでsessionを初期化する
$_SESSION = array();
session_destroy();
?>

<!DOCTYPE html>
<html lang=" ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login page</title>
    <style>
        .red {
            color: red;
        }
    </style>
</head>
<body>
    <h2>login form</h2>


    <?php if (isset($err['logout_msg'])) : ?>
        <p><?= $err['logout_msg']; ?></p>
    <?php endif; ?>

    <form action="./login.php" method='POST'>
        <p>
            <label for="">mail address</label>
            <input type="email" name="email">
            <!-- login.phpで作成した$err['email']を表示 -->
            <?php if (isset($err['email'])): ?>
                <p><?= $err['email']; ?></p>
            <?php endif; ?>

            <?php if (isset($err['email_match_err'])): ?>
                <p><?= $err['email_match_err']; ?></p>
            <?php endif; ?>

        </p>
        <p>
            <label for="password">password</label>
            <input type="password" name="password">
            <!-- login.phpで作成した$err['password']を表示 -->
            <?php if (isset($err['password'])): ?>
                <p class="red"><?= $err['password']; ?></p>
            <?php endif; ?>
            <?php if (isset($err['password_match_err'])): ?>
                <p class="red"><?= $err['password_match_err']; ?></p>
            <?php endif; ?>
        </p>
        <p>
            <input type="submit" value="sign in">
        </p>
    </form>
    <a href="./signup-form_blade.php">create account is here</a>
</body>
</html>