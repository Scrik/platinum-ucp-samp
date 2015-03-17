<?php

class DevModel extends Object {

    public function getSettings() {
        $file = 'assets/config/main.ini';
        return parse_ini_file($file, true);
    }

    public function saveSettings($array) {
        $oldArray = $this->getSettings();

        $newArray = array(
            'database' => array(
                'host' => $array['db_host'],
                'name' => $array['db_name'],
                'user' => $array['db_user'],
                'pass' => $array['db_pass'],
            ),
            'template' => array(
                'name' => $array['tpl_name'],
            ),
            'general' => array(
                'md5' => (int) $array['general_md5'],
                'ajax' => (int) $array['general_ajax'],
                'changePass' => (int) $array['general_changePass'],
                'changeEmail' => (int) $array['general_changeEmail'],
                'recovery' => (int) $array['general_recovery'],
                'techWork' => (int) $array['general_techWork']),
            'online' => array(
                'enable' => (int) $array['online_enable'],
                'value' => $array['online_value']
            ),
        );

        if ($newArray['online']['enable']) {
            $table = $this->table->get('account', 'Online');
            if (empty($table)) {
                return FALSE;
            }
        }

        return Config::toIni('assets/config/main.ini', array_merge($oldArray, $newArray));
    }

    public function getMenu() {
        return $this->db->select("SELECT * FROM `platinum_menu` ORDER BY `type`, `priority`");
    }

    public function getOneMenu($id) {
        $id = $this->db->filter($id);
        $query = "SELECT * FROM `platinum_menu` WHERE `id` = '$id'";
        return $this->db->select($query, false);
    }

    public function saveMenu($array) {
        $array = $this->db->filter($array);
        $select = $this->db->select("SELECT `type`, `priority` FROM `platinum_menu` WHERE `id` = '{$array['id']}'", false);
        if ($array['type'] == $select['type']) {
            $query = "UPDATE `platinum_menu` SET `title` = '{$array['title']}', `href` = '{$array['href']}', `type` = '{$array['type']}', `visible` = '{$array['visible']}' WHERE `id` = '{$array['id']}'";
            return $this->db->query($query);
        } else {
            $priority = $this->db->select("SELECT `priority` FROM `platinum_menu` WHERE `type` = '{$array['type']}' ORDER BY `id` DESC LIMIT 1", false);
            $priority = $priority['priority'] + 1;
            $query = "UPDATE `platinum_menu` SET `title` = '{$array['title']}', `href` = '{$array['href']}', `type` = '{$array['type']}', `visible` = '{$array['visible']}', `priority` = '$priority' WHERE `id` = '{$array['id']}'";
            return $this->db->query($query);
        }
    }

