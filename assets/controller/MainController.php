<?php

class MainController extends Object {
    
    public function index($args = NULL) {
        $this->page($args[0]);
    }
    
    public function page($args = NULL) {
        $data = $this->model->news->getFromPage((int) $args[0]);
        
        if (empty($data)) {
            $this->view->message(array('type' => 'warning', 'text' => 'На сайт еще не добавляли новости.'));
            return FALSE;
        }
        
        $count = count($data['data']);
            
        for ($i = 0; $i < $count; $i++) {
            $data['data'][$i]['adminPanel'] = ($_SESSION['Admin'] > 0) ? $this->view->sub_load('news/adminPanel', $data['data'][$i]) : ''; 
        }
        
        $this->view->set('body', $this->view->fromArray($data['data'], $this->view->sub_load('news/one')));
        $this->view->set('page', ($args[0] == 0) ? (int) $args[0] + 1 : (int) $args[0]);
        $this->view->set('pagination', $data['pagination']);
        $this->view->load('/news/main', false, true);
    }
}