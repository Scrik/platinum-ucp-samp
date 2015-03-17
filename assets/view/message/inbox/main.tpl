<div id="title">Входящие сообщения</div>

<ul class="nav nav-tabs">
    <li class="active"><a>Входящие сообщения</a></li>
    <li><a href="/message/outbox/">Исходящие сообщения</a></li>
    <li><a href="/message/create/">Отправить сообщение</a></li>
</ul>

<table class="table table-bordered table-hover">
    <tr>
        <th class="text-center">
            Заголовок
        </th>
        <th class="text-center" width="1%">
            Отправитель
        </th>
        <th class="text-center">
            Дата, время
        </th>
        <th width="1%">
            Действие
        </th>
    </tr>
    {body}
</table>