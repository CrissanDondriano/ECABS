<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Default Title')</title>

    <link rel="icon" sizes="96x96" href="{!! url('assets/images/Icon.png') !!}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{!! url('assets/css/app.css') !!}" rel="stylesheet">

    <style>
        .h-custom-2 {
            height: calc(100% - 7rem);
        }

        .date-input-wrapper {
            position: relative;
        }

        .input-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            padding: 8px;
            color: #aaa;
            pointer-events: none;
            transition: 0.2s ease-out;
        }

        #bday:focus+.input-placeholder,
        #bday:not(:placeholder-shown)+.input-placeholder {
            transform: translateY(-50%);
            font-size: 12px;
            color: #000;
        }

        @media (max-width: 764px) and (min-width: 320px) {
            .img-logo {
                background-image: url('assets/images/CABSSS.png');
                background-size: cover;
                background-position: left;
                height: 100vh;
                padding: 0;
            }


            .login-card {
                --bs-card-spacer-y: 1rem;
                --bs-card-spacer-x: 1rem;
                --bs-card-title-spacer-y: .5rem;
                --bs-card-border-width: var(--bs-border-width);
                --bs-card-border-color: var(--bs-border-color-translucent);
                --bs-card-border-radius: var(--bs-border-radius);
                --bs-card-inner-border-radius: calc(var(--bs-border-radius) - (var(--bs-border-width)));
                --bs-card-cap-padding-y: .5rem;
                --bs-card-cap-padding-x: 1rem;
                --bs-card-cap-bg: rgba(var(--bs-body-color-rgb), .03);
                --bs-card-bg: var(--bs-body-bg);
                --bs-card-img-overlay-padding: 1rem;
                --bs-card-group-margin: .75rem;
                position: relative;
                display: flex;
                flex-direction: column;
                min-width: 0;
                height: var(--bs-card-height);
                color: var(--bs-body-color);
                word-wrap: break-word;
                background-color: var(--bs-card-bg);
                background-clip: border-box;
                border: var(--bs-card-border-width) solid var(--bs-card-border-color);
                border-radius: var(--bs-card-border-radius);
            }
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-7 col-lg-6 col-md-5 p-0 d-none d-md-block position-relative">
                <img src="{{ url('assets/images/CABSSS.png') }}" alt="Login image" class="w-100 vh-100 shadow-lg"
                    style="object-fit: cover; object-position: left;">
                @yield('notes')
            </div>
            <div class="col-xl-5 col-lg-6 col-md-7 d-flex align-items-center card-container img-logo">
                @yield('content')
            </div>
        </div>
    </div>

    
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

@yield('scripts')

</html>
