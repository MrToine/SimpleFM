<?php
/**
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Anthony VIOLET
 * @version     SimpleFM 1.0 - 20/04/2020
 * @since       SimpleFM 1.1 - 23/04/2020
 * @contributor
*/

if($this->request->prefix == 'admin') {
    $this->layout = "admin";
    if(!$this->Sessions->isLogged() || $this->Sessions->user('role') != "admin"){
        $this->redirect('users/login');
    }
}
