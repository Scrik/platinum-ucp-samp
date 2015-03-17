<?php

class UserController extends Object {

    private function _checkAccess($login = TRUE) {
        if ($login) {
            if ($this->model->user->isLogin()) {
                return TRUE;
            } else {
                $this->view->refresh('/user/login/', true);
                return die();
            }
        } else {
            if (!$this->model->user->isLogin()) {
                return TRUE;
            } else {
                $this->view->refresh('/user/account/', true);
                return die();
            }
        }
    }

    public function index() {
        $this->_checkAccess(false);
        $this->_checkAccess();
    }

    public function account() {
        $this->_checkAccess();

        $array = $this->model->user->getAccountInfo($_SESSION['Name'], true);

        if (!empty($array['main'])) {
            $array['main']['host'] = $_SERVER['HTTP_HOST'];
            $this->view->addArray($array['main']);
            $this->view->set('body', $this->view->fromArray($array['extra'], $this->view->sub_load('user/account/one')));
            $this->view->load('/user/account/main', false, true);
        } else {
            $this->logout();
        }
    }

    public function view($args) {
        if ($_POST['name']) {
            $this->view->refresh("/user/view/{$_POST['name']}/");
        } else {
            if (!empty($args[0])) {
                $result = $this->model->user->getAccountInfo($args[0]);
                if (is_array($result)) {
                    $result['main']['host'] = $_SERVER['HTTP_HOST'];
                    $this->view->addArray($result['main']);
                    if ($_SESSION['Name']) {
                        $this->view->set('actions', $this->view->sub_load('/user/account/view/actions'));
                    } else {
                        $this->view->set('actions', '');
                    }
                    $this->view->set('body', $this->view->fromArray($result['extra'], $this->view->sub_load('user/account/view/one')));
                    $this->view->load('/user/account/view/main', false, true);
                } else {
                    $this->view->message(array('type' => 'danger', 'text' => 'Игрок не найден, или запретил доступ к своей статистике.'));
                }
            } else {
                $this->view->refresh('/user/');
            }
        }
    }

    public function login() {
        $this->_checkAccess(false);

        if ($_POST['name']) {
            switch ($this->model->user->login($_POST)) {
                case 0:
                    $this->view->message(array('type' => 'danger', 'text' => 'Вы ввели неверную капчу.'));
                    break;
                case 1:
                    $this->view->message(array('type' => 'danger', 'text' => 'Пользователь с такими данными не найден.<br>'
                        . '<a href="/user/recovery/"><button class="btn btn-primary">Забыли пароль?</button></a>'));
                    break;
                case 2:
                    $this->view->message(array('type' => 'danger', 'text' => 'На сайте идут технические работы, авторизация доступна только администрации.'));
                    break;
                case 3:
                    $this->view->refresh('/user/account/', true);
                    $continue = FALSE;
                    break;
            }
        }

        if ($continue !== FALSE) {
            $this->view->load('user/login', false, true);
        }
    }

    public function settings() {
        $this->_checkAccess(true);

        if ($_POST['message']) {
            if ($this->model->user->saveSettings($_POST)) {
                $this->view->message(array('type' => 'success', 'text' => 'Настройки успешно сохранены.'));
            } else {
                $this->view->message(array('type' => 'danger', 'text' => 'Ошибка сохранения настроек, попробуйте позже.'));
            }
            $this->account();
        } else {
            $array = $this->model->user->getSettings();
            if (!empty($array)) {
                foreach ($array AS $key => $value) {
                    if (!$value) {
                        $this->view->set("selected_$key", 'selected');
                    }
                }
                $this->view->load('user/settings', false, true);
            } else {
                $this->view->refresh('/user/logout/', true);
            }
        }
    }

