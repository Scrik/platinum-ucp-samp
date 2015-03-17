<div id="title">Регистрация</div>

<div class="text-info text-center">Данная регистрация была сделана исключительно для демонстрации Platinum UCP, и не входит в комплект при продаже.</div>

<form action="/user/register/" method="post">
    <table class="table table-bordered">
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-user"></i>
                    </span> 
                    <input type="text" name="name" class="form-control" .{4,24} placeholder="Введите никнейм персонажа" required>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-envelope"></i>
                    </span> 
                    <input type="email" name="email" class="form-control" placeholder="Введите E-Mail персонажа" required>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-lock"></i>
                    </span> 
                    <input type="password" class="form-control" name="password" .{4,24} placeholder="Введите пароль персонажа" required>
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
                <button class="btn btn-success">Зарегистрироваться</button>
            </td>
        </tr>
    </table>
</form>