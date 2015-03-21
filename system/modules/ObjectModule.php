<?php

class Object {
    private static $_data = array();

    public function __get($property) {
        if (empty(self::$_data[$property])) {
            $this->install($property);
        }

        return self::$_data[$property];
    }

    public function install($name = NULL) {
        $ucName = ucfirst($name);
        require_once "system/modules/{$ucName}Module.php";
        self::$_data[$name] = new $ucName;
    }

}