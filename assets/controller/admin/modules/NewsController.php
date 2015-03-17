<?php

/*
 * Platinum UCP SAMP by brebvix
 */

class NewsController extends Object {

    public function create() {
        if ($_POST['title'] AND $_POST['text']) {
            if ($this->model->admin_news->create(array('title' => $_POST['title'], 'text' => $_POST['text']))) {
                $this->view->refresh('/');
            } else {
                $this->view->refresh('/admin/main/get/news/create/', true);
            }
        } else {
            if ($_POST['ajaxLoad'] == true) {
                $this->view->refresh('/admin/main/get/news/create/', true);
                return FALSE;
            }

            $this->view->load('/admin/main/news/create', false, true);
        }
    }

    public function edit($args) {
        if (!is_numeric($args[0])) {
            $this->view->message(array('type' => 'warning', 'text' => '<div id="title">Редактирование новости</div>Для редактирование новости выберите необходимую новость на главной странице и нажмите кнопку "Редактировать", под заголовком.'));
            return FALSE;
        }

        if ($_POST['ajaxLoad'] == true) {
            $this->view->refresh('/admin/main/get/news/edit/' . (int) $args[0] . '/', true);
            return FALSE;
        }

        if ($_POST['title'] AND $_POST['text']) {
            if ($this->model->admin_news->saveEdit((int) $args[0], $_POST['title'], $_POST['text'])) {
                $this->view->refresh('/');
            } else {
                $this->view->message(array('type' => 'danger', 'text' => 'Ошибка при сохранении новости, попробуйте позже.'));
            }
        } else {
            $data = $this->model->admin_news->getEdit((int) $args[0]);

            if (is_array($data)) {
                $data['id'] = (int) $args[0];
                $this->view->addArray($data);
                $this->view->load('/admin/main/news/edit', false, true);
            } else {
                $this->view->message(array('type' => 'danger', 'text' => 'Новость с таким ID не найдена, вернитесь на главную и выберите нужную новость.'));
            }
        }
    }

    public function delete($args) {
        if (!is_numeric($args[0])) {
            $this->view->message(array('type' => 'warning', 'text' => '<div id="title">Удаление новости</div> Для удаления новости выберите необходимую новость на главной странице и нажмите кнопку "Удалить", под заголовком.'));
            return FALSE;
        }
        
        if ($this->model->admin_news->delete((int) $args[0])) {
            $this->view->refresh('/');
        } else {
            $this->view->message(array('type' => 'danger', 'text' => 'Ошибка при удалении новости, попробуйте позже.'));
        }
    }

}
