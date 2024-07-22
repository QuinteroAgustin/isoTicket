<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ISOCIEL - @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/isociel-logo_ic-blanc-png.png') }}">
    @vite('resources/css/app.css')

    <!-- Include stylesheet -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/quill@2.0.1/dist/quill.snow.css" rel="stylesheet" /> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" /> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" /> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" /> -->

    <!-- Include script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.1/dist/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body class="bg-gray-100"><!-- overflow-hidden -->
    <div class="flex flex-col h-screen">
        <!-- Inclure le composant de navbar -->
        @include('components.navbar')
        <!-- Main Content -->
        <div class="flex-1 flex pt-16">
            <!-- Inclure le composant de slidebar -->
            <div class="w-1/10 bg-gray-800 text-white">
                @include('components.slidebar')
            </div>
            <!-- Main Content -->
            <div class="w-9/10 px-8 w-full pt-1">
                <!-- Inclure le composant des messages flash -->
                @include('components.messages')

                <div class="">
                    <!-- Page Content -->
                    <main class="">
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>
</html>
