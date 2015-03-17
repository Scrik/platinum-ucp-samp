<form action="/user/changePassword/" method="post">
    <table class="table table-bordered">
        <tr>
            <th class="text-center">
                Смена пароля
            </th>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Текущий пароль
                    </span>
                    <input type="password" name="oldPass" class="form-control" placeholder="Введите текущий пароль" required>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Новый пароль
                    </span>
                    <input type="password" name="newPass" class="form-control" placeholder="Введите новый пароль" pattern=".{6,16}" data-toggle="tooltip" data-placement="top" title="Длина нового пароля не может быть меньше 6 и больше 16 символов"  maxlength="16" required>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Повторите новый пароль
                    </span>
                    <input type="password" name="reNewPass" class="form-control" placeholder="Повторите новый пароль" pattern=".{6,16}" data-toggle="tooltip" data-placement="top" title="Длина нового пароля не может быть меньше 6 и больше 16 символов"  maxlength="16" required>
                </div>
            </td>
        </tr>
        <tr>
            <td align="center">
                <button class="btn btn-success">Сменить пароль</button>
            </td>
        </tr>
    </table>
</form>