<?php
/*#################################################################################################################
#                                                                                                                 #
# Author : VIOLET Anthony                                                                                         #
# Created : `Date.today.strftime('%D')`                                                                           #
# Updated : `Date.today.strftime('%D')`                                                                           #
# Licence : General Public License (GPL)                                                                          #
#                                                                                                                 #
#################################################################################################################*/
class Controller {

    public $request;
    public $vars = array();
    public $layout = 'default';
    private $rendered = false;

    function __construct($request) {
        $this->request = $request;
    }

    public function render($view) {
        if($this->rendered){
            return false;
        }
        extract($this->vars);
        if(strpos($view, '/')===0){
            $view = ROOT.DS.'views'.$view.'.php';
        }else{
            $view = ROOT.DS.'views'.DS.$this->request->controller.DS.$view.'.php';
        }
        ob_start();
        require($view);
        $output = ob_get_clean();
        require ROOT.DS.'views'.DS.'layout'.DS.$this->layout.'.php';
        $this->rendered = true;
    }

    public function set($key, $value = null) {
        if(is_array($key)) {
            $this->vars += $key;
        }else{
            $this->vars[$key] = $value;
        }
    }

    public function loadModel($model) {
        $file = ROOT.DS.'models'.DS.$model.'.php';
        require_once($file);
        if(!isset($this->$model)){
            $this->$model = new $model();
        }
    }
}
