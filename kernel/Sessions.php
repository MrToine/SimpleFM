<?php
/*#################################################################################################################
#                                                                                                                 #
# Author : VIOLET Anthony                                                                                         #
# Created : `Date.today.strftime('%D')`                                                                           #
# Updated : `Date.today.strftime('%D')`                                                                           #
# Licence : General Public License (GPL)                                                                          #
#                                                                                                                 #
#################################################################################################################*/
class Sessions {

    function __construct() {
        if(!isset($_SESSION)){
            session_start();
        }
    }

    public function set_flash($message, $type = null) {
        if($type == null) {
            $type = "primary";
        }
        $_SESSION['flash'] = array(
            "message" => $message,
            "type" => $type
        );
    }

    public function flash() {
        if(isset($_SESSION['flash']['message'])) {
            $html = '<div class="alert--'.$_SESSION['flash']['type'].'"><p>'.$_SESSION['flash']['message'].'</p></div>';
            $_SESSION['flash'] = array();

            return $html;
        }
    }

    public function write($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function read($key = null){
        if($key){
            if(isset($_SESSION[$key])){
                return $_SESSION[$key];
            }else{
                return false;
            }
        }else{
            return $_SESSION;
        }
    }

    public function delete($key) {
        unset($_SESSION[$key]);
    }

    public function isLogged(){
        return isset($_SESSION['User']->id);
    }

    public function user($key){
        if($this->read('User')->$key) {
            return $this->read('User')->$key;
        }else{
            return false;
        }
        return false;
    }
}
