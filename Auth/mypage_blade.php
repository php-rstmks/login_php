<?php

session_start();
require_once('../classes/UserLogic.php');
require_once('../functions.php');

var_dump($_SESSION);

// ログインしているか判定する、していなかったら新規登録画面へ返す。
$result = UserLogic::checkAuthenticated();

if (!$result) {
    $_SESSION['msg_from_mypage'] = 'Please register a user or sign in';
    header('Location: signup-form_blade.php');
    return;
}

// @var array
$login_user = $_SESSION['login_user'];

?>
  <!DOCTYPE html>
<html lang=" ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>mypage</title>
</head>
<body>
    <h2>My Page</h2>
    <p>your username: <?= h($login_user['name']);?> </p>
    <p>complete user register!</p>

    <!-- フォームを使って送信するのは、ゲストがログアウト処理を行えないようにするため -->
    <form action="logout.php" style="display: inline;" method="POST">
        <input type="submit" value="logout is here" name="logout">
    </form>

    <!-- フォームを使って送信するのは、ゲストが特定のユーザの退会処理をするのを防ぐため。 -->
    <form action="resign.php" style="display: inline;" method="POST">
        <input class="resign-button" type="submit" value="resign is here" name="resign">
    </form>

    <a href="">別のユーザを作成する（未実装）(作成に成功した場合、session keyのlogin_userを別のやつに変えなければいけない</a>

<script src="../js/main.js"></script>
</body>
</html>