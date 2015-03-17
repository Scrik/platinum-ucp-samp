<?php

class LogModule extends Object {
    public function __construct() {
        parent::__construct('DB');
    }
    
    public function get($array) {
        if (!empty($array[0])) {
            $count = count($array);
            
            for ($i = 0; $i < $count; $i++) {
                $array[$i]['text'] = $this->_typeToText($array[$i]['type']);
            }
            
            return $array;
        } else {
            return FALSE;
        }
    }
    
    private function _typeToText($type) {
        return Config::get('log_text', $type);
    }
}
