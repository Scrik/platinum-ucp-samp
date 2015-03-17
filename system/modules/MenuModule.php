<?php

class Menu extends Object {
    public function get() {
        $menu = $this->db->select("SELECT * FROM `platinum_menu` ORDER BY `priority`");
        $array = $this->_checkAccess($menu);
        $menu['menu_0'] = $this->view->fromArray($array['menu_0'], $this->view->sub_load('menu/one'));
        $menu['menu_1'] = $this->view->fromArray($array['menu_1'], $this->view->sub_load('menu/listOne'));
        return $menu;
    }
    
    private function _checkAccess($menu) {
        $count = count($menu);
        
        for ($i = 0; $i < $count; $i++) {
            $access = $menu[$i]['visible'];
            switch ($access) {
                case 0:
                    $newArray['menu_'.$menu[$i]['type']][] = $menu[$i];
                    break;
                case 1:
                    if (!$_SESSION['Name']) {
                        $newArray['menu_'.$menu[$i]['type']][] = $menu[$i];
                    }
                    break;
                case 2:
                    if ($_SESSION['Name']) {
                        $newArray['menu_'.$menu[$i]['type']][] = $menu[$i];
                    }
                    break;
                case 3:
                    if ($_SESSION['Admin'] > 0) {
                        $newArray['menu_'.$menu[$i]['type']][] = $menu[$i];
                    }
                    break;
            }
        }
        
        return $newArray;
    }
}