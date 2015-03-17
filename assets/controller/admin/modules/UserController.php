<?php

/*
 * Platinum UCP SAMP by brebvix
 */

class UserController extends Object {

    public function view($args) {
        if (empty($args[0])) {
            if ($_POST['name']) {
                $this->view->refresh('/admin/main/get/user/view/' . $_POST['name'] . '/');
            } else {
                $this->view->load('/admin/main/user/view/search', false, true);
            }

            return FALSE;
        }

        $data = $this->model->admin_user->getInfo($args[0]);

        if (!is_array($data)) {
            $this->view->message(array('type' => 'danger', 'text' => 'Ошибка при загрузке статистики, попробуйте позже.'));
        }

        $this->view->set('name', $args[0]);
        $this->view->set('body', $this->view->fromArray($data, $this->view->sub_load('admin/main/user/view/one')));
        $this->view->load('/admin/main/user/view/main', false, true);
    }

    public function edit($args) {
        if (empty($args[0])) {
            if ($_POST['name']) {
                $this->view->refresh('/admin/main/get/user/edit/' . $_POST['name'] . '/');
            } else {
                $this->view->load('/admin/main/user/edit/search', false, true);
            }

            return FALSE;
        }

        if (count($_POST) > 1) {
            if ($this->model->admin_user->saveStats($args[0], $_POST)) {
                $this->view->message(array('type' => 'success', 'text' => 'Изменения успешно сохранены.'));
            } else {
                $this->view->message(array('type' => 'danger', 'text' => 'Ошибка сохранения изменений, возможно игрок сейчас на сервере.'));
            }
        }

        $data = $this->model->admin_user->getInfo($args[0], true);

        if (!is_array($data)) {
            $this->view->message(array('type' => 'danger', 'text' => 'Ошибка при загрузке статистики, попробуйте позже.'));
        }

        $this->view->set('name', $args[0]);
        $this->view->set('body', $this->view->fromArray($data, $this->view->sub_load('admin/main/user/edit/one')));
        $this->view->load('/admin/main/user/edit/main', false, true);
    }

    public function delete($args) {
        if (empty($args[0])) {
            if ($_POST['name']) {
                $this->view->refresh('/admin/main/get/user/delete/' . $_POST['name'] . '/');
            } else {
                $this->view->load('/admin/main/user/deleteSearch', false, true);
            }

            return FALSE;
        }
        
        if ($this->model->admin_user->delete($args[0])) {
            $this->view->message(array('type' => 'success', 'text' => 'Игрок успешно удалён.'));
        } else {
            $this->view->message(array('type' => 'danger', 'text' => 'Ошибка удаления игрока, возможно он сейчас на сервере.'));
        }
    }

}
