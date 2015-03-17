<div id="title">Настройка UserBar`a</div>
<script type="text/javascript" src="/assets/view/javascript/jquery-ui.min.js"></script>
<script type="text/javascript" src="/assets/view/user/userbar/userbarGenerator.js"></script>
<script type="text/javascript" src="/assets/view/user/userbar/colorPicker/farbtastic.js"></script>
<script type="text/javascript" src="/assets/view/user/userbar/imagePicker/image-picker.min.js"></script>
<link href="/assets/view/css/userbar.css" rel="stylesheet">
<link rel="stylesheet" href="/assets/view/user/userbar/colorPicker/farbtastic.css" type="text/css" />
<link rel="stylesheet" href="/assets/view/user/userbar/imagePicker/image-picker.css" type="text/css" />
<!-- Button trigger modal -->
<div class="text-right">
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#imageSelect">
        Выбрать фоновое изображение
    </button>
</div>
<br>
<!-- Modal -->
<div class="modal fade" id="imageSelect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Выберите новое изображение из списка ниже</h4>
            </div>
            <div class="modal-body">
                <select id="images" name="images" class="image-picker masonry">
                    {body}
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<p class="text-info text-center">Вы можете перетаскивать текст по картинке. Информация на изображении будет обновлятся автоматически раз в 30 минут.</p>
<div id="image" style="z-index: 2;">{image}{position}</div><br>
<table class="table table-bordered">
    <tr>
        <th class="text-center" colspan="2">
            Добавление текста
        </th>
    </tr>
    <tr>
        <td width="100%">
            <select name="fields" class="form-control">
                {values}
            </select><br>
            <input type="number" class="form-control" id="fontSize" placeholder="Размер шрифта (px), пример: 14" min="5" max="48"><br>
            <input id="color" type="text" class="form-control" name="color" placeholder="Цвет текста (выберите цвет справа)">
        </td>
        <td><div id="colorpicker"></div></td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <button id="fieldAdd" class="btn btn-success">Добавить текст на изображение</button>
            <button id="fieldDelete" class="btn btn-danger">Удалить</button>
        </td>
    </tr>
</table>

<center>
    <button id="saveUserBar" class="btn btn-success">
        Сохранить изменения
    </button>
</center>