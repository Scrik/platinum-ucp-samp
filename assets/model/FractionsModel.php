<?php

class FractionsModel extends Object {

    private $_file = 'assets/config/fractions.json';
    private $_data = NULL;

    private function _load() {
        if (empty($this->_data)) {
            $this->_data = json_decode(file_get_contents($this->_file), true);
        }
    }

    private function _save() {
        ksort($this->_data['orgList']);
        return file_put_contents($this->_file, json_encode($this->_data));
    }

    public function orgControl() {
        $this->_load();

        foreach ($this->_data['orgList'] AS $key => $value) {
            $newArray[] = array(
                'id' => $key,
                'name' => $value
            );
        }

        return $newArray;
    }

    public function addOrg($id, $name) {
        $this->_load();

        if (empty($this->_data['orgList'][$id])) {
            $this->_data['orgList'][$id] = $name;
            return $this->_save();
        } else {
            return FALSE;
        }
    }

    public function deleteOrg($id) {
        $this->_load();

        if (!empty($this->_data['orgList'][$id])) {
            unset($this->_data['orgList'][$id]);
            return $this->_save();
        } else {
            return FALSE;
        }
    }

    public function getOrg($id) {
        $this->_load();

        if (!empty($this->_data['orgList'][$id])) {
            return array(
                'id' => $id,
                'name' => $this->_data['orgList'][$id]
            );
        } else {
            return FALSE;
        }
    }

    public function saveOrg($id, $oldID, $name) {
        $this->_load();

        if (!empty($this->_data['orgList'][$oldID])) {
            if (empty($this->_data['orgList'][$id]) OR $id === $oldID) {
                unset($this->_data['orgList'][$oldID]);
                $this->_data['orgList'][$id] = $name;
                return $this->_save();
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function rankControl($id) {
        $this->_load();

        if (!empty($this->_data['rankList'][$id])) {
            foreach ($this->_data['rankList'][$id] AS $key => $value) {
                $newArray[] = array(
                    'id' => $id,
                    'rankID' => $key,
                    'name' => $value
                );
            }

            return $newArray;
        } else {
            return FALSE;
        }
    }

    public function addRank($orgID, $id, $name) {
        $this->_load();

        if (!empty($this->_data['orgList'][$orgID])) {
            if (empty($this->_data['rankList'][$orgID][$id])) {
                $this->_data['rankList'][$orgID][$id] = $name;
                $this->_sortRank();
                return $this->_save();
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function getRank($orgID, $rankID) {
        $this->_load();

        if (!empty($this->_data['orgList'][$orgID]) AND ! empty($this->_data['rankList'][$orgID][$rankID])) {
            return array(
                'orgID' => $orgID,
                'id' => $rankID,
                'name' => $this->_data['rankList'][$orgID][$rankID]
            );
        } else {
            return FALSE;
        }
    }

    public function saveRank($orgID, $rankID, $newID, $name) {
        $this->_load();

        if (!empty($this->_data['rankList'][$orgID][$rankID])) {
            if ($rankID !== $newID) {
                if (empty($this->_data['rankList'][$orgID][$newID])) {
                    unset($this->_data['rankList'][$orgID][$rankID]);
                } else {
                    return FALSE;
                }
            }

            $this->_data['rankList'][$orgID][$newID] = $name;
            $this->_sortRank();
            return $this->_save();
        } else {
            return FALSE;
        }
    }

    public function deleteRank($orgID, $rankID) {
        $this->_load();
        
        if (!empty($this->_data['rankList'][$orgID][$rankID])) {
            unset($this->_data['rankList'][$orgID][$rankID]);
            $this->_sortRank();
            return $this->_save();
        } else {
            return FALSE;
        }
    }

    private function _sortRank() {
        if (is_array($this->_data['rankList'])) {
            foreach ($this->_data['rankList'] as $key => $value) {
                ksort($this->_data['rankList'][$key]);
            }
        }
    }

}
