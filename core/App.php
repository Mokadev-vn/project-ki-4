<?php
namespace Core;

class App{

    public static function request($name){
        return isset($_REQUEST[$name]) ? $_REQUEST[$name] : false;
    }

    public static function redirect($path, $httpCode=301)
	{
		if (!headers_sent()) {
			header("Location: ".APP_CONFIG["url"].$path, TRUE, $httpCode);
			exit(0);
		}

		exit('<meta http-equiv="refresh" content="0; url='.$path.'"/>');
	}

    public static function setSession($name, $param){ 
        $_SESSION[$name] = $param;
    }

    public static function getSession($name){
        return isset($_SESSION[$name]) ? $_SESSION[$name] : false;
    }

    public static function getSessionAll(){
        return $_SESSION;
    }

    public static function destroy($name = ''){
        if($name == ''){
            return session_destroy();
        }
        unset($_SESSION[$name]);
        return true;
    }


}
