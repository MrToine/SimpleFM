<?php
/**
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Anthony VIOLET
 * @version     SimpleFM 1.0 - 20/04/2020
 * @since       SimpleFM 1.1 - 23/04/2020
 * @contributor
*/

function debug($var) {
    if(ConfigApp::$debug){
        $backtrace = debug_backtrace();
        echo '<p><a href="#" onclick="$(this).parent().next(\'ol\').slideToggle(); return false;"><strong>'.$backtrace[0]['file'].' line '.$backtrace[0]['line'].'</strong></a></p>';
        echo '<ol>';
        foreach ($backtrace as $key => $value) {
            if($key > 0) {
                echo '<li>'.$value['file'].'</strong> line '.$value['line'].'</li>';
            }
        }
        echo '</ol>';
        echo "<pre>";
        print_r($var);
        echo "</pre>";
    }
}

function errors_form($errors){
    $Sessions = new Sessions();
    $html= "";
    $html .= "Attention, des erreurs se sont glissées. Une innatention peut-être ?";
    $html .= "<ol>";
    foreach ($errors as $key => $value) {
        $html .= "<li>".$value."</li>";
    }
    $html .= "</ol>";
    $Sessions->set_flash($html, "warning");
}

function on_date($date, $full=false){
    $date = new DateTime($date);
    if($full){
        return $date->format('d/m/Y - H\hi');
    }else{
        return $date->format('d/m/Y');
    }
}

function popup($link){
    echo 'window.open(\''.$link.'\', \'Upload\', \'menubar=no, status=no, scrollbars=no, menubar=no, width=500, height=500\')';
}
