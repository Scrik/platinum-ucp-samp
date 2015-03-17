<?php

/*
 * Platinum UCP SAMP by brebvix
 */

class MessageModel extends Object {

    public function add($array, $system = FALSE) {
        $array = $this->db->filter($array, true);
        if ($system == FALSE) {
            $captcha = $this->controller->load('captcha');
            if (!$captcha->check($array['captcha'])) {
                return 0;
            }

            $title = strlen(utf8_decode($array['title']));
            if ($title < 6 OR $title > 32) {
                return 1;
            }

            $text = strlen(utf8_decode($array['text']));
            if ($text < 7 OR $text > 2048) {
                return 2;
            }

            if ($array['name'] == $_SESSION['Name']) {
                return 3;
            }

            $table = $this->table->get('account', array('Name'), true);
            $userCheck = $this->db->select("SELECT `{$table['Name']}` FROM `{$table['table']}` WHERE `{$table['Name']}` = '{$array['name']}'", false);
            if (empty($userCheck)) {
                return 4;
            }

            $settings = $this->db->select("SELECT `settings` FROM `platinum_users` WHERE `Name` = '{$array['name']}'", false);

            if (!empty($settings)) {
                $settings = json_decode(urldecode($settings['settings']), true);
            }

            if (!$settings['message']) {
                return 5;
            }
        }

        if ($system === FALSE) {
            $from = $_SESSION['Name'];
            $delete = 0;
        } else {
            $from = 'Platinum UCP';
            $delete = 1;
        }
        $insert = $this->db->query("INSERT INTO `platinum_message`(`to`, `from`, `title`, `text`, `deleteFROM`) VALUES('{$array['name']}', '$from', '{$array['title']}', '{$array['text']}', '$delete')");
        if ($insert) {
            return 6;
        } else {
            return 7;
        }
    }

    public function getInbox() {
        return $this->db->select("SELECT `id`, `from`, `date`, `title`, `status` FROM `platinum_message` WHERE `to` = '{$_SESSION['Name']}' AND `deleteTO` = '0' ORDER BY `id` DESC");
    }
    
    public function getOutbox() {
        return $this->db->select("SELECT `id`, `to`, `date`, `title`, `status` FROM `platinum_message` WHERE `from` = '{$_SESSION['Name']}' AND `deleteFROM` = '0' ORDER BY `id` DESC");
    }

    public function getFromID($id) {
        $id = $this->db->filter($id);

        $result = $this->db->select("SELECT * FROM `platinum_message` WHERE `id` = '$id'", false);

        if (empty($result)) {
            return 0;
        }

        $name = $_SESSION['Name'];
        if ($result['to'] == $name) {
            $result['type'] = 0;
            $result['name'] = $result['from'];
            if ($result['deleteTO'] == 1) {
                return 1;
            }

            if ($result['status'] == 0) {
                $this->db->query("UPDATE `platinum_message` SET `status` = '1' WHERE `id` = '$id'");
            }
        } else if ($result['from'] == $name) {
            $result['type'] = 1;
            $result['name'] = $result['to'];
            if ($result['deleteFROM'] == 1) {
                return 2;
            }
        } else {
            return 3;
        }

        return $result;
    }

    public function delete($type, $id) {
        $id = $this->db->filter($id);

        $typeField = ($type == 0) ? 'to' : 'from';
        $result = $this->db->select("SELECT `deleteTO`, `deleteFROM`  FROM `platinum_message` WHERE `id` = '$id' AND `$typeField` = '{$_SESSION['Name']}'", false);

        if (empty($result)) {
            return 0;
        }

        if ($type == 0) {
            if ($result['deleteTO'] == 0) {
                if ($result['deleteFROM'] == 1) {
                    $this->db->query("DELETE FROM `platinum_message` WHERE `id` = '$id'");
                } else {
                    $this->db->query("UPDATE `platinum_message` SET `deleteTO` = '1' WHERE `id` = '$id'");
                }
                return 1;
            } else {
                return 2;
            }
        } else {
            if ($result['deleteFROM'] == 0) {
                if ($result['deleteTO'] == 1) {
                    $this->db->query("DELETE FROM `platinum_message` WHERE `id` = '$id'");
                } else {
                    $this->db->query("UPDATE `platinum_message` SET `deleteFROM` = '1' WHERE `id` = '$id'");
                }
                return 1;
            } else {
                return 2;
            }
        }
    }
    
    public function checkNew() {
        return $this->db->select("SELECT `id`, `title`, `from` FROM `platinum_message` WHERE `to` = '{$_SESSION['Name']}' AND `deleteTO` = '0' AND `status` = '0'");
    }
}
