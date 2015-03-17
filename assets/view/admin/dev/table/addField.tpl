<form action="/admin/dev/table/addField/" method="post">
    <input type="hidden" name="0" value="{table}">
    <table class="table table-bordered">
        <tr>
            <th>
                <center>
                    Добавление поля в таблицу <b>{table}</b>
                </center>
            </th>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Уникальный идентификатор
                    </span> 
                <input type="text" class="form-control" name="1" placeholder="Уникальный ключ, обозначающий поле (прим. Admin)">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Описание
                    </span> 
                <input type="text" class="form-control" name="3" placeholder="Описание поля (прим. Уровень администратора)">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Значение в БД
                    </span> 
                    <select class="form-control" name="2">
                        {body}
                    </select>
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
                        <option value="1">Включено</option>
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
                        <option value="1">Включено</option>
                    </select>
                </div>
            </td>
        </tr>
    </table>
    <center>
        <button class="btn btn-success">
            Добавить поле в таблицу
        </button>
    </center>
</form>