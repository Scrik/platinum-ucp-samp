<?php

class Application {

    private $_autoload = array('object', 'route', 'config', 'ajax'); //Модули, подгружаемые методом _autoload
    
    public function __construct() {
        $this->_autoload();
        $route = new Route();
        $this->_install($route->uri);
    }

    private function _autoload() {
        $array = $this->_autoload;
        $count = count($array);
        for ($i = 0; $i < $count; $i++) {
            $file = 'system/modules/' . ucfirst($array[$i]) . 'Module.php';
            if (file_exists($file)) {
                require $file;
            }
        }
    }

    private function _install($array) {
        $ajax = new Ajax();
        $ajax->init($array);
    }
    
    public function __destruct() {
        if (class_exists('DB')) {
            DB::close();
        }
    }

}
