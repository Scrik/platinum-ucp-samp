<?php

class Table {

    private $_table = NULL;

    private function _load() {
        if (!isset($this->_table)) {
            $this->_table = json_decode(file_get_contents('assets/config/table.json'), true);
        }
    }

    public function findValue($table, $array) {
        $this->_load();
        
        if (is_array($array)) {
            foreach ($array AS $key => $value) {
                foreach ($this->_table[$table]['value'] AS $name => $res) {
                    if ($res[2] == $key) {
                        unset($array[$key]);
                        $array[$name] = $value;
                    }
                }
            }
            
            return $array;
        } else {
            foreach ($this->_table[$table]['value'] AS $key => $value) {
                if ($value[2] == $array) {
                    return $key;
                    break;
                }
            }
        }
    }

    public function add($type, $name, $title) {
        $this->_load();

        if (empty($this->_table[$type])) {
            $this->_table[$type] = array(
                'type' => $type,
                'name' => $name,
                'title' => $title,
                'value' => ''
            );

            return $this->save();
        } else {
            return FALSE;
        }
    }

    public function delete($name) {
        $this->_load();
        if (!empty($this->_table[$name])) {
            unset($this->_table[$name]);
            return $this->save();
        } else {
            return FALSE;
        }
    }

    public function all($value = TRUE) {
        $this->_load();

        if ($value) {
            return $this->_table;
        } else {
            $table = $this->_table;
            if (is_array($table)) {
                foreach ($table AS $key => $value) {
                    unset($table[$key]['value']);
                }

                return $table;
            } else {
                return FALSE;
            }
        }
    }

    public function names() {
        $this->_load();

        foreach ($this->_table AS $value) {
            $newArray[] = $value['name'];
        }

        return $newArray;
    }

    public function get($name, $key = FALSE, $value = FALSE, $table = TRUE) {
        $this->_load();
        if (is_array($key)) {
            $count = count($key);

            for ($i = 0; $i < $count; $i++) {
                if ($value) {
                    $newArray[$this->_table[$name]['value'][$key[$i]][1]] = $this->_table[$name]['value'][$key[$i]][2];
                } else {
                    $newArray[$this->_table[$name]['value'][$key[$i]][1]] = $this->_table[$name]['value'][$key[$i]];
                }
            }
            if ($table) {
                $newArray['table'] = $this->_table[$name]['name'];
            }
            return $newArray;
        } else {
            return ($key !== FALSE) ? $this->_table[$name]['value'][$key] : $this->_table[$name];
        }
    }

    public function update($table, $field, $array) {
        $this->_load();
        $this->_table[$table]['value'][$field] = $array;
        return $this->save();
    }

    public function save() {
        $this->_load();
        return file_put_contents('assets/config/table.json', json_encode($this->_table));
    }

    public function deleteField($table, $field) {
        $this->_load();

        if (!empty($this->_table[$table]['value'][$field])) {
            unset($this->_table[$table]['value'][$field]);
            return $this->save();
        } else {
            return FALSE;
        }
    }

    public function fromArray($array) {
        foreach ($array as $value) {
            $query .= $value . '`, `';
        }
        $query = sprintf('`%s`', trim($query, '` ,`'));

        return $query;
    }

}
