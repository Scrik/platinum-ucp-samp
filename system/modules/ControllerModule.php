<?php

class Controller {

    public function load($controller, $path = NULL, $args = NULL) {
        $controller = ucfirst($controller) . 'Controller';
        if ($path) {
            $file = "$path$controller.php";
        } else {
            $file = "assets/controller/$controller.php";
        }
        if (file_exists($file)) {
            require_once $file;
            return new $controller(($args) ? $args : '');
        } else {
            exit("Не могу загрузить контроллер: <b>$file</b>.");
        }
    }

}
