<?php

class Model {

    private static $_data = array();

    public function __get($name) {
        if (empty(self::$_data[$name])) {
            $this->_load($name);
        }
        
        return self::$_data[$name];
    }

    private function _load($model) {
        $array = explode('/', $model);
        $count = count($array);
        if ($count > 0) {
            $model = $array[$count - 1];
            array_pop($array);
            $path = implode('/', $array) . '/';
        }

        $name = ucfirst($model) . 'Model';
        $file = "assets/model/$path$name.php";

        if (file_exists($file)) {
            require_once $file;
            self::$_data[$model] = new $name;
        } else {
            exit("Не могу загрузить модель: <b>$file</b>.");
        }
    }

}
