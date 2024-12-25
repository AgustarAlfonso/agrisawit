<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <!-- Load CSS -->
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Load SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body class="bg-gray-100">

    <!-- Main Content Area -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-1/6 bg-white shadow-lg min-h-screen">
            <x-sidebarpemilik></x-sidebarpemilik>
        </aside>
        
        <!-- Konten Utama -->
        <main class="flex-1 overflow-auto mx-auto max-w-7xl py-6 px-12 bg-gray-50">
            @yield('content')
        </main>
    </div>
        
    <script>
        let idleTime = 0;
        const idleTimeout = 30; // waktu idle dalam detik (1 menit)

        function resetIdleTime() {
            idleTime = 0;
        }

        document.onmousemove = resetIdleTime;
        document.onkeydown = resetIdleTime;

        setInterval(function() {
            idleTime++;
            if (idleTime >= idleTimeout) {
                window.location.href = '/lockscreen'; // arahkan ke halaman lockscreen setelah 1 menit tidak aktif
            }
        }, 1000); // cek setiap detik
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    @stack('scripts')
</body>
</html>
