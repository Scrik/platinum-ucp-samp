<?php

class DB {

    private static $mysqli = NULL;

    private function getDB() {
        if (!is_object(self::$mysqli)) {

            $config = Config::get('database');
            self::$mysqli = new mysqli($config['host'], $config['user'], $config['pass'], $config['name']);

            if (self::$mysqli->connect_error) {
                exit('Ошибка подключения: ' . self::$mysqli->connect_error);
            }
        }

        return self::$mysqli;
    }

    public function select($query, $array = TRUE) {
        $mysqli = $this->getDB();

        if ($result = $mysqli->query($query)) {
            if ($result->num_rows == 1) {
                if ($array == TRUE) {
                    return array($result->fetch_assoc());
                } else {
                    return $result->fetch_assoc();
                }
            } else {
                while ($row = $result->fetch_assoc()) {
                    $resultArray[] = $row;
                }
                return $resultArray;
            }
            $result->free();
        } else {
            die('Ошибка запроса: ' . $mysqli->error);
        }
    }

    public function filter($array, $html = FALSE) {
        $mysqli = $this->getDB();

        if (is_array($array)) {
            foreach ($array AS $key => $value) {
                if (is_array($value)) {
                    $array[$key] = $this->filter($value);
                } else {
                    if ($html == TRUE) {
                        $array[$key] = htmlspecialchars($value);
                    }
                    $array[$key] = $mysqli->real_escape_string($value);
                }
            }
            return $array;
        } else {
            if ($html == TRUE) {
                $array = htmlspecialchars($array);
            }
            $array = $mysqli->real_escape_string($array);
            return $array;
        }
    }

    public function query($query) {
        $mysqli = $this->getDB();

        if ($result = $mysqli->query($query)) {
            return TRUE;
            $result->free();
        } else {
            die('Ошибка запроса: ' . $mysqli->error);
        }
    }

    public function numRows($query) {
        $mysqli = $this->getDB();

        if ($result = $mysqli->query($query)) {
            return $result->num_rows;

            $result->free();
        } else {
            die('Ошибка запроса: ' . $mysqli->error);
        }
    }

    public static function close() {
        if (is_object(self::$mysqli)) {
            self::$mysqli->close();
        }
    }

}