    public function userbar() {
        $this->_checkAccess();

        if ($this->model->user->userBarEnabled()) {
            $array = $this->model->user->userBarInfo();
            if ($_POST['image'] AND $_POST['data']) {
                if ($this->model->user->saveUserBar($_POST)) {
                    $this->view->message(array('type' => 'success', 'text' => 'Изменения успешно сохранены.'));
                } else {
                    $this->view->message(array('type' => 'danger', 'text' => 'Ошибка сохранения, попробуйте позже.'));
                }
            } else {
                if (!empty($array['data']['image'])) {
                    $this->view->set('image', "<img id=\"current\" name=\"{$array['data']['image']}\" src=\"/assets/view/images/userbar/{$array['data']['image']}\">");
                    foreach ($array['data']['data'] AS $key => $value) {
                        if ($value['name'] == 'Skin') {
                            $mergeArray = array(
                                'pos_top' => $value['pos_top'],
                                'pos_left' => $value['pos_left'],
                                'fontSize' => $value['fontSize'],
                                'color' => $value['color'],
                                'name' => $value['name'],
                                'title' => $array['main'][$value['name']]['title'],
                                'value' => $array['main'][$value['name']]['value']
                            );
                        } else {
                            $newArray[] = array(
                                'pos_top' => $value['pos_top'],
                                'pos_left' => $value['pos_left'],
                                'fontSize' => $value['fontSize'],
                                'color' => $value['color'],
                                'name' => $value['name'],
                                'title' => $array['main'][$value['name']]['title'],
                                'value' => $array['main'][$value['name']]['value']
                            );
                        }
                    }
                    if (!empty($mergeArray)) {
                        $newArray[] = $mergeArray;
                    }
                    $this->view->set('position', $this->view->fromArray($newArray, $this->view->sub_load('user/userbar/onePosition')));
                } else {
                    $this->view->set('image', '');
                    $this->view->set('position', '');
                }

                $this->view->set('values', $this->view->foreachArray($array['main'], $this->view->sub_load('user/userbar/select')));
                $this->view->set('body', $this->view->fromArray($array['image'], $this->view->sub_load('user/userbar/imageList')));
                $this->view->load('user/userbar/settings', false, true);
            }
        } else {
            $this->view->message(array('type' => 'danger', 'text' => 'Вы отключили UserBar в настройках приватности.'));
        }
    }

    public function changePassword() {
        $this->_checkAccess();

        if (Config::get('general', 'changePass') != 1) {
            $this->view->message(array('type' => 'danger', 'text' => 'Администрация запретила смену пароля.'));
            return FALSE;
        }

        if ($_POST['oldPass']) {
            switch ($this->model->user->changePassword($_POST)) {
                case 0:
                    $this->view->message(array('type' => 'danger', 'text' => '"Новый пароль" не совпадает с "Повторите новый пароль".'));
                    break;
                case 1:
                    $this->view->message(array('type' => 'danger', 'text' => 'Длина нового пароля не может быть меньше 6 и больше 16 символов.'));
                    break;
                case 2:
                    $this->view->message(array('type' => 'danger', 'text' => 'Вы должны выйти с сервера, прежде чем сможете сменить пароль.'));
                    break;
                case 3:
                    $this->view->message(array('type' => 'danger', 'text' => 'Вы ввели неверный старый пароль.'));
                    break;
                case 4:
                    $this->view->message(array('type' => 'success', 'text' => 'Вы успешно сменили пароль.'));
                    $this->account();
                    $continue = FALSE;
                    break;
                case 5:
                    $this->view->message(array('type' => 'danger', 'text' => 'Ошибка при смене пароля, попробуйте позже.'));
                    break;
            }
        }

        if ($continue !== FALSE) {
            $this->view->load('user/changePassword', false, true);
        }
    }

    public function changeEmail($args) {
        $this->_checkAccess();

        if (Config::get('general', 'changeEmail') != 1) {
            $this->view->message(array('type' => 'danger', 'text' => 'Администрация запретила смену E-Mail.'));
            return FALSE;
        }

        if (strlen($args[0]) == 32) {
            $continue = FALSE;
            switch ($this->model->user->changeEmailKey($args[0])) {
                case 0:
                    $this->view->message(array('type' => 'danger', 'text' => 'Заявка на смену E-Mail с таким ключем не существует.'));
                    break;
                case 1:
                    $this->view->message(array('type' => 'success', 'text' => 'Вы успешно подтвердили свой старый E-Mail адрес, на ваш новый E-Mail отправлено письмо с ссылкой для подтверждения.'));
                    break;
                case 2:
                    $this->view->message(array('type' => 'danger', 'text' => 'Выйдите с сервера, а затем еще раз перейдите по ссылке.'));
                    $continue = FALSE;
                    break;
                case 3:
                    $this->view->message(array('type' => 'success', 'text' => 'Вы успешно сменили E-Mail.'));
                    break;
                case 4:
                    $this->view->message(array('type' => 'danger', 'text' => 'Ошибка при смене E-Mail, попробуйте позже.'));
                    break;
            }
        } else {
            if ($_POST['email']) {
                switch ($this->model->user->changeEmail($_POST['email'])) {
                    case 0:
                        $this->view->message(array('type' => 'danger', 'text' => 'Введите правильный E-Mail.'));
                        break;
                    case 1:
                        $this->view->message(array('type' => 'danger', 'text' => 'Вы уже оставили заявку на смену E-Mail. '
                            . '<a href="/user/changeEmailDelete/">Удалить заявку на смену E-Mail</a>'));
                        $continue = FALSE;
                        break;
                    case 2:
                        $this->view->message(array('type' => 'danger', 'text' => 'Введите <b><u>новый</u></b> E-Mail.'));
                        break;
                    case 3:
                        $this->view->message(array('type' => 'success', 'text' => 'На ваш старый E-Mail адрес отправлено письмо с ссылкой для подтверждения, перейдите по ней.'));
                        $continue = FALSE;
                        break;
                    case 4:
                        $this->view->message(array('type' => 'success', 'text' => 'На ваш новый E-Mail адрес отправлено письмо с ссылкой для подтверждения, перейдите по ней.'));
                        $continue = FALSE;
                        break;
                    case 5:
                        $this->view->message(array('type' => 'danger', 'text' => 'Ошибка при отправке заявки на смену E-Mail, попробуйте позже.'));
                        break;
                }
            }
        }
        if ($continue !== FALSE) {
            $this->view->load('user/changeEmail', false, true);
        } else {
            $this->account();
        }
    }

