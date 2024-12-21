<!-- View File: resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - AgriSawit</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: url('/images/login-bg.png');
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
            width: 100%;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full p-6 card">
        <div class="flex flex-col items-center mb-8">
            <img src="/images/icon.png" alt="AgriSawit Logo" class="w-20 h-20">
            <h2 class="text-xl font-semibold text-gray-800">AgriSawit</h2>
        </div>

        <h1 class="text-2xl font-semibold text-left text-gray-800 mb-6">Login</h1>

        <form action="{{ route('submit.login') }}" method="POST" id="loginForm" class="space-y-6">
            @csrf
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div>
                <button type="submit" class="w-full bg-gradient-to-r from-green-400 to-green-600 text-white py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Sign In</button>
            </div>
        </form>
    </div>

    <script>
        document.querySelector('#loginForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const result = await response.json();

            if (result.status === 'error' && result.remainingTime) {
                let timerInterval;
                Swal.fire({
                    title: result.message,
                    html: `Silakan coba lagi dalam <b></b> detik.`,
                    timer: result.remainingTime * 1000,
                    timerProgressBar: true,
                    didOpen: () => {
                        const b = Swal.getHtmlContainer().querySelector('b');
                        timerInterval = setInterval(() => {
                            b.textContent = Math.ceil(Swal.getTimerLeft() / 1000);
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                });
            } else if (result.status === 'error') {
                Swal.fire('Error', result.message, 'error');
            } else {
                window.location.href = result.redirect;
            }
        });
    </script>
</body>
</html>
