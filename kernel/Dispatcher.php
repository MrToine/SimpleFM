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
        if(!in_array($this->request->action, get_class_methods($controller))) {
            $this->error('method "'.$this->request->action.'" not found in "'.$this->request->controller.'" Controller');
        }
        call_user_func_array(array($controller, $this->request->action), $this->request->params);
        $controller->render($this->request->action);
    }

    function loadController() {
        if(empty($this->request->controller)){
            if(empty(ConfigApp::$index_page)){
                ConfigApp::$index_page = "index";
            }
            $this->request->controller = ConfigApp::$index_page;
        }
        $name = ucfirst($this->request->controller).'Controller';
        $file = ROOT.DS.'controllers'.DS.$name.'.php';
        require $file;
        return new $name($this->request);
    }

    function error($content) {
        header("HTTP/1.0 404 NOT FOUND");
        $controller = new Controller($this->request);
        $controller->set(array(
            "error_message" => $content
        ));
        $controller->render("/errors/404");
        die();
    }
}
