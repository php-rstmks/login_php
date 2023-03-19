<?php

require_once('../dbconnect.php');

class UserLogic
{
    /**
     * register user and そのユーザにログイン状態にする
     * @param array $userData
     * @return bool $result
     */
    public static function createUser(array $userData): bool
    {
        $result = false;
        $sql = 'INSERT INTO users (name, email ,password) VALUES (?, ?, ?)';

        // put userData into array

        $arr = [];

        $arr[] = $userData['name'];

        $arr[] = $userData['email'];

        $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT);

        try {
            $stmt = connect()->prepare($sql);
            $result = $stmt->execute($arr);
        } catch(\Exception $e) {
            return $result;
        }

        session_regenerate_id(true);

        $stmt = connect()->prepare("SELECT id FROM users WHERE name = :name");

        $stmt->bindValue('name', $userData['name'], \PDO::PARAM_INT);

        $stmt->execute();

        $id = $stmt->fetch(PDO::FETCH_COLUMN);

        $_SESSION['login_user'] = ['id' => $id, 'name' => $userData['name']];

        return $result;

    }

    /**
     * login process
     * if email and password is correct, return true
     * @ param string $email
     * @ param string $password
     * @ return bool $result
     */
    public static function login(string $email, string $password): bool
    {
        // result
        $result = false;

        // @var array{array{}}
        $user = self::getUserByEmail($email);

        if (! $user)
        {
            // $errはsession variableにいれるために、連想配列の形式にする。
            // セッションは連想配列で入るため
            $_SESSION['email_match_err'] = 'email does not match';
            return $result;
        }

        // ログインフォームから入力したパスワードと入力したemail経由で取得したパスワードが一致するか
        if (password_verify($password, $user['password']))
        {
            // the countermeasure for session hijacking
            session_regenerate_id(true);

            $_SESSION['login_user'] = $user;

            $result = true;
            return $result;
        }

        // $errはsession variableにいれるために、連想配列の形式にする。
        // セッションは連想配列で入るため
        // 上のif文の内部にはいれずここまで来た場合、$resultは必ずfalseを返す。
        $_SESSION['password_match_err'] = 'password does not match';
        return $result;
    }

    /**
     * get user from email
     * @param string $email
     * @return array|bool $user|false
     */
    public static function getUserByEmail(string $email): array|bool
    {
        // SQL preparation

        $sql = 'SELECT * FROM users WHERE email = ?';

        $arr = [];

        $arr[] = $email;

        // SQL execution

        try {
            $stmt = connect()->prepare($sql);
            $stmt->execute($arr);

            // SQLの結果を返す
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

        } catch(\Exception $e) {
            return $result;
        }
    }

    /**
     * check if user is authenticated
     * if session has login_user key or login_user id key, return true
     * @param void
     * @return bool $result
     */
    public static function checkAuthenticated(): bool
    {
        $result = false;

        //  $_SESSION['login_user']['id'] > 0はどういう意味？
        if (isset($_SESSION['login_user']) && $_SESSION['login_user']['id'] > 0)
        {
            return $result = true;
        }

        return $result;
    }

    /**
     * logout process
     * @param void
     * @return void
     */
    public static function logout(): void
    {
        $_SESSION = array();
        // session_destroy();
    }

    /**
     * delete user
     * @param int $id
     * @return void
     */
    public static function deleteUser(int $id): void
    {

        $sql = 'DELETE FROM users WHERE id = (:id)';

        $stmt = connect()->prepare($sql);
        $stmt->bindValue('id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>