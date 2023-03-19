<?php

session_start();

require_once '../functions.php';

//@var array
$session_msgs = $_SESSION;

if (isset($_SESSION['msg_from_mypage']))
{
    
}

// セッションのキーにemail,username,msg1,msg2のどれかが入っていたら
// $validation_errsに値を入れる
if (session_msg_check1($session_msgs))
{
    //@var array
    $validation_errs = $session_msgs;
    $_SESSION = array();

}

if (array_key_exists('login_err', $session_msgs))
{
    $msg_from_mypage = $session_msgs[''];
}

$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;

?>

<!DOCTYPE html>
<html lang=" ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>signup page</title>
</head>
<body>
    <h2>signup form</h2>

    <?php if (isset($validation_errs)) : ?>
        <?php foreach($validation_errs as $err) : ?>
            <p style="color: red;"><?= $err ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (isset($login_err)) : ?>
        <p><?= $login_err ?></p>
    <?php endif; ?>

    <?php if (isset($logout_msg)) : ?>
        <p><?= $message_from_mypage ?></p>
    <?php endif; ?>

    <form action="./register.php" method='POST'>
        <p>
            <label for="">user name</label>
            <input type="text" name="name">
        </p>
        <p>
            <label for="">mail address</label>
            <input type="email" name="email">
        </p>
        <p>
            <label for="">password</label>
            <input type="password" name="password">
        </p>
        <p>
            <label for="">password confirmation</label>
            <input type="password" name="password_conf">
        </p>
        <p>
            <input type="hidden" name="csrf_token" value="<?= h(setToken()); ?>">
        </p>
        <p>
            <input type="submit" value="sign up">
        </p>
    </form>
    <p><?php var_dump($session_msgs) ?></p>

    <a href="./login-form_blade.php">You can sign in here</a>
</body>
</html>