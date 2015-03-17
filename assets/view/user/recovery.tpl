<div id="title">Восстановление пароля</div>
<form action="/user/recovery/" method="post">
    <table class="table table-bordered">
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-user"></i>
                    </span> 
                <input type="text" class="form-control" name="name" maxlength="24" placeholder="Введите полный NickName персонажа" required>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-envelope"></i>
                    </span>
                    <input type="email" class="form-control" name="email" placeholder="Введите E-Mail привязанный к данному персонажу" required>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        <img src="/captcha/get/">
                    </span>
                    <input type="text" class="form-control" name="captcha" placeholder="...равно?" required>
                </div>
            </td>
        </tr>
        <tr>
            <td align="center">
                <button class="btn btn-success">Восстановить пароль</button>
            </td>
        </tr>
    </table>
</form>