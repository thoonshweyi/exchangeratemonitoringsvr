
<!DOCTYPE html>
<html>
    <head>
        <!-- Application Name -->
        <title>{{ config('app.name') }}</title>

        <meta charseet="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>

        <!-- fav icon -->
        <link href="./assets/img/fav/favicon.png" rel="icon" type="image/png" sizes="16x16"/>

        <!-- bootstrap css1 js2 -->
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> --}}
        <link href="{{ asset('./assets/libs/bootstrap5/bootstrap.min.css') }}" rel="stylesheet" >


        <!-- fontawesome css1 -->
        {{-- <link href="{{ asset('./assets/libs/fontawesome/all.min.css') }}" rel="stylesheet" type="text/css"/> --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- sweetalert2 css1 js1 --}}
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />

        <!-- custome css css1-->
        <link href="{{ asset('assets/dist/css/style.css') }}" rel="stylesheet" type="text/css"/>

        <!-- Extra CSS -->
        @yield('css')

    </head>
    <body>
