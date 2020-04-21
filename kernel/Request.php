<?php
/*#################################################################################################################
#                                                                                                                 #
# Author : VIOLET Anthony                                                                                         #
# Created : `Date.today.strftime('%D')`                                                                           #
# Updated : `Date.today.strftime('%D')`                                                                           #
# Licence : General Public License (GPL)                                                                          #
#                                                                                                                 #
#################################################################################################################*/

class Request {

    public $url; // this url is call by user

    function __construct() {
        $this->url = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'/';
    }
}
