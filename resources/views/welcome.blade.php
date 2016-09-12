<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }

            .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
            margin-bottom: 10px;
            }
            .form-signin .checkbox {
            font-weight: normal;
            }
            .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
             -moz-box-sizing: border-box;
                  box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
            }
            .form-signin .form-control:focus {
            z-index: 2;
            }
            .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            }
            .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">CTP</div>
            </div>
            <form method="POST" action="/login" class="form-signin">
                {!! csrf_field() !!}

                <div>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                </div>

            </form>
        </div>
    </body>
</html>
