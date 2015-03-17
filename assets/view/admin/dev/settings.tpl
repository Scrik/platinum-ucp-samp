<div id="title">Основные настройки - Панель разработчика</div>
<center>
    <span class="text-muted text-center">
        <a class="text-danger">Изменения <u>не влияют</u> на работу панели разработчика.</a>
    </span>
</center>
<hr>
<form action="/admin/dev/settings/" method="post">
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#database" id="tab" aria-controls="database" role="tab" data-toggle="tab">База Данных</a></li>
            <li role="presentation"><a href="#template" id="tab" aria-controls="template" role="tab" data-toggle="tab">Шаблон</a></li>
            <li role="presentation"><a href="#general" id="tab" aria-controls="general" role="tab" data-toggle="tab">Основные настройки</a></li>
            <li role="presentation"><a href="#online" id="tab" aria-controls="online" role="tab" data-toggle="tab">Проверка на онлайн</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="database">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center>
                            <b>
                                Настройка Базы Данных
                            </b>
                        </center>
                    </div>
                    <div class="panel-body">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Сервер
                            </span>
                            <input type="text" class="form-control" name="db_host" value="{database_host}">
                        </div><br>
                        <div class="input-group">
                            <span class="input-group-addon">
                                Имя
                            </span>
                            <input type="text" class="form-control" name="db_name" value="{database_name}">
                        </div><br>
                        <div class="input-group">
                            <span class="input-group-addon">
                                Пользователь
                            </span>
                            <input type="text" class="form-control" name="db_user" value="{database_user}">
                        </div><br>
                        <div class="input-group">
                            <span class="input-group-addon">
                                Пароль
                            </span>
                            <input type="text" class="form-control" name="db_pass" value="{database_pass}">
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="template">   
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center>
                            <b>
                                Настройка шаблона
                            </b>
                        </center>
                    </div>
                    <div class="panel-body">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Имя шаблона
                            </span>
                            <input type="text" class="form-control" name="tpl_name" value="{template_name}">
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="general">    
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center>
                            <b>
                                Основные настройки
                            </b>
                        </center>
                    </div>
                    <div class="panel-body">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Техниеческие работы
                            </span>
                            <select name="general_techWork" class="form-control">
                                <option value="0">Отключены</option>
                                <option value="1" {techWork_selected}>Включены</option>
                            </select>
                        </div><br>
                        <div class="input-group">
                            <span class="input-group-addon">
                                md5 шифрование паролей
                            </span>
                            <select name="general_md5" class="form-control">
                                <option value="0">Отключено</option>
                                <option value="1" {md5_selected}>Включено</option>
                            </select>
                        </div><br>
                        <div class="input-group">
                            <span class="input-group-addon">
                                Ajax навигация
                            </span>
                            <select name="general_ajax" class="form-control">
                                <option value="0">Отключена</option>
                                <option value="1" {ajax_selected}>Включена</option>
                            </select>
                        </div><br>
                        <div class="input-group">
                            <span class="input-group-addon">
                                Смена пароля
                            </span>
                            <select name="general_changePass" class="form-control">
                                <option value="0">Запретить</option>
                                <option value="1" {changePass_selected}>Разрешить</option>
                            </select>
                        </div><br>
                        <div class="input-group">
                            <span class="input-group-addon">
                                Смена E-Mail
                            </span>
                            <select name="general_changeEmail" class="form-control">
                                <option value="0">Запретить</option>
                                <option value="1" {changeEmail_selected}>Разрешить</option>
                            </select>
                        </div><br>
                        <div class="input-group">
                            <span class="input-group-addon">
                                Восстановление пароля
                            </span>
                            <select name="general_recovery" class="form-control">
                                <option value="0">Запретить</option>
                                <option value="1" {recovery_selected}>Разрешить</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="online">
                <center>
                    <a class="text-info">При включении проверки игрок <u>не сможет</u> вносить изменения в свой аккаунт, но сможет его просматривать.</a>
                </center>
                <br>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center>
                            <b>
                                Проверка пользователя на Онлайн
                            </b>
                        </center>
                    </div>
                    <div class="panel-body">
                        <div class="input-group">
                            <span class="input-group-addon">
                                Проверка
                            </span>
                            <select name="online_enable" class="form-control">
                                <option value="0">Отключена</option>
                                <option value="1" {online_selected}>Включена</option>
                            </select>
                        </div><br>
                        <div class="input-group">
                            <span class="input-group-addon">
                                Значение поля если игрок Offline
                            </span>
                            <input type="text" class="form-control" name="online_value" value="{online_value}" placeholder="Пример: -1 (уточните у разработчика мода)">
                        </div>
                    </div>
                </div>
            </div> 
        </div>

    </div>
    <center>
        <button class="btn btn-success">Сохранить изменения</button>
    </center>
    <br>
</form>