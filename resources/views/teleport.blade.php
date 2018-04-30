<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Teleport App - Search</title>

        <link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,500,700&amp;subset=latin-ext" rel="stylesheet">
        <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('css/mdb.css') }}" rel="stylesheet" type="text/css" >
        
        <link rel="apple-touch-icon" sizes="180x180" href="{{{ asset('favicon/apple-touch-icon.png') }}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{{ asset('favicon/favicon-32x32.png') }}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{{ asset('favicon/favicon-16x16.png') }}}">
        <link rel="manifest" href="{{{ asset('favicon/manifest.json') }}}">
        <link rel="mask-icon" href="{{{ asset('favicon/safari-pinned-tab.svg') }}}" color="#fff">
        <link rel="shortcut icon" href="{{{ asset('favicon/favicon.ico') }}}">
        <meta name="msapplication-config" content="{{{ asset('favicon/browserconfig.xml') }}}">
        <meta name="theme-color" content="#222">
        <meta name="msapplication-navbutton-color" content="#222">
        <meta name="apple-mobile-web-app-status-bar-style" content="#222">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
                margin-top: 60px;
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
            a:focus:hover {
                border-bottom: 2px solid #1976D2;
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
            .table::-webkit-scrollbar-track, .suggestions::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
                background-color: #F5F5F5;
                border-radius: 10px; }
                
            .table::-webkit-scrollbar, .suggestions::-webkit-scrollbar  {
                width: 12px;
                height: 12px;
                background-color: #F5F5F5; }
            
            .table::-webkit-scrollbar-thumb, .suggestions::-webkit-scrollbar-thumb  {
                border-radius: 10px;
                -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
                background-color: #E0E0E0; }
            .suggestions::-webkit-scrollbar-thumb, .suggestions::-webkit-scrollbar-track {
                border-radius: 0;
            }
            .table {
                overflow-x: auto;
                width: fit-content;
                max-width: 100%;
                margin: 0 auto 40px;
                position: relative;
                display: block;
                max-height: 500px;
                padding-right: 6px
            }
            .content {
                max-width: 95%;
            }
            .links {
                margin-bottom: 40px;
            }

            input {
                padding: 1px 3px;
            }
            .autocomplete-div {
                width: 282px;
                background: white;
                margin: 0 auto;
                position: relative;
                padding-top: 10px;
            }
            .suggestions {
                position: absolute;
                background: #F5F5F5;
                top: 0;
                left: 0;
                right: 0;
                padding: 0;
                list-style-type: none;
                border-radius: 0 0 4px 4px;
                max-height: 300px;
                overflow-y: auto;
            }
            .suggestions li {
                margin-bottom: 6px;
                padding: 0 6px;
            }
            .suggestions li:first-child {
                margin-top: 6px;
            }
            .suggestions li:last-child a {
                border-radius: 0 0 2px 2px;
                margin-bottom: 6px;
            }
            .suggestions li a {
                display: block;
                font-weight: 400;
                border: 0;
                padding: 0.25rem 0;
            }
            .suggestions li a .bold-span {
                font-weight: 600;
            }
            .suggestions li a:hover {
                background: #E0E0E0;
                cursor: pointer;
                border: 0;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    Teleport Search App
                </div>

                <section class="" style="margin: 30px auto">
                    <form method="POST" action="/result" autocomplete="off" id="search-form">
                        {{ csrf_field() }}
                        <label for="query" style="color: black; font-weight: 400; font-size: 1.25rem; display: inline-block; margin-bottom: 6px;">Wpisz poszukiwane miasto:</label>
                        <br>
                        <input type="text" name="query" placeholder="Wroclaw" maxlength="25" id="autocomplete-input" required>
                        <button type="submit">Wyszukaj!</button>
                        <div class="autocomplete-div" id="autocomplete-div">
                        </div>
                        @if(Session::has('error'))
                            <span style="color: #FF1744; font-weight: 600; margin-top: 6px; display: block"> {!! Session::get('error') !!} </span>
                        @endif
                    </form>
                    
                    
                    
                </section>

                <div class="links">
                    <a href="https://github.com/shadaxv/teleport" target="_blank">GitHub</a>
                </div>
            </div>
        </div>

        <script>
            let lastInput;
            let html;

            function cleanDiv(target) {
                var cNode = target.cloneNode(false);
                target.parentNode.replaceChild(cNode ,target);
            }

            function watchAutoComplete() {
                const autocomplete = document.querySelectorAll(".autocomplete");
                autocomplete.forEach(anchor => anchor.addEventListener('click', autocompleteInput));
            }

            function appendDiv(html) {
                let ul = document.createElement('ul');
                ul.className = 'suggestions';
                ul.innerHTML = html;
                document.getElementById('autocomplete-div').appendChild(ul);
            }

            function findMatches() {
                const targetDiv = document.querySelector('.autocomplete-div');
                const inputValue = this.value;
                if(inputValue == lastInput) {
                    if(!html == '') {
                        cleanDiv(targetDiv);
                        appendDiv(html);
                        watchAutoComplete();
                    }
                } else if (inputValue.length >= 3) {
                    lastInput = inputValue;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        cache: false,
                        encoding: "UTF-8",
                        url: "{{ url('teleport') }}",
                        data: {input: inputValue},
                        success: function (data) {
                            if(data == null || data.length == 0) {
                                
                            } else {
                                cleanDiv(targetDiv);
                                html = data.map(place => {
                                    const city = place.substr(0, place.indexOf(',')); 
                                    const rest = place.substr(place.indexOf(','), place.length);
                                    return `
                                        <li>
                                            <span class="name"><a href="#autocomplete-input" class="autocomplete"><span class="bold-span">${city}</span>${rest}</a></span>
                                        </li>
                                        `;
                                }).join('');
                                appendDiv(html);
                                watchAutoComplete();
                            }
                        }
                    });
                    
                } else {
                    cleanDiv(targetDiv);
                }
                suggestions = document.querySelector(".suggestions");
            }

            function autocompleteInput(event) {
                event.preventDefault();
                const input = document.querySelector("#autocomplete-input");
                const span = this.querySelector(".bold-span").innerHTML;
                const form = document.querySelector("#search-form");
                input.value = span;
                const targetDiv = document.querySelector('.autocomplete-div');
                cleanDiv(targetDiv);
                form.submit();
            }

            const input = document.querySelector("#autocomplete-input");
            const suggestionsContainer = document.querySelector("#autocomplete-div");

            input.addEventListener("keyup", findMatches);
            input.addEventListener("focus", findMatches);

            document.addEventListener('click', function(event) {
                const targetDiv = document.querySelector('.autocomplete-div');
                const isClickInside = suggestionsContainer.contains(event.target);
                const isInput = input.contains(event.target);
                if (!isClickInside && !isInput) {
                    cleanDiv(targetDiv);
                }
            });

        </script>
    </body>
</html>
