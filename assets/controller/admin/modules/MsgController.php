<?php

/*
 * Platinum UCP SAMP by brebvix
 */

class MsgController extends Object {

    public function email() {
        if ($_POST['title'] AND $_POST['text']) {
            if ($this->model->admin_message->email($_POST['title'], $_POST['text'])) {
                $this->view->message(array('type' => 'success', 'text' => 'Сообщение успешно разослано всем игрокам на E-Mail.'));
            } else {
                $this->view->refresh('/admin/main/get/msg/email/', true);
            }
        } else {
            if ($_POST['ajaxLoad'] == true) {
                $this->view->refresh('/admin/main/get/msg/email/', true);
                return FALSE;
            }
            $this->view->load('/admin/main/message/email', false, true);
        }
    }
    
    public function message() {
        if ($_POST['title'] AND $_POST['text']) {
            if ($this->model->admin_message->message($_POST['title'], $_POST['text'])) {
                $this->view->message(array('type' => 'success', 'text' => 'Сообщение успешно разослано всем игрокам в ЛС.'));
            } else {
                $this->view->refresh('/admin/main/get/msg/message/', true);
            }
        } else {
            if ($_POST['ajaxLoad'] == true) {
                $this->view->refresh('/admin/main/get/msg/message/', true);
                return FALSE;
            }
            $this->view->load('/admin/main/message/message', false, true);
        }
    }

}
