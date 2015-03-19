<?php

class Ajax {

    private $_status = NULL;
    private $_standart = array('main', 'index');
    private $_controller = NULL;
    private $_error = FALSE;

    public function __construct() {
        $this->object = new Object;
        $this->_status = (bool) Config::get('general', 'ajax');
        if (Config::get('general', 'techWork') == 1) {
            $array = $this->object->route->getArray();
            if ($array[1] != 'dev' AND $array[0] != 'captcha' AND $array[0] != 'userbar') {
                if ($_SESSION['Name'] AND $_SESSION['Admin'] < 1) {
                    session_destroy();
                    $this->object->view->refresh('/', true);
                    exit();
                } else if (!$_SESSION['Name']) {
                    if ($this->isAjax()) {
                        if ($_SERVER['REQUEST_URI'] !== '/user/login/') {
                            $this->object->view->refresh('/', true);
                            exit();
                        }
                    } else {
                        echo $_SERVER['REQUEST_URI'];
                        if ($_SERVER['REQUEST_URI'] !== '/' AND $_SERVER['REQUEST_URI'] !== '/user/login/') {
                            $this->object->view->refresh('/', true);
                            exit();
                        } else {
                            $this->_error = $this->object->view->message(array('type' => 'warning', 'text' => 'На сайте ведутся технические работы, попробуйте зайти позже.'), true);
                        }
                    }
                }
            }
        }
    }

    public function init($array) {
        if ($this->_status) {
            ($this->isAjax()) ? $this->_getController($array) : $this->_main($array);
        } else {
            if ($this->isAjax()) {
                if ($array[0] == 'admin' AND $array[1] == 'dev') {
                    $this->_getController($array);
                } else {
                    $this->_main($array);
                }
            } else {
                $this->_main($array);
            }
        }
    }

    private function _main($array) {
        if (Config::get('general', 'techWork') == 1) {
            if ($_SESSION['Name'] AND $_SESSION['Admin'] < 1) {
                session_destroy();
                $this->object->view->refresh('/', true);
                return FALSE;
            } else if (!$_SESSION['Name']) {
                $error = $this->object->view->message(array('type' => 'info', 'text' => 'На сайте ведутся технические работы, попробуйте зайти позже.'), true);
            }
        }

        ob_start();
        $this->_getController($array);
        $result = ob_get_contents();
        ob_end_clean();

        if ($this->_controller['controller'] != 'captcha' AND $this->_controller['controller'] != 'userbar') {
            $this->object->model->user->isLogin();

            preg_match('~<div id="title">(.*?)</div>~', $result, $title);
            $result = preg_replace('~<div id="title">(.*?)</div>~', '<div id="title" style="display:none;">' . $title[1] . '</div>', $result);
            $this->object->view->set('title', $title[1]);
            if (!$this->isAjax()) {
                $message = $this->object->controller->load('message', null, true);
                $check = $message->check();

                if (!empty($check)) {
                    $result = $check . $result;
                }
            }
            if ($this->_error !== FALSE) {
                $result = $this->_error . $result;
            }

            $result = '<div class="content">' . $result . '</div>';
            $this->object->view->set('content', $result);
            if ($this->_controller['controller'] == 'dev') {
                $ajax .= '<script type="text/javascript" src="/assets/view/javascript/ajax.js"></script>';
                $this->object->view->set('scripts', $this->object->view->sub_load('javascript/scripts') . $ajax);
                $this->object->view->load('admin/dev/main', false, true);
            } else {
                $this->object->module->load('menu');
                $this->object->view->addArray($this->object->module->Menu->get());
                $scripts = $this->object->view->sub_load('javascript/scripts');
                if ($this->_status) {
                    $scripts .= '<script type="text/javascript" src="/assets/view/javascript/ajax.js"></script>';
                }
                $this->object->view->set('scripts', $scripts);
                $this->object->view->load('main');
            }
        } else {
            echo $result;
        }
    }

    private function _getController($array) {
        $count = count($array);
        $newDir = "assets/controller/";

        for ($i = 0; $i < $count; $i++) {
            if (!is_dir($newDir . "{$array[$i]}/")) {
                $num = $i;
                break;
            } else {
                $newDir .= "{$array[$i]}/";
            }
        }
        $filter = array(
            'controller' => (empty($array[$num])) ? $this->_standart[0] : $array[$num],
            'method' => (empty($array[$num + 1])) ? $this->_standart[1] : $array[$num + 1],
            'attributes' => (is_array($array)) ? array_slice($array, $num + 2) : NULL,
        );

        $this->_controller = $filter;

        if ($_POST['form'] OR $_POST['userBarForm']) {
            $this->_formFilter($_POST['form'], (empty($_POST['userBarForm']) ? false : true));
            unset($_POST['form']);
        }

        $object = new Object();

        $controllerObject = $object->controller->load($filter['controller'], $newDir, ($filter['controller'] == 'Message') ? TRUE : NULL);
        if (method_exists($controllerObject, $filter['method'])) {
            $controllerObject->$filter['method']($filter['attributes']);
        } else {
            exit("URL не найден: <b>{$filter['controller']}/{$filter['method']}</b>.");
        }
    }

    private function _formFilter($string, $userbar = FALSE) {
        if ($userbar) {
            $_POST = array(
                'image' => $_POST['userBarForm']['image'],
                'data' => json_decode($_POST['userBarForm']['data'])
            );

            foreach ($_POST['data'] AS $key => $value) {
                $_POST['data'][$key] = (array) $value;
            }
        } else {
            $array = json_decode($string);
            $count = count($array);
            for ($i = 0; $i < $count; $i++) {
                $arr = json_decode($array[$i]);
                $_POST[$arr[0]] = $arr[1];
            }
        }
    }

    public function isAjax() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) OR strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

}
