<form action="/admin/dev/menu/add/" method="post">
    <table class="table table-bordered">
        <tr>
            <th class="active">
                <center>
                    Добавление пункта меню
                </center>
            </th>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Заголовок
                    </span> 
                    <input type="text" class="form-control" name="title" placeholder="Заголовок пункта меню">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Ссылка
                    </span> 
                    <input type="text" class="form-control" name="href" placeholder="Ссылка, куда ведет меню">
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
                        <option value="0">Основное</option>
                        <option value="1">Дополнительное</option>
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
                        <option value="0">Всем</option>
                        <option value="1">Только гостям</option>
                        <option value="2">Только пользователям</option>
                        <option value="3">Только администраторам</option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <center>
                    <button name="add" class="btn btn-success">Добавить</button>
                </center>
            </td>
        </tr>
    </table>
</form>