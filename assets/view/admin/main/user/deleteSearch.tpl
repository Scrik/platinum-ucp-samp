<div id="title">Поиск игрока</div>

<form action="/admin/main/get/user/delete/" method="post">
    <table class="table table-bordered">
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Никнейм
                    </span> 
                    <input type="text" class="form-control" name="name" placeholder="Введите полный никнейм игрока, которого желаете удалить">
                </div>
            </td>
        </tr>
        <tr>
            <td align="center">
                <button class="btn btn-danger">Удалить игрока из Базы Данных</button>
            </td>
        </tr>
    </table>
</form>