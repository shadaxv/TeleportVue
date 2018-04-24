<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Interns</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 4rem;
                display: inline-block;
            }

            .subtitle {
                display: inline-block;
                font-size: 1.75rem;
                font-weight: 300;
            }

            .links > a {
                color: #636b6f;
                padding: 10px 18px 3px;
                font-size: 14px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            a {
                border-bottom: 2px solid transparent;
            }

            a:hover, a:focus {
                color: #1976D2;
                border-bottom: 2px solid #1976D2;
                transition: all 0.3s;
                transition: border 1s;
            }

            h2 {
                font-weight: 300;
                display: inline-block;
                line-height: 4rem;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">

                <div class="subtitle m-b-md">
                    Wyniki wyszukiwania dla:
                </div>
                <div class="title m-b-md">
                    &quot;{{ Request::get('query') }}&quot;
                    
                </div>

                <div class="links">
                    <a href="https://github.com/shadaxv/teleport">GitHub</a>
                </div>
            </div>
        </div>


        
        <script>
            const string = '{{$result}}';
            let results = (string);
            console.log(results);
        </script>
    </body>
</html>
