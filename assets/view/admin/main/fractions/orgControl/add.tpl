<form action="/admin/main/get/fractions/orgControl/add/" method="post">
    <table class="table table-bordered">
        <tr>
            <th class="text-center">
                Добавление организации
            </th>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        ID организации
                    </span> 
                    <input type="number" name="id" class="form-control" min="0" required>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Название организации
                    </span> 
                    <input type="text" name="name" class="form-control" required>
                </div>
            </td>
        </tr>
        <tr>
            <td align="center">
                <button class="btn btn-success">Добавить организацию</button>
            </td>
        </tr>
    </table>
</form>