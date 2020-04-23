<?php
/**
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Anthony VIOLET
 * @version     SimpleFM 1.0 - 20/04/2020
 * @since       SimpleFM 1.1 - 23/04/2020
 * @contributor
*/

class Router {

    static $routes = array();
    static $prefixes = array();

    static function prefix($url, $prefix) {
        self::$prefixes[$url] = $prefix;
    }

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

        //admin
        if(in_array($params[0], array_keys(self::$prefixes))) {
            $request->prefix = self::$prefixes[$params[0]];
            array_shift($params);
        }

        $request->controller = $params[0];
        $request->action = isset($params[1]) ? $params[1] : 'index';
        foreach (self::$prefixes as $key => $value) {
            if(strpos($request->action, $value.'_') === 0){
                $request->prefix = $value;
                $request->action = str_replace($value, '_', '', $request->action);
            }
        }
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

    static function base_url($url) {
        $url = trim($url, '/');
        return BASE_URL.'/'.$url;
    }

    static function base_url_absolute($url){
        $url = trim($url, '/');
        return WEBROOT_URL.'/'.$url;
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
        foreach(self::$prefixes as $key => $value) {
            if(strpos($url, $value) === 0) {
                $url = str_replace($value, $key, $url);
            }
        }
        return BASE_URL.'/'.$url;
    }
}
