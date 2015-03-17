<form action="/user/changeEmail/" method="post">
    <table class="table table-bordered">
        <tr>
            <th class="text-center">
                Смена E-Mail
            </th>
        </tr>
        <tr>
            <td align="center">
                <span class="text-info">
                    Для смены E-Mail вам нужно будет подтвердить старый и новый E-Mail адреса.
                </span>
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <span class="input-group-addon">
                        Новый E-Mail
                    </span>
                    <input type="email" name="email" class="form-control" placeholder="Введите новый E-Mail адрес" required>
                </div>
            </td>
        </tr>
        <tr>
            <td align="center">
                <button class="btn btn-success">Сменить E-Mail</button>
            </td>
        </tr>
    </table>
</form>