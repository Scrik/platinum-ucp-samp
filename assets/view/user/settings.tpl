<form action="/user/settings/" method="post">
    <table class="table table-bordered">
        <tr>
            <th class="text-center">Настройки приватности</th>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Кто может присылать вам ЛС
                    </span> 
                    <select name="message" class="form-control">
                        <option value="1">Все</option>
                        <option value="0" {selected_message}>Только администрация</option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Кто может просматривать ваш профиль
                    </span> 
                    <select name="profile" class="form-control">
                        <option value="1">Все</option>
                        <option value="0" {selected_profile}>Только администрация</option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Статус вашего UserBar`a
                    </span> 
                    <select name="userbar" class="form-control">
                        <option value="1">Включён</option>
                        <option value="0" {selected_userbar}>Отключён</option>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td align="center">
                <button class="btn btn-success">Сохранить изменения</button>
            </td>
        </tr>
    </table>
</form>