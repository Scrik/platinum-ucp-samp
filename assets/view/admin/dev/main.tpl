<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="assets/view/admin/dev/assets/ico/favicon.png">
        {scripts}
        <title>{title}</title>
        <link href="/assets/view/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/view/css/simple-sidebar.css" rel="stylesheet">
        <link href="/assets/view/fonts/bootstrap-glyphicons.css" rel="stylesheet">
        <!-- Bootstrap core CSS -->
        <link href="/assets/view/admin/dev/assets/css/font-awesome.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="/assets/view/admin/dev/assets/css/main.css" rel="stylesheet">

        <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
    </head>

    <body>


        <div class="container">
            <div class="col-lg-10 col-lg-offset-1">

                <!-- ===== vCard Navigation ===== -->
                <div class="row w">
                    <div class="col-md-4">
                        <img class="img-responsive" src="/assets/view/admin/dev/assets/img/avatar.png" alt="">
                        <ul class="nav nav-tabs nav-stacked" id="myTab">
                            <li><a href="/admin/dev/">Главная</a></li>
                            <li><a href="/admin/dev/settings/">Основные настройки</a></li>
                            <li><a href="/admin/dev/menu/">Настройка меню</a></li>
                            <li><a href="/admin/dev/table/">Настройка таблиц</a></li>
                            <li><a href="/admin/dev/privileges/">Настройка прав доступа</a></li>
                            <li><a href="/admin/dev/logout/">Выход из панели разработчика</a></li>
                        </ul>    			
                    </div><!-- col-md-4 -->

                    <!-- ===== vCard Content ===== -->
                    <div class="col-md-8">
                        <div class="tab-content">
                            <div class="content">{content}</div>
                        </div><!-- Tab Content -->
                    </div><!-- col-md-8 -->
                </div><!-- row w -->
            </div><!-- col-lg-6 -->
        </div><!-- /.container -->  
    </body>
</html>