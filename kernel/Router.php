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

    static $routes = array();

    /**
    * Parse an url
    * @param $url URl to parse
    * @return an array with params
    **/
    static function parse($url, $request) {
        $url = trim($url, '/');

        foreach(self::$routes as $value) {
            if(preg_match($value['catcher'], $url, $match)) {
                $request->controller = $value['controller'];
                $request->action = $value['action'];
                $request->params = array();
                foreach ($value['params'] as $k => $v) {
                    $request->params[$k] = $match[$k];
                }
                return $request;
            }
        }

        $params = explode('/', $url);
        $request->controller = $params[0];
        $request->action = isset($params[1]) ? $params[1] : 'index';
        $request->params = array_slice($params, 2);
        return true;
    }

    static function connect($redir, $url) {
        $r = array();

        $r['params'] = array();
        $r['redirection'] = $redir;
        $r['original'] = preg_replace('/([a-z0-9]+):([^\/+])/', '${1}:(?P<${1}>${2})', $url);
        $r['original'] = '/'.str_replace('/', '\/', $r['original']).'/';

        $params = explode('/', $url);
        foreach ($params as $key => $value) {
            if(strpos($value, ':')) {
                $p = explode(':', $value);
                $r['params'][$p[0]] = $p[1];
            }else{
                if($key==0){
                    $r['controller'] = $value;
                }elseif($key==1){
                    $r['action'] = $value;
                }
            }
        }

        $r['catcher'] = $redir;
        foreach ($r['params'] as $key => $value) {
            $r['catcher'] = str_replace(":$key", "(?P<$key>$value)", $r['catcher']);
        }
        $r['catcher'] = '/'.str_replace('/', '\/', $r['catcher']).'/';

        self::$routes[] = $r;
    }

    static function url($url) {
        foreach (self::$routes as $value) {
            if(preg_match($value['original'], $url, $match)){
                foreach ($match as $k => $v) {
                    if(!is_numeric($k)){
                        $value['redirection'] = str_replace(":$k", $v, $value['redirection']);
                    }
                }
                return $value['redirection'];
            }
        }
        return $url;
    }
}
