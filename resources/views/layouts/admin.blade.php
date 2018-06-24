<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script>
        // Global Laravel Variavles
        var APP_URL = {!! json_encode(url('/')) !!};
    </script>


    <noscript>
        Enable javascript to use this page.
    </noscript>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">

    <div class="overlay"></div>

    <div class="top-bar">

        <div class="top-bar__left">

            <div class="top-bar-toggle">

                <div class="top-bar-toggle__container">
                    <div class="top-bar-toggle__line top-bar-toggle__line--one"></div>
                    <div class="top-bar-toggle__line top-bar-toggle__line--two"></div>
                    <div class="top-bar-toggle__line top-bar-toggle__line--three"></div>
                </div>

            </div>

            <div class="logo">
                <h2>
                    <span class="logo__text">Admin</span>
                    <span class="logo__text logo__text--thin">PanelET</span>
                </h2>
            </div>

            <div class="home-top">
                <i class="home-top__icon fas fa-home"></i>
            </div>

            <div class="add-top">
                <i class="add-top__icon fas fa-plus"></i>
            </div>

        </div>

        <div class="top-bar__right">
            <div class="message-top">
                <i class="message-top__icon fas fa-envelope"></i>
            </div>

            <div class="user-top">
                <div class="user-top__container">
                    <img class="user-top__img"
                         src="@if(count(Auth::user()->images) > 0)/{{ Auth::user()->images[0]->path_thumbnail }} @else {{ userAvatar(Auth::user()->id) }} @endif"
                         alt="">
                    <div class="user-top__name">{{ substr(ucfirst(Auth::user()->roles->pluck('name')[0]), 0, 11)}}</div>
                    <i class="user-top__icon fas fa-chevron-down"></i>

                    <div class="user-top__dropdown">
                        <a href="/" class="user-top__item">Profile</a>
                        <a href="{{ route('logout') }}" class="user-top__item"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>

                </div>
                <a href="/">
                    <img class="user-top__img user-top__img--mobile"
                         src="@if(count(Auth::user()->images) > 0)/{{ Auth::user()->images[0]->path_thumbnail }} @else {{ userAvatar(Auth::user()->id) }} @endif"
                         alt="">
                </a>
            </div>
        </div>


    </div>

    <div class="sidebar">

        <div class="sidebar-user">
            <img class="sidebar-user__img"
                 src="@if(count(Auth::user()->images)> 0)/{{ Auth::user()->images[0]->path_thumbnail }} @else {{ userAvatar(Auth::user()->id) }} @endif"
                 alt="">
            <div class="sidebar-user__container">
                <span class="sidebar-user__name">Hi, {{ Auth::user()->first_name }}</span>
                <span class="sidebar-user__role">{{ substr(ucfirst(Auth::user()->roles->pluck('name')[0]), 0, 11) }}</span>
            </div>
        </div>


        <div class="sidebar-menu">

            <ul class="sidebar-menu-outer" id="accordion">

                <!-- Dashboard -->
                <li class="sidebar-menu-outer__item">
                    <a class="sidebar-menu-outer__btn @if(Request::path() === "admin") sidebar-menu-outer__btn--active @endif"
                       href="/admin">
                        <i class="sidebar-menu-outer__icon fas fa-tachometer-alt"></i>
                        <span class="sidebar-menu-outer__text">Dashboard</span>
                    </a>
                </li>
                <!-- Dashboard- END -->

                <!-- Articles -->
                @if(Auth::user()->can('view articles') || Auth::user()->can('create articles'))
                    <li class="sidebar-menu-outer__item">

                        <button class="sidebar-menu-outer__btn @if( strpos(Request::path(), 'admin/articles') !== false) sidebar-menu-outer__btn--active @else collapsed @endif"
                                data-toggle="collapse" data-target="#collapsePosts"
                                aria-expanded="true"
                                aria-controls="collapseTwo">
                            <i class="sidebar-menu-outer__icon far fa-newspaper"></i>
                            <span class="sidebar-menu-outer__text">Articles</span>
                            <i class="sidebar-menu-outer__dropdown fas fa-chevron-down"></i>

                        </button>

                        <div id="collapsePosts"
                             class="collapse @if( strpos(Request::path(), 'admin/articles') !== false) show @else  @endif"
                             aria-labelledby="headingTwo" data-parent="#accordion">

                            <ul class="sidebar-menu-inner">
                                @can('view articles')
                                <li class="sidebar-menu-inner__item">
                                    <a class="sidebar-menu-inner__link @if( Request::path() == 'admin/articles') sidebar-menu-inner__active @else @endif"
                                       href="/admin/articles">All articles</a>
                                </li>
                                @endcan
                                @can('create articles')
                                <li class="sidebar-menu-inner__item">
                                    <a class="sidebar-menu-inner__link @if( strpos(Request::path(), 'admin/articles/new') !== false) sidebar-menu-inner__active @else @endif"
                                       href="/admin/articles/new">Add new article</a>
                                </li>
                                @endcan
                                @can('edit articles')
                                    <li class="sidebar-menu-inner__item">
                                        <a class="sidebar-menu-inner__link @if( strpos(Request::path(), 'admin/tags') !== false) sidebar-menu-inner__active @else @endif"
                                           href="/admin/articles/new">Categories</a>
                                    </li>
                                    <li class="sidebar-menu-inner__item">
                                        <a class="sidebar-menu-inner__link @if( strpos(Request::path(), 'admin/categories') !== false) sidebar-menu-inner__active @else @endif"
                                           href="/admin/articles/new">Tags</a>
                                    </li>
                                @endcan
                            </ul>

                        </div>

                    </li>
                @endif
            <!-- Articles - END -->

                <!-- Pages -->
                @if(Auth::user()->can('view pages') || Auth::user()->can('edit pages'))
                    <li class="sidebar-menu-outer__item">

                        <button class="sidebar-menu-outer__btn collapsed" data-toggle="collapse"
                                data-target="#collapsePages"
                                aria-expanded="true"
                                aria-controls="collapseTwo">
                            <i class="sidebar-menu-outer__icon fas fa-book"></i>
                            <span class="sidebar-menu-outer__text">Pages</span>
                            <i class="sidebar-menu-outer__dropdown fas fa-chevron-down"></i>

                        </button>

                        <div id="collapsePages" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">

                            <ul class="sidebar-menu-inner">
                                @can('view pages')
                                    <li class="sidebar-menu-inner__item">
                                        <a class="sidebar-menu-inner__link" href="/pages">All pages</a>
                                    </li>
                                @endcan
                                @can('edit pages')
                                    <li class="sidebar-menu-inner__item">
                                        <a class="sidebar-menu-inner__link" href="/admin/page">Add new page</a>
                                    </li>
                                @endif
                            </ul>

                        </div>

                    </li>
                @endif
            <!-- Pages - END -->

                <!-- Media -->
                @can('view media')
                <li class="sidebar-menu-outer__item">
                    <a class="sidebar-menu-outer__btn @if( strpos(Request::path(), 'admin/media') !== false) sidebar-menu-outer__btn--active @else collapsed @endif"
                       href="/admin/media">
                        <i class="sidebar-menu-outer__icon fas fa-image"></i>
                        <span class="sidebar-menu-outer__text">Media</span>

                    </a>
                </li>
                @endcan
                <!-- Media - END -->


                <!-- Users -->
                @if(Auth::user()->can('view users') || Auth::user()->can('create standard users') || Auth::user()->can('create editors') || Auth::user()->can('create administrators') || Auth::user()->can('create super administrators'))
                    <li class="sidebar-menu-outer__item">

                        <button class="sidebar-menu-outer__btn @if( strpos(Request::path(), 'admin/users') !== false) sidebar-menu-outer__btn--active @else collapsed @endif"
                                data-toggle="collapse" data-target="#collapseTwo"
                                aria-expanded="true"
                                aria-controls="collapseTwo">
                            <i class="sidebar-menu-outer__icon fas fa-user"></i>
                            <span class="sidebar-menu-outer__text">Users</span>
                            <i class="sidebar-menu-outer__dropdown fas fa-chevron-down"></i>

                        </button>

                        <div id="collapseTwo"
                             class="collapse @if( strpos(Request::path(), 'admin/users') !== false) show @else @endif"
                             aria-labelledby="headingTwo" data-parent="#accordion">


                            <ul class="sidebar-menu-inner">
                                @can('view users')
                                    <li class="sidebar-menu-inner__item">
                                        <a class="sidebar-menu-inner__link @if( Request::path() == 'admin/users') sidebar-menu-inner__active @else @endif"
                                           href="/admin/users">All users</a>
                                    </li>
                                @endcan
                                @if(Auth::user()->can('create standard users') || Auth::user()->can('create editors') || Auth::user()->can('create administrators') || Auth::user()->can('create super admins'))
                                    <li class="sidebar-menu-inner__item">
                                        <a class="sidebar-menu-inner__link @if( strpos(Request::path(), 'admin/users/new') !== false) sidebar-menu-inner__active @else @endif"
                                           href="/admin/users/new">Add new user</a>
                                    </li>
                                @endif
                            </ul>

                        </div>

                    </li>
                @endif

            <!-- Users - END -->

                @hasrole('owner')
                <li class="sidebar-menu-outer__item">
                    <a class="sidebar-menu-outer__btn @if(Request::path() === "admin/permissions") sidebar-menu-outer__btn--active @endif"
                       href="/admin/permissions">
                        <i class="sidebar-menu-outer__icon fas fa-lock"></i>
                        <span class="sidebar-menu-outer__text">Permissions</span>

                    </a>
                </li>
                @endhasrole


                <!-- Appearance -->

                    <li class="sidebar-menu-outer__item">

                        <button class="sidebar-menu-outer__btn collapsed" data-toggle="collapse"
                                data-target="#collapseAppearance"
                                aria-expanded="true"
                                aria-controls="collapseTwo">
                            <i class="sidebar-menu-outer__icon fas fa-paint-brush"></i>
                            <span class="sidebar-menu-outer__text">Appearance</span>
                            <i class="sidebar-menu-outer__dropdown fas fa-chevron-down"></i>

                        </button>

                        <div id="collapseAppearance" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">

                            <ul class="sidebar-menu-inner">
                                    <li class="sidebar-menu-inner__item">
                                        <a class="sidebar-menu-inner__link" href="/pages">Color theme</a>
                                    </li>
                                @can('edit menu')
                                    <li class="sidebar-menu-inner__item">
                                        <a class="sidebar-menu-inner__link" href="/admin/page">Menu</a>
                                    </li>
                                @endif
                            </ul>

                        </div>

                    </li>

            <!-- Appearance - END -->


                <!-- Settings -->
                @can('edit settings')
                    <li class="sidebar-menu-outer__item">
                        <a class="sidebar-menu-outer__btn" href="/admin">
                            <i class="sidebar-menu-outer__icon fas fa-cog"></i>
                            <span class="sidebar-menu-outer__text">Settings</span>

                        </a>
                    </li>
            @endcan
            <!-- Settings - END -->


            </ul>

        </div>


    </div>

    <main>
        <div class="content">
            @yield('content')
        </div>
    </main>
</div>


<script src="{{ asset('js/admin.js') }}"></script>
<!-- include summernote css/js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>

</body>
</html>
