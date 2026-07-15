<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

        <style>
            body { font-family: 'Poppins', sans-serif; background: #f8fafc; }
            .auth-wrapper {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem 0;
            }
            .auth-card {
                border-radius: 1.75rem;
                box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
                border: 1px solid rgba(15, 23, 42, 0.08);
                overflow: hidden;
            }
            .auth-card .card-body {
                padding: 2rem 2.5rem;
            }
            .auth-card .input-group-text {
                background: #f8fafc;
                border: 1px solid #e5e7eb;
                color: #2563eb;
                min-width: 48px;
                justify-content: center;
            }
            .auth-card .form-control {
                border-radius: 0 0.75rem 0.75rem 0;
                border: 1px solid #e5e7eb;
            }
            .auth-card .form-control:focus {
                box-shadow: none;
                border-color: #2563eb;
            }
            .auth-footer-link {
                color: #2563eb;
                font-weight: 600;
                text-decoration: none;
            }
            .auth-footer-link:hover {
                text-decoration: underline;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <!-- <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div> -->
        </div>
        
    </body>
</html>
