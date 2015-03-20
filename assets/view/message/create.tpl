<div id="title">Отправка сообщения</div>
<ul class="nav nav-tabs">
    <li><a href="/message/inbox/">Входящие сообщения</a></li>
    <li><a href="/message/outbox/">Исходящие сообщения</a></li>
    <li class="active"><a>Отправить сообщение</a></li>
</ul>

<script type="text/javascript">
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>

<form action="/message/create/" action="post">
    <table class="table table-bordered">
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Никнейм получателя
                    </span> 
                    <input type="text" class="form-control" name="name" value="{name}" placeholder="Введите полнный никнейм получателя" required>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Заголовок сообщения
                    </span> 
                    <input type="text" class="form-control" pattern=".{6,32}" name="title" data-toggle="tooltip" data-placement="top" title="Длина заголовка не может быть меньше 6 и больше 32 символов" maxlength="32" value="{title}" placeholder="Введите заголовок сообщения" required>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <textarea name="text" class="form-control" data-toggle="tooltip" data-placement="top" title="Длина сообщения не может быть меньше 6 и больше 2048 символов" rows="8" maxlength="2048" placeholder="Текст сообщения" style="resize: vertical;" required>{text}</textarea>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        <img src="/captcha/get/" id="captcha">
                    </span>
                    <input type="number" class="form-control" name="captcha" placeholder="...равно?" required>
                </div>
            </td>
        </tr>
        <tr>
            <td align="center">
                <button class="btn btn-success">Отправить сообщение</button>
            </td>
        </tr>
    </table>
</form>