<?php

/*
 * Platinum UCP SAMP by brebvix
 */

class Admin_userModel extends Object {

    public function getInfo($name, $edit = FALSE) {
        $name = $this->db->filter($name);

        $table = $this->table->get('account');
        if (!empty($table['value']['Password'])) {
            unset($table['value']['Password']);
        }

        foreach ($table['value'] AS $value) {
            $selectData[] = $value[2];
            $selectDataInfo[$value[2]] = $value[3];
        }
        if (empty($selectData)) {
            return FALSE;
        }

        $query = $this->table->fromArray($selectData);

        $result = $this->db->select("SELECT $query FROM {$table['name']} WHERE `{$table['value']['Name'][2]}` = '$name'", false);

        if (!is_array($result)) {
            return FALSE;
        }

        if ($edit) {
            foreach ($selectDataInfo AS $key => $value) {
                $newArray[] = array(
                    'title' => $value,
                    'name' => $key,
                    'value' => $result[$key],
                    'type' => (is_numeric($result[$key])) ? 'number' : 'text'
                );
            }
        } else {
            $format = $this->controller->load('format');
            $array = $format->main('account', $result, true);

            foreach ($selectDataInfo AS $key => $value) {
                $newArray[] = array('title' => $value, 'value' => $array[$key]);
            }
        }
        return $newArray;
    }

    public function saveStats($name, $array) {
        $name = $this->db->filter($name);
        $array = $this->db->filter($array, true);

        if (Config::get('online', 'enable') == 1) {
            if (!$this->model->user->isOnline($name)) {
                return FALSE;
            }
        }

        foreach ($array AS $key => $value) {
            if ($value == NULL) {
                unset($array[$key]);
            } else {
                $check = $this->table->findValue('account', $key);

                if (empty($check)) {
                    return FALSE;
                } else {
                    $newArray[] = $key;
                }
            }
        }
        $count = count($newArray);

        for ($i = 0; $i < $count; $i++) {
            if ($i != ($count - 1)) {
                $query .= "`{$newArray[$i]}` = '{$array[$newArray[$i]]}', ";
            } else {
                $query .= "`{$newArray[$i]}` = '{$array[$newArray[$i]]}'";
            }
        }

        $table = $this->table->get('account', array('Name'), true);
        return $this->db->query("UPDATE `{$table['table']}` SET $query WHERE `{$table['Name']}` = '$name'");
    }

    public function delete($name) {
        $name = $this->db->filter($name);

        $table = $this->table->get('account', array('Name'), true);
        $check1 = $this->db->select("SELECT `{$table['Name']}` FROM `{$table['table']}` WHERE `{$table['Name']}` = '$name'", false);

        if (empty($check1[$table['Name']])) {
            return FALSE;
        }

        if (Config::get('online', 'enable') == 1) {
            if (!$this->model->user->isOnline($name)) {
                return FALSE;
            }
        }

        $check2 = $this->db->select("SELECT `id` FROM `platinum_users` WHERE `Name` = '$name'", false);

        $result = $this->db->query("DELETE FROM `{$table['table']}` WHERE `{$table['Name']}` = '$name'");
        if ($result) {
            if (!empty($check2['id'])) {
                return $this->db->query("DELETE FROM `platinum_users` WHERE `Name` = '$name'");
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

}
