<?php

class UserModel extends Object {

    private $_account = array('id', 'Admin', 'Name');

    public function isLogin() {
        if ($_SESSION['Name']) {
            return TRUE;
        } else {
            if (!empty($_COOKIE['brebvix'])) {
                $key = md5($_SERVER['REMOTE_ADDR'] . 'brebvix.blogspot.com');
                if ($_COOKIE['brebvix'] == $key) {
                    $result = $this->db->select("SELECT `name` FROM `platinum_login` WHERE `key` = '$key'", false);
                    if (!empty($result)) {
                        $array = $this->table->get('account', array('Admin', 'Name'), true);

                        $adminLevel = $this->db->select("SELECT `{$array['Admin']}` FROM `{$array['table']}` WHERE `{$array['Name']}` = '{$result['name']}'", false);

                        if ($adminLevel[$array['Admin']] > 0) {
                            $_SESSION['Admin'] = $adminLevel[$array['Admin']];
                        }

                        $_SESSION['Name'] = $result['name'];
                        $check = $this->db->select("SELECT `id` FROM `platinum_users` WHERE `Name` = '{$result['name']}'", false);
                        if (empty($check)) {
                            $settings = urlencode(json_encode(array(
                                'message' => TRUE,
                                'profile' => TRUE,
                                'userbar' => TRUE
                            )));
                            $userbar = urlencode(json_encode(array()));
                            $this->db->query("INSERT INTO `platinum_users`(`Name`, `settings`, `userbar`) VALUES('{$result['name']}', '$settings', '$userbar')");
                        }

                        return TRUE;
                    } else {
                        setcookie('brebvix', '', time() - 3600);
                        return FALSE;
                    }
                } else {
                    setcookie('brebvix', '', time() - 3600);
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        }
    }

    public function isOnline($name = NULL) {
        $array = Config::get('online');

        if ($array['enable']) {
            $table = $this->table->get('account', array('Name', 'Online'), true);
            $name = (empty($name)) ? $_SESSION['Name'] : $name;
            $select = $this->db->select("SELECT `{$table['Online']}` FROM `{$table['table']}` WHERE `{$table['Name']}` = '{$name}'", false);
            if (!empty($select)) {
                return ($select[$table['Online']] == $array['value']) ? true : false;
            } else {
                return FALSE;
            }
        } else {
            return TRUE;
        }
    }

    public function login($array) {
        $captcha = $this->controller->load('captcha');

        if ($captcha->check($array['captcha'])) {
            if (Config::get('general', 'md5')) {
                $array['password'] = md5($array['password']);
            }

            $array = $this->db->filter($array);
            $table = $this->table->get('account', array('Name', 'Password', 'Admin'), true);
            $query = "SELECT `{$table['Admin']}`, `{$table['Name']}` FROM `{$table['table']}` WHERE `{$table['Name']}` = '{$array['name']}' AND `{$table['Password']}` = '{$array['password']}'";
            $result = $this->db->select($query, false);

            if (!empty($result)) {
                if ($result[$table['Admin']] > 0) {
                    $_SESSION['Admin'] = $result[$table['Admin']];
                }
                if (Config::get('general', 'techWork') == 1) {
                    if ($_SESSION['Admin'] < 1) {
                        return 2;
                    }
                }
                $_SESSION['Name'] = $array['name'];
                $key = md5($_SERVER['REMOTE_ADDR'] . 'brebvix.blogspot.com');
                setcookie('brebvix', $key, time() + 172800);
                $select = $this->db->select("SELECT `id` FROM `platinum_login` WHERE `name` = '{$array['name']}'", false);
                if (!empty($select)) {
                    $this->db->query("DELETE FROM `platinum_login` WHERE `name` = '{$array['name']}'");
                }
                $checkSettings = $this->db->select("SELECT `id` FROM `platinum_users` WHERE `Name` = '{$array['name']}'", false);

                if (empty($checkSettings)) {
                    $settings = urlencode(json_encode(array('message' => TRUE, 'profile' => TRUE, 'userbar' => false)));
                    $userbar = urlencode(json_encode(array()));
                    $this->db->query("INSERT INTO `platinum_users`(`Name`, `settings`, `userbar`) VALUES('{$array['name']}', '$settings', '$userbar')");
                }
                $this->db->query("INSERT INTO `platinum_login`(`name`, `key`) VALUES('{$array['name']}', '$key')");
                return 3;
            } else {
                return 1;
            }
        } else {
            return 0;
        }
    }

    public function getSettings() {
        $array = $this->db->select("SELECT `settings` FROM `platinum_users` WHERE `Name` = '{$_SESSION['Name']}'", false);
        if (!empty($array)) {
            return json_decode(urldecode($array['settings']), true);
        } else {
            return FALSE;
        }
    }

    public function saveSettings($array) {
        $array = $this->db->filter($array);

        $array = urlencode(json_encode(array(
            'message' => (bool) $array['message'],
            'profile' => (bool) $array['profile'],
            'userbar' => (bool) $array['userbar']
        )));

        return $this->db->query("UPDATE `platinum_users` SET `settings` = '$array' WHERE `Name` = '{$_SESSION['Name']}'");
    }

    public function userBarEnabled() {
        $array = $this->db->select("SELECT `settings` FROM `platinum_users` WHERE `Name` = '{$_SESSION['Name']}'", false);
        $settings = json_decode(urldecode($array['settings']), true);
        return $settings['userbar'];
    }

    public function userBarInfo() {
        $images = scandir($_SERVER['DOCUMENT_ROOT'] . '/assets/view/images/userbar/');

        if ($images !== FALSE) {
            $table = $this->table->get('account');
            $uName = $_SESSION['Name'];

            if (empty($table)) {
                return FALSE;
            }

            foreach ($table['value'] AS $value) {
                if ($value[4]) {
                    $newArray[] = $value;
                }
            }

            if (!empty($newArray)) {
                foreach ($newArray AS $value) {
                    $queryArray[] = $value[2];
                }

                $query = $this->table->fromArray($queryArray);
                $accountInfo = $this->db->select("SELECT $query FROM `{$table['name']}` WHERE `{$table['value']['Name'][2]}` = '$uName'", false);
                if (!empty($accountInfo)) {
                    $array['main'] = $accountInfo;
                }
            }
            $format = $this->controller->load('format');

            $array = $format->main('account', $array, true);
            if (!empty($array['main'])) {
                foreach ($array['main'] AS $key => $value) {
                    unset($array['main'][$key]);
                    $name = $this->table->findValue('account', $key);
                    $value = strip_tags($value);
                    $array['main'][$name] = array('name' => $name, 'title' => $table['value'][$name]['3'], 'value' => $value);
                }
            }
            $userbar = $this->db->select("SELECT `userbar` FROM `platinum_users` WHERE `Name` = '$uName'", false);
            $userbar = json_decode(urldecode($userbar['userbar']), true);

            $images = preg_grep('/\\.(?:png)$/', $images);
            foreach ($images as $image) {
                $array['image'][] = array(
                    'name' => $image,
                    'selected' => ($userbar['image'] == $image) ? 'selected' : ''
                );
            }
            $array['data'] = $userbar;
            return $array;
        }
    }

    public function saveUserBar($array) {
        $array = $this->db->filter($array);
        $count = count($array['data']);
        if ($count > 0 AND $count < 9) {
            $array = urlencode(json_encode($array));
            $name = $_SESSION['Name'];

            if ($this->db->query("UPDATE `platinum_users` SET `userbar` = '$array' WHERE `Name` = '$name'")) {
                $file = "{$_SERVER['DOCUMENT_ROOT']}/assets/view/images/cache/$name.png";
                if (is_file($file)) {
                    unlink($file);
                }

                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function getAccountInfo($name, $acc = FALSE) {
        $table = $this->table->get('account');
        $name = $this->db->filter($name);

        $access = $this->db->select("SELECT `settings` FROM `platinum_users` WHERE `Name` = '$name'", false);
        if (!empty($access['settings'])) {
            $settings = json_decode(urldecode($access['settings']), true);
        }

        if ($settings['profile'] == TRUE OR $acc == TRUE) {

            foreach ($table['value'] AS $value) {
                if ($value[4]) {
                    $newArray[] = $value;
                }
            }

            if (!empty($newArray)) {
                foreach ($newArray AS $value) {
                    $queryArray[] = $value[2];
                }

                $query = $this->table->fromArray($queryArray);
                $accountInfo = $this->db->select("SELECT $query FROM `{$table['name']}` WHERE `{$table['value']['Name'][2]}` = '$name'", false);
                if (!empty($accountInfo)) {
                    $array['extra'] = $accountInfo;
                }
            }

            $query = $this->table->fromArray($this->table->get('account', array('Name', 'Admin', 'Email', 'Skin'), true, false));
            $array['main'] = $this->db->select("SELECT $query FROM `{$table['name']}` WHERE `{$table['value']['Name'][2]}` = '$name'", false);
            $format = $this->controller->load('format');

            $array = $format->main('account', $array, true);
            if (!empty($array['extra'])) {
                foreach ($array['extra'] AS $key => $value) {
                    unset($array['extra'][$key]);
                    $name = $this->table->findValue('account', $key);
                    $array['extra'][] = array('title' => $table['value'][$name]['3'], 'value' => $value);
                }
            }
            $array['settings'] = $settings;
            $array['main'] = $this->table->findValue('account', $array['main']);
            return $array;
        } else {
            return FALSE;
        }
    }

    public function changePassword($array) {
        $array = $this->db->filter($array, true);

        if ($array['newPass'] != $array['reNewPass']) {
            return 0;
        }

        if (strlen($array['newPass']) < 6 OR strlen($array['newPass']) > 16) {
            return 1;
        }

        if (Config::get('online', 'enable') == 1) {
            if (!$this->isOnline()) {
                return 2;
            }
        }

        $table = $this->table->get('account', array('Name', 'Password'), true);
        $data = $this->db->select("SELECT `{$table['Password']}` FROM `{$table['table']}` WHERE `{$table['Name']}` = '{$_SESSION['Name']}'", false);
        $md5 = (bool) Config::get('general', 'md5');
        $password = ($md5) ? md5($data[$table['Password']]) : $data[$table['Password']];
        $oldPass = ($md5) ? md5($array['oldPass']) : $array['oldPass'];

        if ($password != $oldPass) {
            return 3;
        }

        $newPass = ($md5) ? md5($array['newPass']) : $array['newPass'];
        $result = $this->db->query("UPDATE `{$table['table']}` SET `{$table['Password']}` = '$newPass' WHERE `{$table['Name']}` = '{$_SESSION['Name']}'");
        if ($result) {
            return 4;
        } else {
            return 5;
        }
    }

    public function changeEmail($email) {
        $email = $this->db->filter($email, true);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 0;
        }

        $check = $this->db->select("SELECT `id` FROM `platinum_email` WHERE `Name` = '{$_SESSION['Name']}'", false);

        if (!empty($check)) {
            return 1;
        }
        $table = $this->table->get('account', array('Name', 'Email'), true);
        $oldEmail = $this->db->select("SELECT `{$table['Email']}` FROM `{$table['table']}` WHERE `{$table['Name']}` = '{$_SESSION['Name']}'", false);
        $oldEmail = $oldEmail[$table['Email']];

        if ($oldEmail == $email) {
            return 2;
        }
        $key = md5(uniqid(rand(), 1));
        $status = (empty($oldEmail)) ? 1 : 0;
        $result = $this->db->query("INSERT INTO `platinum_email`(`Name`, `oldEmail`, `newEmail`, `key`, `status`) VALUES('{$_SESSION['Name']}', '$oldEmail', '$email', '$key', '$status')");

        if ($result) {
            $array = array(
                'host' => $_SERVER['HTTP_HOST'],
                'name' => $_SESSION['Name'],
                'key' => $key,
            );
            if ($status == 0) {
                $this->mail->send($oldEmail, "Смена E-Mail на аккаунте {$_SESSION['Name']}", $this->view->sub_load('user/email/oldMail', $array));
                return 3;
            } else {
                $this->mail->send($email, "Смена E-Mail на аккаунте {$_SESSION['Name']}", $this->view->sub_load('user/email/newMail', $array));
                return 4;
            }
        } else {
            return 5;
        }
    }

    public function changeEmailDelete() {
        $check = $this->db->select("SELECT `id` FROM `platinum_email` WHERE `Name` = '{$_SESSION['Name']}'", false);
        if (empty($check['id'])) {
            return FALSE;
        }

        return $this->db->query("DELETE FROM `platinum_email` WHERE `Name` = '{$_SESSION['Name']}'");
    }

    public function changeEmailKey($key) {
        $key = $this->db->filter($key);
        $check = $this->db->select("SELECT `id`, `newEmail`, `status` FROM `platinum_email` WHERE `Name` = '{$_SESSION['Name']}' AND `key` = '{$key}'", false);

        if (empty($check)) {
            return 0;
        }

        if ($check['status'] == 0) {
            $key = md5(uniqid(rand(), 1));
            $array = array(
                'host' => $_SERVER['HTTP_HOST'],
                'name' => $_SESSION['Name'],
                'key' => $key,
            );
            $this->db->query("UPDATE `platinum_email` SET `status` = '1', `key` = '{$key}' WHERE `id` = '{$check['id']}'");
            $this->mail->send($check['newEmail'], "Смена E-Mail на аккаунте {$_SESSION['Name']}", $this->view->sub_load('user/email/newMail', $array));

            return 1;
        } else {
            if (Config::get('online', 'enable') == 1) {
                if (!$this->isOnline()) {
                    return 2;
                }
            }
            $table = $this->table->get('account', array('Name', 'Email'), true);
            $this->db->query("DELETE FROM `platinum_email` WHERE `id` = '{$check['id']}'");
            $result = $this->db->query("UPDATE `{$table['table']}` SET `{$table['Email']}` = '{$check['newEmail']}' WHERE `{$table['Name']}` = '{$_SESSION['Name']}'");

            if ($result) {
                return 3;
            } else {
                return 4;
            }
        }
    }

    public function recovery($name, $email, $captcha) {
        $captchaController = $this->controller->load('captcha');
        if (!$captchaController->check($captcha)) {
            return 0;
        }

        $name = $this->db->filter($name);
        $email = $this->db->filter($email);
        $table = $this->table->get('account', array('Name', 'Email'), true);

        $checkUser = $this->db->select("SELECT `{$table['Name']}` FROM `{$table['table']}` WHERE `{$table['Name']}` = '$name' AND `{$table['Email']}` = '$email'", false);

        if (empty($checkUser[$table['Name']])) {
            return 1;
        }

        $array = $this->db->select("SELECT `email` FROM `platinum_recovery` WHERE `Name` = '{$name}'", false);

        if (!empty($array['email'])) {
            if ($email == $array['email']) {
                $data = array(
                    'host' => $_SERVER['HTTP_HOST'],
                    'name' => $name,
                    'key' => md5(uniqid(rand(), 1)),
                );
                $this->db->query("UPDATE `platinum_recovery` SET `key` = '{$data['key']}' WHERE `Name` = '{$name}'");
                $this->mail->send($array['email'], 'Восстановление пароля ' . $data['name'], $this->view->sub_load('user/recovery/mail', $data));
                return 2;
            } else {
                $this->db->query("DELETE FROM `platinum_email` WHERE `Name` = '$name'");
                return 3;
            }
        } else {
            $data = array(
                'host' => $_SERVER['HTTP_HOST'],
                'name' => $name,
                'key' => md5(uniqid(rand(), 1)),
            );
            $this->db->query("INSERT INTO `platinum_recovery`(`Name`, `email`, `key`) VALUES('$name', '$email', '{$data['key']}')");
            $this->mail->send($email, 'Восстановление пароля ' . $data['name'], $this->view->sub_load('user/recovery/mail', $data));
            return 4;
        }
    }

    public function recoveryKey($key) {
        $key = $this->db->filter($key);

        $check = $this->db->select("SELECT `id`, `Name`, `email` FROM `platinum_recovery` WHERE `key` = '$key'", false);

        if (empty($check)) {
            return 0;
        }

        if (Config::get('online', 'enable') == 1) {
            if (!$this->isOnline($check['Name'])) {
                return 1;
            }
        }

        $password = $this->_passGenerator(rand(6, 12));
        if (Config::get('general', 'md5') == 1) {
            $dbPass = md5($password);
        } else {
            $dbPass = $password;
        }

        $table = $this->table->get('account', array('Name', 'Password'), true);
        $result = $this->db->query("UPDATE `{$table['table']}` SET `{$table['Password']}` = '$password' WHERE `{$table['Name']}` = '{$check['Name']}'");
        if ($result) {
            $this->db->query("DELETE FROM `platinum_recovery` WHERE `id` = '{$check['id']}'");
            $data = array(
                'host' => $_SERVER['HTTP_HOST'],
                'name' => $check['name'],
                'password' => $password
            );
            $this->mail->send($check['email'], 'Новый пароль ' . $check['Name'], $this->view->sub_load('user/recovery/newPass', $data));
            return 2;
        } else {
            return 3;
        }
    }

    private function _passGenerator($length) {
        $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
        $size = strlen($chars) - 1;
        while (--$length) {
            $password .= $chars[rand(0, $size)];
        }

        return $password;
    }

    public function register($array) {
        $array = $this->db->filter($array, true);
        $captcha = $this->controller->load('captcha');

        if (!$captcha->check($array['captcha'])) {
            return 0;
        }
        $result = $this->db->select("SELECT `id` FROM `accounts` WHERE `name` = '{$array['name']}'", false);
        if (!empty($result['id'])) {
            return 1;
        }

        $sex = rand(0, 1);
        $skin = rand(0, 300);
        $money = rand(0, 10000000);
        $level = rand(1, 15);
        if ($this->db->query("INSERT INTO `accounts`(`name`, `pass`, `mail`, `sex`, `skin`, `money`, `level`) VALUES"
                        . "('{$array['name']}', '{$array['password']}', '{$array['email']}', '$sex', '$skin', '$money', '$level')")) {
            return 2;
        } else {
            return 3;
        }
    }

    public function logout() {
        $this->db->query("DELETE FROM `platinum_login` WHERE `name` = '{$_SESSION['Name']}'");
        setcookie('brebvix', '', time() - 3600);
        session_destroy();
    }

}