    public function deleteMenu($id) {
        $id = $this->db->filter($id);
        $array = $this->db->query("SELECT `type` FROM `platinum_menu` WHERE `id` = '$id'", false);
        if (!empty($array)) {
            $this->db->query("DELETE FROM `platinum_menu` WHERE `id` = '$id'");
            $this->db->query("UPDATE `platinum_menu` SET `priority` = (`priority` - 1) WHERE `id` > '$id' AND `type` = '{$array['type']}'");
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addMenu($array) {
        $array = $this->db->filter($array);
        $priority = $this->db->select("SELECT `priority` FROM `platinum_menu` WHERE `type` = '{$array['type']}' ORDER BY `id` DESC LIMIT 1", false);

        $priority = $priority['priority'] + 1;
        $query = "INSERT INTO `platinum_menu`(`title`, `href`, `visible`, `type`, `priority`) VALUES('{$array['title']}', '{$array['href']}', '{$array['visible']}', '{$array['type']}', '{$priority}')";
        return $this->db->query($query);
    }

    public function priorityUp($id) {
        $id = $this->db->filter($id);
        $priority = $this->db->select("SELECT `type`, `priority` FROM `platinum_menu` WHERE `id` = '$id'", false);
        $newPriority = $priority['priority'] - 1;
        
        if ($priority['priority'] > 0) {
            $this->db->query("UPDATE `platinum_menu` SET `priority` = '{$priority['priority']}' WHERE `type` = '{$priority['type']}' AND `priority` = '$newPriority'");
            $this->db->query("UPDATE `platinum_menu` SET `priority` = '$newPriority' WHERE `id` = '$id'");

            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function priorityDown($id) {
        $id = $this->db->filter($id);
        $priority = $this->db->select("SELECT `type`, `priority` FROM `platinum_menu` WHERE `id` = '$id'", false);
        $lastPriority = $this->db->select("SELECT `priority` FROM `platinum_menu` WHERE `type` = '{$priority['type']}' ORDER BY `priority` DESC LIMIT 1", false);
        $newPriority = $priority['priority'] + 1;

        if ($priority['priority'] < $lastPriority['priority']) {
            $this->db->query("UPDATE `platinum_menu` SET `priority` = '{$priority['priority']}' WHERE `type` = '{$priority['type']}' AND `priority` = '$newPriority'");
            $this->db->query("UPDATE `platinum_menu` SET `priority` = '$newPriority' WHERE `id` = '$id'");

            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function allTables() {
        $array = $this->db->select('SHOW TABLES');

        $count = count($array);
        $dbName = Config::get('database', 'name');
        $table = $this->table->names();

        for ($i = 0; $i < $count; $i++) {
            $newArray[$i]['name'] = $array[$i]['Tables_in_' . $dbName];
            if (!empty($table)) {
                $key = array_search($newArray[$i]['name'], $table);
                if (is_int($key)) {
                    unset($newArray[$i]);
                }
            }
        }
        rsort($newArray);

        return $newArray;
    }

    public function addTable($array) {
        $array = $this->db->filter($array);
        return $this->table->add($array['type'], $array['name'], $array['title']);
    }

    public function getTable() {
        return $this->table->all(false);
    }

    public function deleteTable($name) {
        return $this->table->delete($name);
    }

    public function tableInfo($name) {
        return $this->table->get($name);
    }

    public function getField($table, $key) {
        return $this->table->get($table, $key);
    }

    public function saveField($table, $field, $array) {
        $table = $this->db->filter($table);
        $field = $this->db->filter($field);
        $array = $this->db->filter($array);

        $newArray = array(
            $table,
            $array[1],
            $array[2],
            $array[3],
            (bool) $array[4],
            (bool) $array[5]
        );

        return $this->table->update($table, $field, $newArray);
    }

    public function deleteField($table, $field) {
        return $this->table->deleteField($table, $field);
    }

    public function getColumns($table, $name = NULL) {
        $table = $this->db->filter($table);
        $array = $this->table->get($table);
        $array = $this->db->select("SHOW COLUMNS FROM `{$array['name']}`");

        if (!empty($array)) {
            foreach ($array AS $key => $value) {
                if ($name == $value['Field']) {
                    $newArray[] = array(
                        $value['Field'],
                        'selected' => 'selected',
                    );
                } else {
                    $newArray[] = array($value['Field']);
                }
            }

            return $newArray;
        } else {
            return FALSE;
        }
    }

    public function addField($array) {
        $array = $this->db->filter($array);
        $array[4] = (bool) $array[4];
        $array[5] = (bool) $array[5];
        $check = $this->table->get($array[0], $array[1]);

        if (empty($check)) {
            return $this->table->update($array[0], $array[1], $array);
        } else {
            return FALSE;
        }
    }

    public function addPrivileges($level) {
        if ($this->privileges->addLevel($level)) {
            return $this->privileges->updateLevel($level, $this->_installPrivileges($this->privileges->getLevels($level)));
        } else {
            return FALSE;
        }
    }

    public function getLevels() {
        return $this->privileges->getLevels();
    }

    public function deletePrivileges($level) {
        return $this->privileges->deleteLevel($level);
    }

    private function _installPrivileges($array) {
        $modules = $this->privileges->getModules();
        foreach ($modules AS $key => $value) {
            if (empty($array[$key])) {
                $array[$key] = array();
            }

            foreach ($value['value'] AS $name => $res) {
                if (empty($array[$key][$name])) {
                    $array[$key][$name] = FALSE;
                }
            }
        }
        return $array;
    }

    public function getPrivileges($level) {
        $check = $this->privileges->getLevels($level);
        $newArray = $this->_installPrivileges($check);
        if ($check == $newArray) {
            return $this->privileges->getPrivileges($level);
        } else {
            if (!empty($newArray)) {
                $this->privileges->updateLevel($level, $newArray);
                return $this->privileges->getPrivileges($level);
            } else {
                return FALSE;
            }
        }
    }

    public function savePrivileges($level, $array) {
        $modules = $this->privileges->getModules();

        foreach ($array AS $key => $value) {
            list($name, $res) = explode('_', $key);
            if (!empty($res)) {
                $newArray[$name][$res] = (bool) $value;
            }
        }

        return $this->privileges->updateLevel($level, $newArray);
    }

}
