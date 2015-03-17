<form action="/admin/dev/table/editField/{0}/{1}/" method="post">
    <table class="table table-bordered">
        <tr>
            <th>
                <center>
                    Редактирование поля
                </center>
            </th>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Уникальный идентификатор
                    </span> 
                    <input type="text" class="form-control" name="1" placeholder="Уникальный идентификатор" value="{1}">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Описание
                    </span> 
                    <input type="text" class="form-control" name="3" placeholder="Описание поля" value="{3}">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Поле в БД
                    </span> 
                    <input type="text" class="form-control" name="2" placeholder="Имя поля в Базе Данных" value="{2}">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Вывод в аккаунте
                    </span>
                    <select name="4" class="form-control">
                        <option value="0">Отключено</option>>
                        <option value="1" {selected}>Включено</option>
                    </select>
                </div>
                <center>
                    <a class="text-danger">Применимо только к таблице <b>account</b>!</a>
                </center>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Особое форматирование
                    </span>
                    <select name="5" class="form-control">
                        <option value="0">Отключено</option>>
                        <option value="1" {form_selected}>Включено</option>
                    </select>
                </div>
            </td>
        </tr>
    </table>
    <center>
        <button class="btn btn-success">
            Сохранить изменения
        </button>
    </center>
</form>