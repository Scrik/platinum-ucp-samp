<?php

class Route {
    public $uri = array();
    private static $_staticUri = array();
    
    public function __construct() {

        $uri = explode('/', $_GET['uri']);
        $count = count($uri);

        for ($i = 0; $i < $count; $i++) {
            if (!empty($uri[$i]) OR $uri[$i] == 0) {
                $array[] = $uri[$i];
            }
        }

        $this->uri = $array;
        self::$_staticUri = $array;
    }
    
    public function getArray() {
        return self::$_staticUri;
    }
}