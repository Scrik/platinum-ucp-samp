<div id="title">Просмотр профиля - {Name}</div>

<div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#account" id="tab" aria-controls="account" role="tab" data-toggle="tab">Статистика</a></li>
        <li role="presentation"><a href="#userbar" id="tab" aria-controls="userbar" role="tab" data-toggle="tab">UserBar</a></li>
            {actions}
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
                            {body}
                        </table>
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
        <div role="tabpanel" class="tab-pane" id="actions">
            <table class="table table-bordered">
                <tr>
                    <td>
                        <ul class="sidebar-nav">
                            <li><a href="/message/create/{Name}/">Отправить сообщение</a></li>
                        </ul>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>