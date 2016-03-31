<?php
define('FILE_NAME', '.htpasswd');

function getHash($pass)
{
    return password_hash($pass, PASSWORD_BCRYPT);
}

function checkHash($pass, $hash)
{
    return password_verify($pass, $hash);
}

function saveUser($login, $hash)
{
    $str = "$login:$hash\n";
    if (file_put_contents(FILE_NAME, $str, FILE_APPEND))
        return true;
    else
        return false;
}

function userExists($login)
{
    if (!is_file(FILE_NAME))
        return false;
    $users = file(FILE_NAME,FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        if (strpos($user, $login . ':') !== false) {
            return $user;
        }
    }
    return false;
}

function logOut()
{
    session_destroy();
    header('Location: secure/login.php');
    exit;
}

