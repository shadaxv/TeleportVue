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
        <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

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
            .hidden {
                display: none;
            }
            .loading {
                background: red;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    Teleport Search App
                </div>

                <section id="suggestions__section" style="margin: 30px auto">
                    <form method="POST" action="/result" autocomplete="off" id="search-form">
                        {{ csrf_field() }}
                        <label for="city-name" style="color: black; font-weight: 400; font-size: 1.25rem; display: inline-block; margin-bottom: 6px;">Wpisz poszukiwane miasto:</label><br>
                        <input id="queryInput" v-model="cityQuery" @keyup="refreshList" @focus="refreshList" name="city-name" type="text" placeholder="Wroclaw" maxlength="25" required>
                        <button type="submit" id="search-button">Wyszukaj!</button>
                        <div class="autocomplete-div" v-click-outside="closeSuggestions" :class="{ 'hidden': isHidden }"> 
                            <ul class="suggestions">
                                <li v-for="city in cities"><a href="#search-form" @click="changeInput($event, city.substr(0, city.indexOf(',')))"><span v-text="city.substr(0, city.indexOf(','))" class="bold-span"></span>@{{city.substr(city.indexOf(','), city.length)}}</a></li>
                            </ul>
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

            var suggestionModule = new Vue ({
                
                el: '#suggestions__section',

                data: {
                    cities: [],
                    cityQuery: '',
                    lastQuery: '',
                    isHidden: true,
                },

                methods: {
                    refreshList() {
                        this.isHidden = false;
                        const button = document.querySelector("#search-button");
                        if(this.cityQuery == this.lastQuery && button.disabled == false){
                            this.isHidden = false;
                        } else if(this.cityQuery.length >= 3 && button.disabled == false) {
                            axios.post('{{ url('teleport') }}', {
                                city: this.cityQuery
                            })
                            .then(function (response) {
                                if(response == null || response.length == 0) {
                                    this.isHidden = true;
                                } else {
                                    this.isHidden = false;
                                    suggestionModule.cities = response.data;
                                }
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                            this.lastQuery = this.cityQuery;
                        } else {
                            this.isHidden = true;
                        }

                    },

                    changeInput(e, city) {
                        e.preventDefault();
                        this.isHidden = true;
                        this.cityQuery = city;
                        const form = document.querySelector("#search-form");
                        const input = document.querySelector("#queryInput");
                        const button = document.querySelector("#search-button");
                        input.value = city;
                        button.disabled = true;
                        form.submit();
                    },

                    closeSuggestions(event) {
                        const button = document.querySelector("#search-button")
                        if(event.target.name == "city-name" && button.disabled == false) {
                            this.isHidden = false;
                        } else {
                            this.isHidden = true;
                        }
                    }
                },

                directives: {
                  'click-outside': {
                    bind: function(el, binding, vNode) {
                      // Provided expression must evaluate to a function.
                      if (typeof binding.value !== 'function') {
                        const compName = vNode.context.name
                        let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`
                        if (compName) { warn += `Found in component '${compName}'` }
            
                        console.warn(warn)
                      }
                      // Define Handler and cache it on the element
                      const bubble = binding.modifiers.bubble
                      const handler = (e) => {
                        if (bubble || (!el.contains(e.target) && el !== e.target)) {
                          binding.value(e)
                        }
                      }
                      el.__vueClickOutside__ = handler
            
                      // add Event Listeners
                      document.addEventListener('click', handler)
                    },
            
                    unbind: function(el, binding) {
                      // Remove Event Listeners
                      document.removeEventListener('click', el.__vueClickOutside__)
                      el.__vueClickOutside__ = null
            
                    }
                  }
                }

            });

        </script>

    </body>
</html>