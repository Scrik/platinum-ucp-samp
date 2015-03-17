<?php

class Privileges {

    private $_privileges = NULL;

    private function _load() {
        if (empty($this->_privileges)) {
            $this->_privileges = json_decode(file_get_contents('assets/config/privileges.json'), true);
        }
    }

    private function _save() {
        $this->_load();

        return file_put_contents('assets/config/privileges.json', json_encode($this->_privileges));
    }
    
    public function getPrivileges($level) {
        $this->_load();
        $array = $this->_privileges;
        
        if (array_key_exists($level, $array['levels'])) {
            foreach ($array['levels'][$level] AS $key => $value) {
                $modules[$key] = $array['modules'][$key]['name'];

                foreach($value AS $name => $res) {
                    $newArray[$key][] = array(
                        'name' => $name,
                        'type' => $key,
                        'active' => (bool) $res,
                        'title' => $array['modules'][$key]['value'][$name]
                    );
                }
                $i++;
            }
            
            $array = array(
                'modules' => $modules,
                'privileges' => $newArray,
            );
            return $array;
        } else {
            return FALSE;
        }
    }
    
    public function getLevels($level = TRUE) {
        $this->_load();

        if ($level === TRUE) {
            $array = array_keys($this->_privileges['levels']);
            $count = count($array);

            for ($i = 0; $i < $count; $i++) {
                $newArray[$i]['level'] = $array[$i];
            }
        } else {
            return $this->_privileges['levels'][$level];
        }
        return $newArray;
    }

    public function deleteLevel($level) {
        $this->_load();

        if (isset($this->_privileges['levels'][$level])) {
            unset($this->_privileges['levels'][$level]);
            return $this->_save();
        } else {
            return FALSE;
        }
    }

    public function addLevel($level) {
        $this->_load();

        if (!isset($this->_privileges['levels'][$level])) {
            if ($level > 0) {
                $this->_privileges['levels'][$level] = array();
                return $this->_save();
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    public function updateLevel($level, $array) {
        $this->_load();
        
        if (isset($this->_privileges['levels'][$level])) {
            $this->_privileges['levels'][$level] = $array;
            return $this->_save();
        } else {
            return FALSE;
        }
    }
    
    public function addModule($name, $array) {
        $this->_load();

        if (empty($this->_privileges['modules'][$name])) {
            $this->_privileges['modules'][$name] = $array;
            return $this->_save();
        } else {
            return FALSE;
        }
    }

    public function getModules() {
        $this->_load();

        return $this->_privileges['modules'];
    }

}
