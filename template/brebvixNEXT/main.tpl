<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{title}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        {scripts}
        <script src="/template/brebvixNEXT/plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>
        <!-- FastClick -->
        <script src='/template/brebvixNEXT/plugins/fastclick/fastclick.min.js'></script>
        <!-- AdminLTE App -->
        <script src="/template/brebvixNEXT/dist/js/app.min.js" type="text/javascript"></script>
        <link href="/template/brebvixNEXT/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="/template/brebvixNEXT/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins 
             folder instead of downloading all of them to reduce the load. -->
        <link href="/template/brebvixNEXT/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
        <link href="/template/brebvix/assets/css/simple-sidebar.css" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- Site wrapper -->
        <div class="wrapper">

            <header class="main-header">
                <a href="/template/brebvixNEXT/index2.html" class="ajax logo"><b>Platinum</b> UCP</a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            {menu_0}
                        </ul>
                    </div>
                </nav>
            </header>

            <!-- =============================================== -->

            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <!-- search form -->
                    <form action="/user/view/" method="post" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="name" class="form-control" placeholder="Поиск игроков"/>
                            <span class="input-group-btn">
                                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header">Главно меню</li>
                            {menu_1}
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- =============================================== -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <section class="content2">
                    <!-- Main content -->
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title titleContent">{title}</h3>
                        </div>
                        <div class="box-body">
                            <span class="content">
                                {content}
                            </span>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </section>
            </div>
        </div><!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>© 2014-2015</b>
            </div>
            <b>Platinum UCP SAMP</b>, разработчик <a href="http://brebvix.blogspot.com"><b>brebvix</b></a>.
        </footer>
    </div><!-- ./wrapper -->
</body>
</html>