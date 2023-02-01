<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>dev</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/brands.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Scripts -->


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/scroll.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/preloader.css') }}">
    <script src="{{ asset('js/jquery.preloader.min.js') }}"></script>
    <link type="text/css" rel="Stylesheet" href="{{ asset('jqwidgets-ver14.0.0/jqwidgets/styles/jqx.base.css') }}" />

    <script type="text/javascript" src="{{ asset('jqwidgets-ver14.0.0/jqwidgets/jqxcore.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets-ver14.0.0/jqwidgets/jqxbuttons.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jqwidgets-ver14.0.0/jqwidgets/jqxfileupload.js') }}"></script>
    <script>
        (function($, window) {
            $.fn.replaceOptions = function(options, placeholder = null) {
                var self, $option;

                this.empty();
                self = this;
                if (placeholder) {
                    $option = $("<option></option>")
                        .attr("value", "")
                        .text(placeholder);
                    self.append($option);
                }
                $.each(options, function(index, option) {
                    $option = $("<option></option>")
                        .attr("value", option.value)
                        .text(option.text);
                    self.append($option);
                });
            };
        })(jQuery, window);
    </script>
   
@vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>


<body class="container p-0">
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top " style="position: relative; top:-20px">
            <div class="container-fluid text-center">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('assets/img/ev-logo.PNG') }}" width="100px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        @can('invantaire-list')
                            <div class="dropdown nav-item ">
                                <a class="nav-link  dropdown-toggle {{ request()->routeIs('inventory.index') ? 'active-1' : '' }} {{ request()->routeIs('inventory.sortie') ? 'active-1' : '' }}"
                                    href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Inventaires
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="z-index: 1;">
                                    <li><a class="dropdown-item" href="{{ route('inventory.index') }}">Liste
                                            d'inventaire</a></li>
                                    <li><a class="dropdown-item" href="{{ route('inventory.sortie') }}">Liste des
                                            sorties</a>
                                    </li>
                                </ul>
                            </div>
                        @endcan
                        @can('demande-list')
                        <li class="nav-item"><a
                            class="nav-link {{ request()->routeIs('demande.index') ? 'active-1' : '' }}"
                            href="{{ route('demandes.index') }}">Demandes</a></li>
                            <div class="dropdown nav-item">
                                <a class="nav-link  dropdown-toggle {{ request()->routeIs('demande.index') ? 'active-1' : '' }}"" href="#" role="button" id="dropdownMenuLink"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Demandes
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="z-index: 1;">
                                    <li><a class="dropdown-item" href="{{ route('demandes.index') }}">Active</a></li>
                                    <li><a class="dropdown-item" href="{{ route('demandes.history') }}">History</a></li>
                                </ul>
                            </div>
                        @endcan
                        @can('user-list')
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('users.index') ? 'active-1' : '' }}"
                                    href="{{ route('users.index') }}">Gérer les utilisateurs</a></li>
                        @endcan
                        @can('role-list')
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('roles.index') ? 'active-1' : '' }}"
                                    href="{{ route('roles.index') }}">Gérer les rôles</a></li>
                        @endcan

                        @can('resource-list')
                            <div class="dropdown nav-item">
                                <a class="nav-link  dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Ressources
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="z-index: 1;">
                                    <li><a class="dropdown-item" href="{{ route('machines.index') }}">Machines</a></li>
                                    <li><a class="dropdown-item" href="{{ route('technciens.index') }}">Techniciens</a></li>
                                    <li><a class="dropdown-item" href="{{ route('typeIntervontions.index') }}">Type d'intervontions</a></li>
                                    <li><a class="dropdown-item" href="{{ route('niveauIntervontions.index') }}">Niveau d'intervontions</a></li>
                                </ul>
                            </div>
                        @endcan
                        @can('request-list')
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('requests.index') ? 'active-1' : '' }}"
                                    href="{{ route('requests.index') }}">Demandes <span
                                        class="badge bg-danger ">{{ $notify ?? '' }}</span></a></li>
                        @endcan
                        @can('activity-list')
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->routeIs('activity.index') ? 'active-1' : '' }}"
                                    href="{{ route('activity.index') }}">Log </a></li>
                        @endcan
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                            {{ __('Se déconnecter') }}</a>
                                    <li><a class="dropdown-item" href="{{ url('change-password') }}">Changer le mot de
                                            passe</a></li>
                                </ul>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            </li>
                        @endguest
                    </ul>
                    <ul class="navbar-nav">
                        <li><img src="{{ asset('assets/img/GMAO-Solution-logo.png') }}" width="150px"></li>
                    </ul>

                </div>
            </div>
        </nav>
        <main class="py-2 ">
            <div class="container-fluid  ">
                @yield('content')
            </div>
        </main>
    </div>

    <footer class="bg-orange fixed-bottom">
        <div class="row footer">
            <div class="col-7  color-02" style="">
                Copyright © 2022 ELEPHANT-VERT
            </div>
            <div class="col-5  text-end color-02">
                Powered by ELEPHANT-VERT-DEV
            </div>
        </div>
    </footer>
</body>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>

</html>
