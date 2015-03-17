<div id="title">Просмотр сообщения</div>
<ul class="nav nav-tabs text-center">
    <li><a href="/message/inbox/">Входящие сообщения</a></li>
    <li><a href="/message/outbox/">Исходящие сообщения</a></li>
    <li><a href="/message/create/{name}/">{sendText}</a></li>
</ul>

<table class="table table-bordered">
    <tr>
        <th class="text-center" colspan="3">
            {title}
        </th>
    </tr>
    <tr>
        <td>
            Отправитель: <b>{from}</b>
        </td>
        <td>
            Получатель: <b>{to}</b>
        </td>
        <td>
            <b>{date} в {time}</b>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            {text}
        </td>
    </tr>
</table>