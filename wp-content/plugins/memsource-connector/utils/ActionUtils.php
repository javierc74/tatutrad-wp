<?php

namespace Memsource\Utils;


class ActionUtils {

    public static function isAction($action, $type = 'get') {
        if ($type == 'get') {
            return (isset($_GET['action']) && $_GET['action'] == $action) || (isset($_GET['action2']) && $_GET['action2'] == $action);
        } elseif ($type == 'post') {
            return (isset($_POST['action']) && $_POST['action'] == $action) || (isset($_POST['action2']) && $_POST['action2'] == $action);
        }
        return false;
    }

    public static function getParameter($key, $use_cookie = true, $default_value = null) {
        if (isset($_REQUEST[$key])) {
            return $_REQUEST[$key];
        }
        if ($use_cookie && isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        }
        return $default_value;
    }

}