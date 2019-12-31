<?php
namespace App;

class Route {
    static $get = [];
    static $post = [];
    
    static function set($http_method, $url, $action, $permission = null){
        $split = explode("@", $action);
        $conName = $split[0];
        $method = $split[1];

        array_push(self::${strtolower($http_method)}, (object)["url" => $url, "conName" => $conName, "method" => $method, "permission" => $permission]);
    }

    static function takeURL(){
        $url = isset($_GET['url']) ? rtrim($_GET['url']) : "";
        $url = "/" . filter_var($url, FILTER_SANITIZE_URL);
        return $url;
    }

    static function redirect(){
        $current_url = self::takeURL();
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        foreach(self::${$method} as $page){
            if($current_url === $page->url){
                if($page->permission !== null){
                    $pass = call_user_func($page->permission . "Permission");
                    if(!$pass->result) {
                        go($pass->destination, $pass->message);
                        exit;
                    }
                }               
                self::execute($page);
                exit;
            }
        }
        echo "해당 페이지는 존재하지 않는 페이지 입니다.";
    }

    static function execute($page){
        $conName = "Controller\\" . $page->conName;
        $controller = new $conName;
        $controller->{$page->method}();
    }
}