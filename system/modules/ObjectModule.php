<?php

class Object {

    private $_list = array('Controller', 'Model', 'View', 'Module', 'DB', 'Table', 'Privileges');
    private static $_data = array();

    public function __get($property) {
        if (empty(self::$_data[$property])) {
            $this->install($property);
        }

        return self::$_data[$property];
    }

    public function install($name = NULL) {
        if (empty($name)) {
            $count = count($this->_list);
            $array = $this->_list;
        } else {
            $count = 1;
            $array[0] = $name;
        }

        for ($i = 0; $i < $count; $i++) {
			$array[$i] = ucfirst($array[$i]);
            require_once "system/modules/{$array[$i]}Module.php";
            $name = strtolower($array[$i]);

            self::$_data[$name] = new $array[$i];
        }
    }

}
