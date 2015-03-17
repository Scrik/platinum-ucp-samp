<div id="title">Авторизация - Панель разработчика</div>
<center><h2>Авторизация в панели разработчика</h2></center>
<form action="/admin/dev/login/" method="post">
    <table class ="table table-bordered table-striped">
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-user"></i>
                    </span> 
                    <input type="text" class="form-control" name="name" placeholder="Введите логин от панели разработчика" required>
                </div>
            </td>
        </tr>
        <tr>
            <td>	
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-lock"></i>
                    </span>
                    <input type="password" class="form-control" name="password" placeholder="Введите пароль от панели разработчика" required>
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
            <td>
                <center>
                    <button class="btn btn-success">Авторизоваться</button>
                </center>
            </td>
        </tr>
    </table>
</form>