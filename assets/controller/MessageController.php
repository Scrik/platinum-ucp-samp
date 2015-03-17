<?php

/*
 * Platinum UCP SAMP by brebvix (http://brebvix.blogspot.com)
 */

class MessageController extends Object {

    public function __construct($check = FALSE) {
        if ($this->model->user->isLogin()) {
            return TRUE;
        } else {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) OR strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' OR $check == TRUE) {
                return FALSE;
            } else {
                $this->view->refresh('/user/login/', true);
                return die();
            }
        }
    }

    public function index() {
        $this->inbox();
    }

    public function inbox() {
        $array = $this->model->message->getInbox();
        if (!empty($array)) {
            $count = count($array);

            for ($i = 0; $i < $count; $i++) {
                if ($array[$i]['from'] != 'Platinum UCP') {
                    $array[$i]['from'] = "<a href=\"/user/view/{$array[$i]['from']}/\">{$array[$i]['from']}</a>";
                }
                $date = $this->_getTime($array[$i]['date']);
                $array[$i]['date'] = $date['date'];
                $array[$i]['time'] = $date['time'];

                if ($array[$i]['status'] == 0) {
                    $array[$i]['title'] = "<span class=\"label label-danger\">Новое</span> {$array[$i]['title']}";
                }
            }

            $this->view->set('body', $this->view->fromArray($array, $this->view->sub_load('message/inbox/one')));
        } else {
            $this->view->set('body', '');
        }

        $this->view->load('/message/inbox/main', false, true);
    }

    public function outbox() {
        $array = $this->model->message->getOutbox();
        if (!empty($array)) {
            $count = count($array);

            for ($i = 0; $i < $count; $i++) {
                $array[$i]['to'] = "<a href=\"/user/view/{$array[$i]['to']}/\">{$array[$i]['to']}</a>";
                $date = $this->_getTime($array[$i]['date']);
                $array[$i]['date'] = $date['date'];
                $array[$i]['time'] = $date['time'];

                if ($array[$i]['status'] == 0) {
                    $array[$i]['title'] = "<span class=\"label label-danger\">Не прочитано</span> {$array[$i]['title']}";
                }
            }

            $this->view->set('body', $this->view->fromArray($array, $this->view->sub_load('message/outbox/one')));
        } else {
            $this->view->set('body', '');
        }

        $this->view->load('/message/outbox/main', false, true);
    }

    public function create($args) {
        if ($_POST['name'] AND $_POST['text']) {
            switch ($this->model->message->add($_POST)) {
                case 0:
                    $this->view->message(array('type' => 'danger', 'text' => 'Вы ввели неверную капчу.'));
                    break;
                case 1:
                    $this->view->message(array('type' => 'danger', 'text' => 'Длина заголовка не может быть меньше 6 и больше 32 символов.'));
                    break;
                case 2:
                    $this->view->message(array('type' => 'danger', 'text' => 'Длина сообщения не может быть меньше 6 и больше 2048 символов.'));
                    break;
                case 3:
                    $this->view->message(array('type' => 'danger', 'text' => 'Вы не можете отправить сообщение самому себе.'));
                    break;
                case 4:
                    $this->view->message(array('type' => 'danger', 'text' => 'Игрок с таким именем не найден.'));
                    break;
                case 5:
                    $this->view->message(array('type' => 'danger', 'text' => 'Игрок запретил отправку ему личных сообщений.'));
                    break;
                case 6:
                    $this->view->message(array('type' => 'success', 'text' => 'Сообщение успешно отправлено.'));
                    $error = FALSE;
                    break;
                case 7:
                    $this->view->message(array('type' => 'danger', 'text' => 'Ошибка отправки сообщения, попробуйте позже.'));
                    break;
            }

            if ($error !== FALSE) {
                $this->view->addArray($_POST);
            } else {
                $this->view->addArray(array('name' => (empty($args[0]) ? '' : $args[0]), 'title' => '', 'text' => ''));
            }
        } else {
            $this->view->addArray(array('name' => (empty($args[0]) ? '' : $args[0]), 'title' => '', 'text' => ''));
        }

        if ($continue !== FALSE) {
            $this->view->load('/message/create', false, true);
        }
    }

    public function view($args) {
        if (!is_numeric($args[0])) {
            $this->view->message(array('type' => 'danger', 'text' => 'Загрузка сообщения невозможна (неверный ID).'));
            return FALSE;
        }

        $result = $this->model->message->getFromID($args[0]);

        if (!is_array($result)) {
            switch ($result) {
                case 0:
                    $this->view->message(array('type' => 'danger', 'text' => 'Сообщение с таким ID не найдено.'));
                    break;
                case 1:
                    $this->view->message(array('type' => 'danger', 'text' => 'Сообщение удалено.'));
                    break;
                case 2:
                    $this->view->message(array('type' => 'danger', 'text' => 'Сообщение удалено.'));
                    break;
                case 3:
                    $this->view->message(array('type' => 'danger', 'text' => 'Ошибка доступа к сообщению.'));
                    break;
            }

            return FALSE;
        }

        if ($result['type'] == 0) {
            $result['to'] = 'Вы';
            $result['sendText'] = 'Ответить <b>' . $result['name'] . '</b>';
            if ($result['from'] !== 'Platinum UCP') {
                $result['from'] = "<a href=\"/user/view/{$result['from']}/\">{$result['from']}</a>";
            }
            
            if ($result['status'] == 0) {
                $result['title'] = "<span class=\"label label-danger\">Новое</span> {$result['title']}";
            }
        } else {
            $result['from'] = 'Вы';
            $result['sendText'] = 'Еще одно сообщение';
            $result['to'] = "<a href=\"/user/view/{$result['to']}/\">{$result['to']}</a>";
        }

        $date = $this->_getTime($result['date']);
        $result['date'] = $date['date'];
        $result['time'] = $date['time'];

        $this->view->addArray($result);
        $this->view->load('/message/view', false, true);
    }

    public function delete($args) {
        if (!is_numeric($args[0]) OR ! is_numeric($args[1])) {
            $this->view->message(array('type' => 'danger', 'text' => 'Удаление сообщения невозможно (неверный ID).'));
            return FALSE;
        }

        switch ($this->model->message->delete($args[0], $args[1])) {
            case 0:
                $this->view->message(array('type' => 'danger', 'text' => 'Сообщение с таким ID не найдено, или у вас нет доступа.'));
                break;
            case 1:
                $continue = TRUE;
                break;
            case 2:
                $this->view->message(array('type' => 'danger', 'text' => 'Вы уже удалили это сообщение.'));
                break;
        }

        if ($continue === TRUE) {
            $this->view->refresh(($args[0] == 0) ? '/message/inbox/' : '/message/outbox/');
        } else {
            ($args[0] == 0) ? $this->inbox() : $this->outbox();
        }
    }

    public function check($args = NULL) {
        if (!$_SESSION['Name']) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) OR strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(array('login' => false));
            }
            return FALSE;
        }
        $array = $this->model->message->checkNew();
        if (is_array($array)) {
            $this->view->set('body', $this->view->fromArray($array, $this->view->sub_load('message/new/one')));
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) OR strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $result = $this->view->load('/message/new/main', true, true);
                echo json_encode(array('login' => TRUE, 'data' => $result));
            } else {
                $data = $this->view->load('/message/new/main', true, true);
                return "<div class=\"msg\">$data</div>";
            }
        } else {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) OR strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode(array('login' => TRUE));
            }
        }
    }

    private function _getTime($data) {
        $date = explode(' ', $data);
        $time = explode(':', $date[1]);
        $array['time'] = "{$time[0]}:{$time[1]}";
        $date = explode('-', $date[0]);
        $array['date'] = "{$date[2]}/{$date[1]}/{$date[0]}";

        return $array;
    }

}
