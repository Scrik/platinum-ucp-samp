<?php

class FractionsController extends Object {

    public function orgControl($args) {
        switch ($args[0]) {
            case 'add':
                if ($_POST['name']) {
                    if ($this->model->fractions->addOrg($_POST['id'], $_POST['name'])) {
                        $this->view->message(array('type' => 'success', 'text' => 'Организация успешно добавлена.'));
                    } else {
                        $this->view->message(array('type' => 'danger', 'text' => 'Ошибка при добавлении организации. Возможно организации с таким ID уже существует.'));
                    }
                } else {
                    $this->view->load('/admin/main/fractions/orgControl/add', false, true);
                    $continue = FALSE;
                }
                break;
            case 'delete':
                if ($this->model->fractions->deleteOrg($args[1])) {
                    $this->view->message(array('type' => 'success', 'text' => 'Организация успешно удалена.'));
                } else {
                    $this->view->message(array('type' => 'danger', 'text' => 'Ошибка при удалении организации. Возможно организации с таким ID уже существует.'));
                }
                break;
            case 'edit':
                if ($_POST['name']) {
                    if ($this->model->fractions->saveOrg($_POST['newID'], $_POST['id'], $_POST['name'])) {
                        $this->view->message(array('type' => 'success', 'text' => 'Изменения успешно сохранены.'));
                    } else {
                        $this->view->message(array('type' => 'danger', 'text' => 'Ошибка при сохранении изменений. Возможно организация с таким ID уже существует.'));
                    }
                } else {
                    $result = $this->model->fractions->getOrg((int) $args[1]);
                    if (is_array($result)) {
                        $this->view->addArray($result);
                        $this->view->load('/admin/main/fractions/orgControl/edit', false, true);

                        $continue = FALSE;
                    } else {
                        $this->view->message(array('type' => 'danger', 'text' => 'Ошибка при загрузке данных о организации.'));
                    }
                }
                break;
        }

        if ($continue !== FALSE) {
            $array = $this->model->fractions->orgControl();
            if (!empty($array)) {
                $this->view->set('body', $this->view->fromArray($array, $this->view->sub_load('admin/main/fractions/orgControl/one')));
            } else {
                $this->view->set('body', '');
            }
            $this->view->load('/admin/main/fractions/orgControl/main', false, true);
        }
    }

    public function rankControl($args) {
        if ($args[0] == 'edit') {
            switch ($args[2]) {
                case 'add':
                    if ($_POST['name']) {
                        if ($this->model->fractions->addRank($args[1], $_POST['id'], $_POST['name'])) {
                            $this->view->message(array('type' => 'success', 'text' => 'Ранг успешно добавлен.'));
                        } else {
                            $this->view->message(array('type' => 'danger', 'text' => 'Ошибка при добавлении ранга.'));
                        }
                    } else {
                        $this->view->set('id', $args[1]);
                        $this->view->load('/admin/main/fractions/rankControl/one/add', false, true);
                        $continue = FALSE;
                    }
                    break;
                case 'edit':
                    if ($_POST['name']) {
                        if ($this->model->fractions->saveRank($args[1], $args[3], $_POST['newID'], $_POST['name'])) {
                            $this->view->message(array('type' => 'success', 'text' => 'Изменения успешно сохранены.'));
                        } else {
                            $this->view->message(array('type' => 'danger', 'text' => 'Ошибка при сохранении изменений. Возможно ранг с таким номером уже существует.'));
                        }
                    } else {
                        $result = $this->model->fractions->getRank($args[1], $args[3]);

                        if (is_array($result)) {
                            $this->view->addArray($result);
                            $this->view->load('/admin/main/fractions/rankControl/one/edit', false, true);
                        } else {
                            $this->view->message(array('type' => 'danger', 'text' => 'Ошибка при загрузке данных о ранге.'));
                        }
                    }
                    break;

                case 'delete':
                    if ($this->model->fractions->deleteRank($args[1], $args[3])) {
                        $this->view->message(array('type' => 'success', 'text' => 'Ранг успешно удалён.'));
                    } else {
                        $this->view->message(array('type' => 'danger', 'text' => 'Ошибка при удалении ранга.'));
                    }
                    break;
            }

            if ($continue !== FALSE) {
                $result = $this->model->fractions->rankControl((int) $args[1]);

                if (is_array($result)) {
                    $this->view->set('body', $this->view->fromArray($result, $this->view->sub_load('admin/main/fractions/rankControl/one/one')));
                } else {
                    $this->view->set('body', '');
                }
                $this->view->set('id', $args[1]);
                $this->view->load('/admin/main/fractions/rankControl/one/main', false, true);
            }
        } else {
            $array = $this->model->fractions->orgControl();
            if (!empty($array)) {
                $this->view->set('body', $this->view->fromArray($array, $this->view->sub_load('admin/main/fractions/rankControl/one')));
            } else {
                $this->view->set('body', '');
            }
            $this->view->load('/admin/main/fractions/rankControl/main', false, true);
        }
    }

}
