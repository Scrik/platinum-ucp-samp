<!DOCTYPE html>
<html>
    <head>
        <title>{title}</title>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="description" content="Platinum UCP SAMP by brebvix">
        <meta name="author" content="brebvix">
		{scripts}
        <link id="theme-style" rel="stylesheet" href="/template/brebvix/assets/css/styles.css">
        <link id="theme-style" rel="stylesheet" href="/template/brebvix/assets/css/bootstrap.css">
        <link href="/template/brebvix/assets/css/simple-sidebar.css" rel="stylesheet">
        <link href="/template/brebvix/assets/fonts/bootstrap-glyphicons.css" rel="stylesheet">

    </head> 

    <body>
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="navbar-brand">Platinum UCP SAMP</span>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        {menu_0}
                    </ul>
                    <span class="navbar-brand navbar-right">by <a href="http://brebvix.blogspot.com">brebvix</a>
                </div>
            </div>
        </nav>

        <div class="container sections-wrapper">
            <div class="row">
                <div class="primary col-md-8 col-sm-12 col-xs-12">
                    <section class="about section">
                        <div class="section-inner">
                            <h2 class="heading titleContent" align="center">{title}</h2>
                            {content}
                        </div>                
                    </section>
                </div>
                <div class="secondary col-md-4 col-sm-12 col-xs-12">
                    <aside class="testimonials aside section">
                        <div class="section-inner">
                            <div class="rigth">
                                <ul class="sidebar-nav">
                                    {menu_1}
                                </ul>
                            </div>
                        </div>
                    </aside>
                    <aside class="testimonials aside section">
                        <div class="section-inner">
                            <div class="rigth">
                                <form action="/user/view/" method="post">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="text-center">
                                                Поиск игрока
                                            </th>
                                        </tr>

                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="name" placeholder="Введите полный никнейм игрока" required><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">

                                                <button class="btn btn-default">Поиск</button>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>

        <footer class="footer navbar-fixed-bottom">
            <div class="container text-center">
                <small class="copyright"><b>Platinum UCP SAMP</b>, разработчик - <a href="http://brebvix.blogspot.com/" target="_blank">brebvix</a></small>
            </div>
        </footer>         
    </body>
</html> 

