<form action="/admin/dev/menu/edit/{id}/" method="post">
    <input type="hidden" name="id" value="{id}">
    <table class="table table-bordered">
        <tr>
            <th>
                <center>
                    Редактирование пункта меню
                </center>
            </th>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Заголовок
                    </span>
                    <input type="text" class="form-control" name="title" value="{title}">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Ссылка
                    </span>
                    <input type="text" class="form-control" name="href" value="{href}">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Тип меню
                    </span>
                    <select class="form-control" name="type">
                        <option value="0" {type_0}>Основное</option>
                        <option value="1" {type_1}>Дополнительное</option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Видимость
                    </span>
                    <select class="form-control" name="visible">
                        <option value="0" {visible_0}>Всем</option>
                        <option value="1" {visible_1}>Только гостям</option>
                        <option value="2" {visible_2}>Только пользователям</option>
                        <option value="3" {visible_3}>Только администраторам</option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <center>
                    <button class="btn btn-success">Сохранить</button>
                </center>
            </td>
        </tr>
    </table>
</form>