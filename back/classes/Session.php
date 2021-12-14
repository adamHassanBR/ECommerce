<?php

class Session
{
    function __construct()
    {
        session_start();
    }

    function set($key, $data)
    {
        $_SESSION[$key] = $data;
    }

    function get($key)
    {
        if (isset($_SESSION[$key]))
        {
            return $_SESSION[$key];
        }
        return false;
    }

    function destroy()
    {
        unset($_SESSION);
        session_destroy();
    }
}

?>