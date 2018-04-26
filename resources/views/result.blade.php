<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Interns</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700&amp;subset=latin-ext" rel="stylesheet">
        <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('css/mdb.css') }}" rel="stylesheet" type="text/css" >

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Quicksand', sans-serif;
                font-weight: 100;
                min-height: 100vh;
                margin: 0;
            }
            .subtitle {
                font-weight: 400;
                font-size: 20px;
            }
            .full-height {
                min-height: 100vh;
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
                padding: 5px 18px 3px;
                font-size: 14px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 10px;
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
            a:focus {
                border-bottom: 2px solid transparent;
            }
            thead > tr > th {
                font-weight: 500 !IMPORTANT;
                font-size: 16px;
            }

            tbody > tr > td {
                font-weight: 400 !IMPORTANT;
                font-size: 16px;
            }

            .tr-title {
                font-weight: 600 !IMPORTANT;
                font-size: 16px !IMPORTANT;
            }
            .table::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
                background-color: #F5F5F5;
                border-radius: 10px; }
                
            .table::-webkit-scrollbar {
                width: 12px;
                background-color: #F5F5F5; }
            
            .table::-webkit-scrollbar-thumb {
                border-radius: 10px;
                -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
                background-color: #E0E0E0; }
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

                <table id="table" class="table" style='position: relative; display: block; max-height: 500px; overflow-x: auto; margin-bottom: 40px; padding-right: 6px'>
                    <thead style="border: 0;">
                        <tr>
                            <th style="position: sticky; top: 0px; background: #F5F5F5">ID</th>
                            <th style="position: sticky; top: 0px; background: #F5F5F5">Nazwa miasta</th>
                            <th style="position: sticky; top: 0px; background: #F5F5F5">Państwo</th>
                            <th style="position: sticky; top: 0px; background: #F5F5F5">Populacja</th>
                            <th style="position: sticky; top: 0px; background: #F5F5F5">Szerokość geo.</th>
                            <th style="position: sticky; top: 0px; background: #F5F5F5">Długość geo.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 0;
                        foreach($georesult as $key) {
                            $i++;
                            echo '<tr><td data-title="ID" class="tr-title">' . $i . '.</td><td data-title="Nazwa miasta">';
                            echo $key["name"];
                            echo '</td><td data-title="Państwo">';
                            echo $key["_links"]["city:country"]["name"];
                            echo '</td><td data-title="Populacja">';
                            echo $key["population"];
                            echo '</td><td data-title="Szerokość geo.">';
                            echo number_format((float)$key["location"]["latlon"]["latitude"], 4, '.', '');
                            echo '</td><td data-title="Długość geo.">';
                            echo number_format((float)$key["location"]["latlon"]["longitude"], 4, '.', '');
                            echo "</td></tr>";
                        } ?>
                        
                    </tbody>
                </table>

                <div class="links">
                    <a href="/teleport">Nowy wyszukiwanie</a>
                    <a href="https://github.com/shadaxv/teleport" target="_blank">GitHub</a>
                </div>
            </div>
        </div>     
            
    </body>
</html>
