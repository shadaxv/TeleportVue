<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Interns</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,600" rel="stylesheet" type="text/css">

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
            }

            .links > a {
                color: #636b6f;
                padding: 10px 25px 3px;
                font-size: 14px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            a:hover, a:focus {
                color: #1976D2;
                border-bottom: 3px solid #1976D2;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    Teleport Search App
                </div>

                <section class="" style="margin: 20px auto">
                    <form action="">
                        <label for="query" style="color: black; font-weight: 400; font-size: 1.25rem; display: inline-block; margin-bottom: 6px;">Wpisz poszukiwane miasto:</label>
                        <br>
                        <input type="text" name="query" placeholder="Wroclaw">
                        <button type="submit">Wyszukaj!</button>
                    </form>
                </section>

                <div class="links">
                    <a href="https://github.com/shadaxv/teleport">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>
