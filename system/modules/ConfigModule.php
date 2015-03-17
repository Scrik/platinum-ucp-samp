<?php

class Config {

    private static $_config = NULL;

    private static function _load() {
        if (empty(self::$_config)) {
            $file = 'assets/config/main.ini';
            if (file_exists($file)) {
                self::$_config = parse_ini_file($file, true);
            } else {
                exit("Не могу загрузить файл <b>$file</b>.");
            }
        }
    }

    public static function get($name1, $name2 = NULL) {
        self::_load();

        if (empty($name2)) {
            return self::$_config[$name1];
        } else {
            return self::$_config[$name1][$name2];
        }
    }

    public static function toIni($file, $array) {
        foreach ($array AS $key => $value) {
            if (is_array($value)) {
                $string .= "[$key]\n";

                foreach ($value AS $name => $res) {
                    $string .= "$name = $res\n";
                }
            } else {
                $string .= "$key = $value";
            }
        }

        file_put_contents($file, $string);
        return TRUE;
    }

}
