<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="//cdn.ckeditor.com/4.11.4/full/ckeditor.js"></script>
{{--    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>--}}




    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Condensed|Roboto+Mono|Roboto+Slab" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <div class="container-fluid">
            <div class="row">

            </div>
        </div>
        @include('admin.layouts.navbar')
        <div class="container-fluid">
            <div class="row">
                @include('admin.layouts.sidebar')
                <main class="col-md-9 bg-light">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    @yield('scripts')

</body>
</html>
