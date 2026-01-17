<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="public/images/favicon.ico" type="image/ico" />

    <title>Gentelella | @yield('title')</title>

    @include('Admin.Components.styles')
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a>
                    </div>

                    <div class="clearfix"></div>

                    @include('Admin.Components.profile')

                    <br />

                    @include('Admin.Components.sidebar')

                    @include('Admin.Components.menuFooterButtons')

                </div>
            </div>

            @include('Admin.Components.topNav')

            @yield('content')

            @include('Admin.Components.footer')

        </div>
    </div>

    @include('Admin.Components.scripts')

</body>

</html>