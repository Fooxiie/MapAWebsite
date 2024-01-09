<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Map a website @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap"
          rel="stylesheet"/>

    @vite('resources/js/app.js')
</head>
@include('cookie-consent::index')
<body class="antialiased">
<div class="h-screen bg-gray-800 text-gray-50 background-pattern">
    <header class="p-3 bg-gray-800 drop-shadow-lg">
        <nav class="flex">
            <div class="mr-10">
                <span class="text-4xl">📡</span>
                <span class="h-5 font-mono">Map A Website</span>
            </div>

            <div class="max-h-full align-bottom">
                <p>Use this website to see in a map all
                    dependances
                from
                webapp</p>
            </div>
        </nav>
    </header>

    <main id="main" class="h-auto">
        @yield('content')
    </main>

    <footer class="absolute inset-x-0 bottom-0 h-10 bg-gray-800">
        <div
            class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400
        sm:text-right sm:ml-0 mb-4">
            All right reserved <a
                href="https://github.com/Fooxiie">©️Fooxiie</a>
            v1.0
            <a href="https://www.buymeacoffee.com/devfooxiie">☕ BuyMeACoffe</a>
        </div>
    </footer>
</div>
</body>
</html>
