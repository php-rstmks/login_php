<?php

/**
 *  XSS countermeasure
 *  @param string $str
 *  @return 
 */

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 *  CSRF countermeasure　ワンタイムトークン　
 *  @param void
 *  @return $str $csrf_token
 */
function setToken()
{
    // トークン生成

    // session_start();
    $csrf_token = bin2hex(random_bytes(32));

    $_SESSION['csrf_token'] = $csrf_token;

    return $csrf_token;

}

/**
 * check if key(email, name, msg1 or msg2) exist and if so return true
 * @param associative array $session
 * @return bool
 */
function session_msg_check1(array $session): bool
{
    $result = false;

    if (array_key_exists('msg1', $session))
    {
        $result = true;
        
    } elseif (array_key_exists('msg2', $session)) {
        $result = true;

    } elseif (array_key_exists('name', $session)) {

        $result = true;
    } elseif (array_key_exists('email', $session))
    {
        $result = true;
    }

    return $result;

}

function session_msg_check2()
{

}

/**
 * check if authenticated error message exist
 * @param $_SESSION
 * @return bool
 */
function authenticated_err_msg_check($session)
{
    

}


