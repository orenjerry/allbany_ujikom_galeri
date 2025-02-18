<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Gallery</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <style>
        * {
            border: 1px solid red;
        }
    </style> --}}
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal flex flex-col min-h-screen">
    @if (Session::has('user_id'))
        @include('layouts.header')
    @endif

    <main class="flex-grow">
        @yield('content')
    </main>

    @stack('scripts')
    @if (Session::has('user_id'))
        @include('layouts.footer')
    @endif
</body>

</html>
