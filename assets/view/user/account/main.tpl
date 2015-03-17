<div id="title">Личный кабинет - {Name}</div>

<div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#account" id="tab" aria-controls="account" role="tab" data-toggle="tab">Аккаунт</a></li>
        <li role="presentation"><a href="#settings" id="tab" aria-controls="settings" role="tab" data-toggle="tab">Настройки</a></li>
        <li role="presentation"><a href="#userbar" id="tab" aria-controls="userbar" role="tab" data-toggle="tab">UserBar</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="account">   
            <table class="table table-bordered table-responsive">
                <tr>
                    <td rowspan="2" width="5%">
                        <img src="/assets/view/images/skins/Skin_{Skin}.png" title="SkinID: {Skin}">
                    </td>
                </tr>
                <tr>
                    <td>
                        <table class="table table-responsive table-striped">
                            <tr>
                                <td>
                                    Имя персонажа
                                </td>
                                <td>
                                    {Name}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Электронная почта
                                </td>
                                <td>
                                    {Email}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Уровень администратора
                                </td>
                                <td>
                                    {Admin}
                                </td>
                            </tr>
                            {body}
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane" id="settings">
            <table class="table table-bordered">
                <tr>
                    <td>
                        <ul class="sidebar-nav">
                            <li><a href="/user/settings/" id="gui">Настройки приватности</a></li>
                            <li><a href="/user/changePassword/" id="gui">Смена пароля</a></li>
                            <li><a href="/user/changeEmail/" id="gui">Смена E-Mail</a></li>
                            <li><a href="/user/userbar/" id="noAjax">Настройки UserBar</a></li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane" id="userbar">
            <table class="table table-bordered">
                <tr>
                    <td align="center">
                        <img src="/userbar/get/{Name}/"
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                Ссылка на UserBar
                            </span> 
                            <input type="text" class="form-control" readonly="readonly" value="http://{host}/userbar/get/{Name}/">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                HTML код
                            </span> 
                            <input type="text" class="form-control" readonly="readonly" value='<img src="http://{host}/userbar/get/{Name}/" title="{Name}">'>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>