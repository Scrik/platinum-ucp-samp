<?php

class UserbarModel extends Object {

    private static $_settings;
    private static $_userbar;

    private function _load($name) {
        if (empty(self::$_settings)) {
            $name = $this->db->filter($name);
            $array = $this->db->select("SELECT `settings`, `userbar` FROM `platinum_users` WHERE `Name` = '$name'", false);
            if (!empty($array)) {
                self::$_settings = json_decode(urldecode($array['settings']), true);
                self::$_userbar = json_decode(urldecode($array['userbar']), true);
            }
        }
    }

    public function isAllowed($name) {
        $this->_load($name);

        if (self::$_settings['userbar']) {
            if (!empty(self::$_userbar)) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function getInfo($name) {
        $this->_load($name);

        $array = self::$_userbar;
        $name = $this->db->filter($name);

        foreach ($array['data'] AS $key => $value) {
            $table[] = $value['name'];
        }
        $tableAll = $this->table->get('account', $table);
        $table = $this->table->get('account', $table, true);
        //$table = $this->db->filter($table);
        $tbl = $this->table->get('account', 'Name', true);
        $tblName = $table['table'];
        unset($table['table']);
        $query = $this->table->fromArray($table);
        $arrayQuery = $this->db->select("SELECT $query FROM `$tblName` WHERE `{$tbl[2]}` = '$name'", false);
        $format = $this->controller->load('format');
        $arrayQuery = $format->main('account', $arrayQuery, true);
        foreach ($arrayQuery AS $key => $value) {
            $name = $this->table->findValue('account', $key);
            $newArray[$name] = array('name' => $name, 'title' => $tableAll[$name]['3'], 'value' => $value);
        }
        $array['text'] = $newArray;
        return $array;
    }

}
