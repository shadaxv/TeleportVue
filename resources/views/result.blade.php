<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Teleport App - {{ Request::get('query') }} Results</title>

        <!-- Fonts -->
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

            .links > a, .photo-link > a, .close-link > a {
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
            a:focus:hover {
                border-bottom: 2px solid #1976D2;
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
                height: 12px;
                background-color: #F5F5F5; }
            
            .table::-webkit-scrollbar-thumb {
                border-radius: 10px;
                -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
                background-color: #E0E0E0; }
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
            .photo-link {
                margin-bottom: 20px;
            }
            input {
                padding: 1px 3px;
            }
            div.hidden {
                display: none !IMPORTANT;
            }
            .popup-photo {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background: rgba(0,0,0,0.12);
            }
            .popup-photo .popup-container img {
                max-width: 500px;
                max-height: 500px;
                width: auto;
                height: auto;
                border-radius: 2.5px;
            }
            .popup-photo .popup-container {
                padding: 8px;
                border-radius: 5px;
                background: white;
            }
            .popup-buttons {
                margin: 0 auto;
                padding-top: 8px;
            }
            .popup-buttons button {
                color: #636b6f;
                padding: 5px 18px 3px;
                font-size: 14px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                background: none;
                border-radius: 3px;
                border: 1px solid #BDBDBD;
                transition: all 0.2s;
            }

            .popup-buttons button:hover, .popup-buttons button:focus {
                color: #1976D2;
                border: 1px solid #1976D2;
            }
            .popup-buttons button:hover {
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content" id="container">

                <div class="subtitle m-b-md">
                    Wyniki wyszukiwania dla:
                </div>
                <div class="title m-b-md">
                    &quot;{{ Request::get('city-name') }}&quot;
                </div>

                <div class="photo-link">
                    <a href="#photo" @click="displayPhoto($event)">Zobacz jak wygląda {{ Request::get('city-name') }}</a>
                </div>

                <table id="table" class="table">
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

                        <tr v-for="(key, index) in georesult">
                            <td data-title="ID" class="tr-title" v-text="index + 1 + '.'"></td>
                            <td data-title="Nazwa miasta" v-text='key["name"]'></td>
                            <td data-title="Państwo" v-text='key["_links"]["city:country"]["name"]'></td>
                            <td data-title="Populacja" v-text='key["population"] != undefined ? key["population"] : "Nie podano"'></td>
                            <td data-title="Szerokość geo." v-text='key["location"]["latlon"]["latitude"].toFixed(4)'></td>
                            <td data-title="Długość geo." v-text='key["location"]["latlon"]["longitude"].toFixed(4)'></td>
                        </tr>

                    </tbody>
                </table>

                <div :class="{ 'hidden': isHidden }" class="popup-photo">
                    <div class="popup-container">
                        <img v-click-outside="closePhoto" v-bind:src="imageUrl" id="photo">
                        <div class="popup-buttons">
                            <button>
                                Zamknij obraz
                            </button>
                        </div>
                    </div>
                </div>

                <div class="links">
                    <a href="/teleport">Nowy wyszukiwanie</a>
                    <a href="https://github.com/shadaxv/teleport" target="_blank">GitHub</a>
                </div>
            </div>
        </div>     
        
        <script>


            var renderTable = new Vue ({

                el: '#container',

                data: {
                    georesult: {!! json_encode($georesult) !!},
                    googleKey: "{{env('GOOGLE_KEY')}}",
                    googleCX: "{{env('GOOGLE_CX')}}",
                    imageUrl: '',
                    isHidden: true
                },

                methods: {
                    getFirstImage() {
                        const url = `https://www.googleapis.com/customsearch/v1?key=${this.googleKey}&cx=${this.googleCX}&q=${this.georesult[0].name}&searchType=image&alt=json`
                        axios.get(url)
                        .then(function (response) {
                            console.log(response);
                            renderTable.imageUrl = response.data.items[0].link;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    },

                    displayPhoto(e) {
                        e.preventDefault();
                        this.isHidden = false;
                    },

                    closePhoto(event) {
                        if(event.target.id == "photo" || event.target.hash == "#photo") {
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
                },
                
                beforeMount(){
                    this.getFirstImage()
                }

            });
        </script>
            
    </body>
</html>
