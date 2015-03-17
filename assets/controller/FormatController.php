<?php

class FormatController extends Object {

    public function main($table, $array, $controller = FALSE) {
        if ($controller === TRUE) {
            if (!empty($array)) {
                foreach ($array AS $key => $value) {
                    if (is_array($value)) {
                        foreach ($value AS $name => $res) {
                            $newArray[$key][$name] = $this->_format($table, $name, $res, $array);
                        }
                    } else {
                        $newArray[$key] = $this->_format($table, $key, $value, $array);
                    }
                }

                return $newArray;
            } else {
                return FALSE;
            }
        } else {
            $this->view->refresh('/user/login/');
        }
    }

    private function _format($table, $key, $value, $array) {
        $field = $this->table->findValue($table, $key);
        $tableArray = $this->table->get($table, $field, true);
        if ($tableArray[5] !== FALSE) {
            $method = "_$table";
            return $this->$method($field, $value, $array);
        } else {
            return $value;
        }
    }

    private function _account($name, $value, $array) {
        switch ($name) {
            case 'Money':
                $value = number_format($value, 0, '', ' ') . '$';
                break;
            case 'Admin':
                if ($value <= 0) {
                    $value = "Вы не администратор";
                }
                break;
            case 'Online':
                if (Config::get('online', 'enable')) {
                    if ($value == Config::get('online', 'value')) {
                        $value = "<span class=\"label label-danger\">Оффлайн</span>";
                    } else {
                        $value = "<span class=\"label label-success\">Онлайн</span>";
                    }
                } else {
                    $value = "<span class=\"label label-primary\">Информация недоступна</span>";
                }
                break;
            case 'Member':
                $org = $this->model->fractions->getOrg($value);
                $value = (empty($org)) ? 'Неизвестно' : "{$org['name']} [ID: $value]";
                break;
            case 'Rank':
                $field = $this->table->get('account', 'Member', true);
                $rank = $this->model->fractions->getRank($array['extra'][$field[2]], $value);
                $value = (empty($rank)) ? 'Неизвестно' : "{$rank['name']} [$value]";
                break;
            case 'Leader':
                if ($value > 0) {
                    $org = $this->model->fractions->getOrg($value);
                    $value = "{$org['name']} [ID: $value]";
                } else {
                    $value = 'Не лидер';
                }
                break;
        }

        return $value;
    }

}
