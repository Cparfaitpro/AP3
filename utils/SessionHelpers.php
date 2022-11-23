<?php


namespace utils;


class SessionHelpers
{
    static function init()
    {
        session_start();
    }

    static function login($equipe)
    {
        $_SESSION['LOGIN'] = $equipe;
    }

    static function loginAdmin($nom)
    {
        $_SESSION['ADMINLOGIN'] = $nom;
    }

    static function logout()
    {
        unset($_SESSION['LOGIN']);
    }

    static function logoutAdmin()
    {
        unset($_SESSION['ADMINLOGIN']);
    }

    static function getConnected()
    {
        if (SessionHelpers::isLogin()) {
            return $_SESSION['LOGIN'];
        } else {
            return array();
        }
    }

    static function isLogin()
    {
        return isset($_SESSION['LOGIN']);
    }

    static function isLoginAdmin()
    {
        return isset($_SESSION['ADMINLOGIN']);
    }
}