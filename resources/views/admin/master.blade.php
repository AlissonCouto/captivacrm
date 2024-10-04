@php

    use Illuminate\Support\Facades\Auth;

    $companyId = Auth::user()->company()->first()->id;

    $page = url()->current();

    $menu = [
    
        [
            'name' => 'Home',
            'icon' => '<i class="mdi mdi-home icon"></i>',
            'link' => route('dashboard')
        ],
        [
            'name' => 'Leads',
            'icon' => '<i class="mdi mdi-account-group icon"></i>',
            'link' => route('leads.index')
        ],
        [
            'name' => 'Status',
            'icon' => '<i class="mdi mdi-chart-timeline icon"></i>',
            'link' => route('statuses.index')
        ],
        [
            'name' => 'Nichos',
            'icon' => '<i class="mdi mdi-layers icon"></i>',
            'link' => route('niches.index')
        ],
        [
            'name' => 'Finanças',
            'icon' => '<i class="mdi mdi-finance icon"></i>',
            'link' => route('finances.index')
        ],
        [
            'name' => 'Configurar',
            'icon' => '<i class="mdi mdi-cog icon"></i>',
            'link' => route('settings.edit')
        ],
        
    ];

@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @auth
        <meta name="company-id" content="{{ $companyId }}">
    @endauth

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x.x/css/materialdesignicons.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    <div class="app-container">

        <div class="sidebar">

            <div class="menu">

                <div class="logo">
                    C
                </div>

                @foreach($menu as $k => $item)
                    <div class="menu-item {{ $page == $item['link'] ? '-active' : '' }}">
                        <a href="{{$item['link']}}" class="menu-link">
                            {!!$item['icon']!!}
                            <span class="name">{{$item['name']}}</span>
                        </a>
                    </div>
                @endforeach

            </div>

        </div>

        <div class="workspace">

            @yield('content')

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <!--
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js"></script>
    -->
  
</body>

</html>