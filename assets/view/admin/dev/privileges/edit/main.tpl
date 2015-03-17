<div id="title">Редактирование прав доступа - Панель разработчика</div>
<form action="/admin/dev/privileges/edit/{level}/" method="post">
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            {links}
        </ul>
        <div class="tab-content">
            {body}
        </div>
    </div>
    <center>
        <button class="btn btn-success">Сохранить изменения</button>
    </center>
</form>