<?php
/*#################################################################################################################
#                                                                                                                 #
# Author : VIOLET Anthony                                                                                         #
# Created : `Date.today.strftime('%D')`                                                                           #
# Updated : `Date.today.strftime('%D')`                                                                           #
# Licence : General Public License (GPL)                                                                          #
#                                                                                                                 #
#################################################################################################################*/

class Dispatcher {

    var $request;

    function __construct() {
        $this->request = new Request();
        Router::parse($this->request->url, $this->request);
        $controller = $this->loadController();
        $action = $this->request->action;
        if($this->request->prefix) {
            $action = $this->request->prefix.'_'.$action;
        }
        if($this->request->controller != "assets"){
            if(!in_array($action, array_diff(get_class_methods($controller), get_class_methods("Controller")))) {
                $this->error('method "'.$action.'" not found in "'.$this->request->controller.'" Controller');
            }
            call_user_func_array(array($controller, $action), $this->request->params);
            $controller->render($action);
        }
    }

    function loadController() {
        if($this->request->controller != "assets"){
            if(empty($this->request->controller)){
                if(empty(ConfigApp::$index_page)){
                    ConfigApp::$index_page = "index";
                }
                $this->request->controller = ConfigApp::$index_page;
            }
            $name = ucfirst($this->request->controller).'Controller';
            if(!empty(ConfigApp::$dir_controllers)){
                ConfigApp::$dir_controllers = ConfigApp::$dir_controllers.DS;
            }
            $file = ROOT.DS.ConfigApp::$dir_controllers.'controllers'.DS.$name.'.php';
            if(!file_exists($file)){
                $this->error("Controller ".$this->request->controller." not found");
            }
            require $file;
            $controller = new $name($this->request);

            return $controller;
        }
    }

    function error($content) {
        header("HTTP/1.0 404 NOT FOUND");
        $controller = new Controller($this->request);
        $controller->Sessions = new Sessions();
        $controller->set(array(
            "error_message" => $content
        ));
        $controller->render("/errors/404");
        die();
    }
}
