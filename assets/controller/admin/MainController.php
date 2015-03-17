<?php

class MainController extends Object {

    public function index() {
        $this->_checkAdmin();
        $array = $this->privileges->getPrivileges($_SESSION['Admin']);
        if (!empty($array['modules'])) {
            foreach ($array['privileges'] AS $key => $value) {
                $count = count($value);

                for ($i = 0; $i < $count; $i++) {
                    if (!$value[$i]['active']) {
                        unset($array['privileges'][$key][$i]);
                        sort($array['privileges'][$key]);
                    }
                }
            }

            foreach ($array['modules'] AS $key => $value) {
                $newArray[] = array(
                    'name' => $key,
                    'title' => $value,
                    'value' => $this->view->fromArray($array['privileges'][$key], $this->view->sub_load('admin/main/privileges/oneMod')),
                    'active' => ($key == 'news') ? 'in' : ''
                );
                unset($array['modules'][$key]);
                if (count($array['privileges'][$key]) > 0) {
                    $array['modules'][] = array(
                        'name' => $key,
                        'title' => $value,
                        'active' => ($key == 'news') ? 'active' : ''
                    );
                }
            }
            if (!empty($array['modules'])) {
                $this->view->set('level', $level);
                $this->view->set('links', $this->view->fromArray($array['modules'], $this->view->sub_load('admin/main/privileges/linkOne')));
                $this->view->set('body', $this->view->fromArray($newArray, $this->view->sub_load('admin/main/privileges/mainBody')));
                $this->view->load('admin/main/privileges/main', false, true);
            } else {
                $this->view->message(array('type' => 'danger', 'text' => 'Для вашего уровня администратора нету доступных прав доступа.'));
            }
        } else {
            $this->view->message(array('type' => 'danger', 'text' => 'Для вашего уровня администратора нету прав доступа.'));
        }
    }

    private function _checkAdmin() {
        if ($this->model->user->isLogin()) {
            if ($_SESSION['Admin'] > 0) {
                return TRUE;
            } else {
                $this->view->refresh('/user/account/');
                return die();
            }
        } else {
            $this->view->refresh('/user/login/');
            return die();
        }
    }

    public function get($args) {
        $this->_checkAdmin();
        
        if (!empty($args[0]) AND !empty($args[1])) {
            $array = $this->privileges->getLevels($_SESSION['Admin']);
            
            if ($array[$args[0]][$args[1]] === TRUE) {
                $controller = $this->controller->load($args[0], 'assets/controller/admin/modules/');
                $controller->$args[1]((!empty($args[2])) ? array_slice($args, 2) : NULL);
            } else {
                $this->view->message(array('type' => 'danger', 'text' => 'У вас нету доступа к данной странице.'));
            }
        } else {
            $this->view->refresh('/admin/main/');
        }
    }

}
