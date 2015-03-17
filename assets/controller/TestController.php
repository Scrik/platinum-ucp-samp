<?php

class TestController extends Object {
    
    public function index() {
        echo '<div class="title">Заголовок :)</div>Текст';
    }
    
    public function brbvxAction($args = NULL) {
        echo 'Hello World!</br><pre>';
        var_dump($args);
    }
    
    public function into($args) {
        //var_dump($_POST);
        //echo 123457909;
        $this->view->load('/test/main',false,true);
    }
    
}
