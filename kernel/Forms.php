<?php
/*#################################################################################################################
#                                                                                                                 #
# Author : VIOLET Anthony                                                                                         #
# Created : `Date.today.strftime('%D')`                                                                           #
# Updated : `Date.today.strftime('%D')`                                                                           #
# Licence : General Public License (GPL)                                                                          #
#                                                                                                                 #
#################################################################################################################*/
class Forms {

    public $controller;

    public function __construct($controller) {
        $this->controller = $controller;
    }

    public function input($name, $label, $options=array()){
        if(!isset($this->controller->request->data->$name)) {
            $value = "";
        }else{
            $value = $this->controller->request->data->$name;
        }
        if($label == "hidden") {
            return '<input type="hidden" name="'.$name.'" value="'.$value.'">';
        }
        $html = '<label for="input'.$name.'">'.$label.'</label> ';
        $attr = ' ';
        foreach ($options as $key => $v) {
            if($key != 'type'){
                $attr .= "$key=\"$v\" ";
            }
        }
        if(!isset($options['type'])){
            $html .= ' <input type="text" id="input'.$name.'" name="'.$name.'" value="'.$value.'" placeholder="'.$label.'" '.$attr.'>';
        }elseif($options['type'] == 'texarea') {
            $html .= ' <textarea id="input'.$name.'" name="'.$name.'" '.$attr.'>'.$value.'</textarea>';
        }elseif($options['type'] == 'checkbox') {
            $html .= ' <input type="hidden" class="checkbox" name="'.$name.'" value="0"><input type="checkbox" name="'.$name.'" value="1"'.(empty($value)?'':'checked').'>';
        }elseif($options['type'] == 'file') {
            $html .= ' <input type="file" id="input'.$name.'" name="'.$name.'" value="'.$value.'" placeholder="'.$label.'" '.$attr.'>';
        }elseif($options['type'] == 'password') {
            $html .= ' <input type="password" id="input'.$name.'" name="'.$name.'" value="'.$value.'" placeholder="'.$label.'" '.$attr.'>';
        }

        return $html;
    }
}
