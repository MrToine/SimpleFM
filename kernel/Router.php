<?php
/*#################################################################################################################
#                                                                                                                 #
# Author : VIOLET Anthony                                                                                         #
# Created : `Date.today.strftime('%D')`                                                                           #
# Updated : `Date.today.strftime('%D')`                                                                           #
# Licence : General Public License (GPL)                                                                          #
#                                                                                                                 #
#################################################################################################################*/

class Router {

    /**
    * Parse an url
    * @param $url URl to parse
    * @return an array with params
    **/
    static function parse($url, $request) {
        $url = trim($url, '/');
        $params = explode('/', $url);
        $request->controller = $params[0];
        $request->action = isset($params[1]) ? $params[1] : 'index';
        $request->params = array_slice($params, 2);
        return true;
    }
}
