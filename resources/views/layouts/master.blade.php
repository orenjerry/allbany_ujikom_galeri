<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Gallery</title>
    @vite('resources/css/app.css')
    {{-- <style>
        * {
            border: 1px solid red;
        }
    </style> --}}
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    @if (Session::has('user_id'))
        @include('layouts.header')
    @endif
    @yield('content')

    @stack('scripts')
</body>

</html>
