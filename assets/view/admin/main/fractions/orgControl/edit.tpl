<form action="/admin/main/get/fractions/orgControl/edit/" method="post">
    <table class="table table-bordered">
        <tr>
            <th class="text-center">
                Редактирование организации
            </th>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        ID организации
                    </span> 
                    <input type="hidden" name="id" value="{id}">
                    <input type="number" name="newID" class="form-control" min="0" value="{id}" required>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Название организации
                    </span> 
                    <input type="text" name="name" class="form-control" value="{name}"  required>
                </div>
            </td>
        </tr>
        <tr>
            <td align="center">
                <button class="btn btn-success">Сохранить изменения</button>
            </td>
        </tr>
    </table>
</form>