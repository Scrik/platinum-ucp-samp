<div id="title">Массовая рассылка [E-Mail]</div>
<div class="alert alert-info">
    Данная функция позволяет разослать сообщение всем игрокам на E-Mail указанный в их профиле.
</div>

<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons",
        image_advtab: true,
        language: "ru"
    });
</script>
<form action="/admin/main/get/msg/email/" method="post">
    <table class="table table-bordered">
        <tr>
            <td>
                <input type="text" class="form-control" name="title" maxlength="64" placeholder="Заголовок сообщения">
            </td>
        </tr>
        <tr>
            <td>
                <textarea rows="12" name="text">Текст сообщения</textarea>
            </td>
        </tr>
        <tr>
            <td align="center">
                <button class="btn btn-success">Разослать сообщение</button>
            </td>
        </tr>
    </table>
</form>