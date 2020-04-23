<?php
/**
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Anthony VIOLET
 * @version     SimpleFM 1.0 - 20/04/2020
 * @since       SimpleFM 1.1 - 23/04/2020
 * @contributor
*/

class Request {

    public $url; // this url is call by user
    public $page = 1;
    public $prefix = false;
    public $data = false;
    public $view = "";

    function __construct() {
        $this->url = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'/';
        if(isset($_GET['page'])) {
            if(is_numeric($_GET['page'])) {
                if($_GET['page'] > 0){
                    $this->page = round($_GET['page']);
                }
            }
        }
        if(!empty($_POST)){
            $this->data = new stdClass();
            foreach($_POST as $key => $value) {
                $this->data->$key = $value;
            }
        }
    }
}