    public function changeEmailDelete() {
        $this->_checkAccess();

        if ($this->model->user->changeEmailDelete()) {
            $this->view->message(array('type' => 'success', 'text' => 'Заявка на смену E-Mail успешно удалена, теперь вы можете сменить E-Mail.'));
        } else {
            $this->view->message(array('type' => 'danger', 'text' => 'Ошибка при удалении заявки на смену E-Mail, попробуйте позже.'));
        }

        $this->account();
    }

    public function recovery($args) {
        $this->_checkAccess(false);

        if (Config::get('general', 'recovery') != 1) {
            $this->view->message(array('type' => 'danger', 'text' => 'Администрация запретила восстановление пароля.'));
            return FALSE;
        }

        if (strlen($args[0]) == 32) {
            switch($this->model->user->recoveryKey($args[0])) {
                case 0:
                    $this->view->message(array('type' => 'danger', 'text' => 'Ключ не найден.'));
                    break;
                case 1:
                    $this->view->message(array('type' => 'danger', 'text' => 'Выйдите с сервера, и перейдите по ссылке еще раз.'));
                    break;
                case 2:
                    $this->view->message(array('type' => 'success', 'text' => 'Вы успешно сменили пароль, новый пароль отправлен на ваш E-Mail адрес.'));
                    $this->login();
                    $continue = FALSE;
                    break;
                case 3:
                    $this->view->message(array('type' => 'danger', 'text' => 'Ошибка восстановления пароля, попробуйте позже.'));
                    break;
            }
        } else if ($_POST['name'] AND $_POST['email']) {
            switch ($this->model->user->recovery($_POST['name'], $_POST['email'], $_POST['captcha'])) {
                case 0:
                    $this->view->message(array('type' => 'danger', 'text' => 'Вы ввели неверную капчу.'));
                    break;
                case 1:
                    $this->view->message(array('type' => 'danger', 'text' => 'Пользователь с таким NickName и E-Mail не найден.'));
                    break;
                case 2:
                    $this->view->message(array('type' => 'success', 'text' => 'Для "вашего" аккаунта уже запрашивалось восстановление пароля, однако был сгенерирован новый ключ и повторно отправлен на вашу почту.'));
                    break;
                case 3:
                    $this->view->message(array('type' => 'danger', 'text' => 'Неизвестная ошибка, попробуйте еще раз.'));
                    break;
                case 4:
                    $this->view->message(array('type' => 'success', 'text' => 'На ваш E-Mail адрес отправлено письмо с ссылкой для подтверждения, перейдите по ней.'));
                    break;
            }
        }
        if ($continue !== FALSE) {
            $this->view->load('user/recovery', false, true);
        }
    }
    
    public function register() {
        $this->_checkAccess(false);
        
        if ($_POST['name']) {
            switch ($this->model->user->register($_POST)) {
                case 0:
                    $this->view->message(array('type' => 'danger', 'text' => 'Вы ввели неверную капчу.'));
                    break;
                case 1:
                    $this->view->message(array('type' => 'danger', 'text' => 'Игрок с таким никнеймом уже существует.'));
                    break;
                case 2:
                    $this->view->message(array('type' => 'success', 'text' => 'Аккаунт успешно зарегистрирован.'));
                    break;
                case 3:
                    $this->view->message(array('type' => 'danger', 'text' => 'Ошибка регистрации, попробуйте позже.'));
                    break;
            }
        }
        
        $this->view->load('/user/register', false, true);
    }
    
    public function logout() {
        $this->_checkAccess();

        $this->model->user->logout();
        $this->view->refresh('/user/login/', true);
    }

}
