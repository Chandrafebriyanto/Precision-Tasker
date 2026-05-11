<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', __('app.appName'))</title>

    <link rel="icon" href="{{ asset('logo-app.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-surface antialiased min-h-screen font-body flex overflow-hidden">
    <!-- Ambient Background Texture -->
    <div class="fixed inset-0 pointer-events-none z-[-1] opacity-50">
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-primary/5 rounded-full blur-[150px]"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-tertiary-container/5 rounded-full blur-[120px]"></div>
    </div>

    @include('components.sidebar')

    <div class="flex-1 flex flex-col h-screen relative w-full overflow-hidden">
        @include('components.top-navbar')

        <main class="flex-1 overflow-y-auto no-scrollbar pb-12 pt-6 w-full animate-fade-in relative scroll-smooth">
            <div class="max-w-[1600px] mx-auto px-6 lg:px-12 w-full">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
