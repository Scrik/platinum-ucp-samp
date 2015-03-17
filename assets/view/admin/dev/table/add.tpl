<form action="/admin/dev/table/add/" method="post">
    <table class="table table-bordered">
        <tr>
            <th>
                <center>
                    Добавление таблицы
                </center>
            </th>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Описание
                    </span> 
                <input type="text" class="form-control" name="title" placeholder="Описание таблицы (прим. Пользователи)">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Таблица
                    </span> 
                    <select name="name" class="form-control">
                        {body}
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Тип таблицы
                    </span> 
                    <select name="type" class="form-control">
                        <option value="account">Аккаунты</option>
                        <option value="bussiness">Бизнессы</option>
                        <option value="house">Дома</option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <center>
                    <button class="btn btn-success">Добавить таблицу</button>
                </center>
            </td>
        </tr>
    </table>
</form>