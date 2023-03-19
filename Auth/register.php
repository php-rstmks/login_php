<?php

session_start();

require_once('../classes/UserLogic.php');

$token = filter_input(INPUT_POST, 'csrf_token');

var_dump($_SESSION);

// if token is not exist or don't match
if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token'])
{
    exit('不正なリクエスト'); 
}

// あくまでワンタイムセッションなので役目を終えたら消す
// since $_SESSION['csrf_token'] is just one-time session, delete it after it complete task.
// また二回目に送信されてきたときはセッションが削除されているので上のvalidationで不正なリクエストとして弾かれる。
// 二重送信対策
unset($_SESSION['csrf_token']);

// error message
$err = [];

// validation 
if (!$username = filter_input(INPUT_POST, 'name')) {
    $err['name'] = 'Please fill out name';
}

//ここに重複したユーザネームでないかのチェックをいれるUserLogicにかく

if (!$email = filter_input(INPUT_POST, 'email'))
{
    $err['email'] = 'Please fill out email';
}

$password = filter_input(INPUT_POST, 'password');

if (!preg_match("/\A[a-z\d]{8,100}+\z/i", $password))
{
  $err['msg1'] = 'password should be at least 8character and at more 100 character';
}

// 確認用パスワード
$password_conf = filter_input(INPUT_POST, 'password_conf');

if ($password !== $password_conf)
{
    $err['msg2'] = 'This is different from password confirmation';
}

if (count($err) === 0)
{
    // @var bool
    $hasCreated = UserLogic::createUser($_POST);

    if(!$hasCreated)
    {
        $err[] = 'register failed';
    }

    header('Location: mypage_blade.php');
    return;

}   elseif (count($err) > 0)
{
    $_SESSION = $err;
    header('Location: signup-form_blade.php');
    return;
    // not to run codes below header function, write return statement. 
}   

?>
  <!DOCTYPE html>
<html lang=" ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>completed page</title>
</head>
<body>
    <?php if (count($err) > 0): ?>
        <?php foreach($err as $e): ?>
          <p><?= $e ?></p>
        <?php endforeach; ?>
    <?php else: ?>
    <!-- <p>complete user register!</p> -->
    <!-- マイページにいかせるためには認証を行う必要がある。 -->
    <!-- <p>マイページへ</p> -->
    <!-- <a href="./signup-form_blade.php">Back</a> -->
    <?php endif; ?>
</body>
</html>