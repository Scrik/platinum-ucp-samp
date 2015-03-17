<?php

class View {

    private $_vars = array();
    private $_template = NULL;
    private $_status = NULL;

    public function __construct() {
        $this->_template = Config::get('template', 'name');
        $this->_status = Config::get('general', 'ajax');
    }

    public function get($name) {
        return $this->_vars[$name];
    }

    public function addArray($array) {
        foreach ($array AS $key => $value) {
            if (is_array($value)) {
                foreach ($value AS $name => $res) {
                    $this->_vars['{' . $key . '_' . $name . '}'] = $res;
                }
            } else {
                $this->_vars['{' . $key . '}'] = $value;
            }
        }
    }

    public function message($message, $return = FALSE) {
        $msg = $this->fromArray($message, $this->sub_load('message'));
        
        if ($return) {
            return $msg;
        } else {
            echo $msg;
        }
    }

    public function refresh($page, $full = FALSE) {
        if ($this->_status) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) OR strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(array(
                    'type' => ($full == TRUE) ? 'fullRefresh' : 'refresh',
                    'value' => $page
                ));
            } else {
                header("Location: $page");
            }
        } else {
            header("Location: $page");
        }
    }

    public function foreachArray($array, $tpl, $famous = FALSE) {
        foreach ($array AS $key => $value) {
            $newArray[$key] = $tpl;
            if (is_array($value)) {
                foreach ($value AS $name => $res) {
                    if ($famous) {
                        
                    } else {
                        $newArray[$key] = str_replace('{' . $name . '}', $res, $newArray[$key]);
                    }
                }
            }
        }

        return implode($newArray);
    }

    public function fromArray($array, $tpl) {
        if (is_array($array)) {
            if (array_key_exists(0, $array)) {
                $count = count($array);
                for ($i = 0; $i < $count; $i++) {
                    $newArray[$i] = $tpl;

                    foreach ($array[$i] AS $key => $value) {
                        if (is_array($value)) {
                            foreach ($value AS $name => $res) {
                                $newArray[$i] = str_replace('{'.$key.'_'.$value.'}', $res, $newArray[$i]);
                            }
                        } else {
                            $newArray[$i] = str_replace('{' . $key . '}', $value, $newArray[$i]);
                        }
                    }
                }

                return implode($newArray);
            } else {
                foreach ($array AS $key => $value) {
                    $tpl = str_replace('{' . $key . '}', $value, $tpl);
                }

                return $tpl;
            }
        }
    }

    public function set($name, $value) {
        $this->_vars['{' . $name . '}'] = $value;
    }

    public function sub_load($tpl_name, $array = NULL) {
        $tpl = "assets/view/$tpl_name.tpl";
        if (!file_exists($tpl)) {
            die("Шаблон <b>$tpl</b> не найден!");
        }
        $tpl = file_get_contents($tpl);
        if (count($array) > 0) {
            foreach ($array as $name => $value) {
                $tpl = str_replace('{' . $name . '}', $value, $tpl);
            }
        }
        return $tpl;
    }

    public function load($tpl_name, $return = FALSE, $sub = FALSE) {
        $tpl = (!empty($sub)) ? "assets/view/$tpl_name.tpl" : "template/{$this->_template}/$tpl_name.tpl";

        if (!file_exists($tpl)) {
            die("Шаблон <b>$tpl</b> не найден!");
        }

        $tpl = file_get_contents($tpl);
        if (count($this->_vars) > 0) {
            foreach ($this->_vars as $name => $value) {
                if (is_array($value)) {
                    foreach ($value AS $key => $val) {
                        $tpl = str_replace($key, $val, $tpl);
                    }
                } else {
                    $tpl = str_replace($name, $value, $tpl);
                }
            }
        }
        $this->_vars = array();
        if ($_POST['modal'] == TRUE) {
            echo $this->sub_load('modal/main', array('content' => $tpl, 'id' => $_POST['id']));
        } else {
            if ($return == TRUE) {
                return $tpl;
            } else {
                echo $tpl;
            }
        }
    }

}
