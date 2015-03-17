<?php

class Module {
    public function load($name) {
        $module = ucfirst($name);
        $file = "system/modules/{$module}Module.php";
        if (empty($this->$module)) {
            if (file_exists($file)) {
                require_once $file;
                $this->$module = new $module;
                return TRUE;
            } else {
                exit("Не могу загрузить модуль <b>$module</b>, <b>$file</b>.");
            }
        }
    }
}

