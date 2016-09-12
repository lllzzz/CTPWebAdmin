<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
        <meta name="description" content="">
        <title>CTP</title>
        <!-- Bootstrap core CSS -->
        <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
        <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <style>
        body {
            padding-top: 70px;
        }
        </style>
    </head>
    <body>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">CTP</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li id='order'><a href="/order">订单</a></li>
                        <li id='orderLog'><a href="/orderLog">订单日志</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        {{-- <li>{{$_SESSION['db']}}</li> --}}
                        <li @if ($env == 'online') class="active" @endif><a href="#" data-env='online' class='envBtn'>实盘</a></li>
                        <li @if ($env == 'dev') class="active" @endif><a href="#" data-env='dev' class='envBtn'>仿真</a></li>
                        <li><a href="/logout">Sign Out</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <div class="container">
            @yield('content')
        </div> <!-- /container -->
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script>
            $('#@yield("action")').addClass('active');
            $('.envBtn').click(function() {
                var env = $(this).data('env');
                $.get('/changeEnv?env=' + env, function() {
                    location.reload();
                })
            })
        </script>
    </body>
</html>
