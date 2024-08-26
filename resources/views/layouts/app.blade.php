<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link href="/storage/{{ $shareSettings->favicon }}" rel="shortcut icon">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('frontend/fontawesome/css/all.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <livewire:styles />
    @yield('css')

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #fff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            color: #333;
        }

        .navbar-nav .nav-link {
            color: #333;
            margin-left: 1rem;
        }

        .btn-view-frontend {
            background-color: #007bff;
            color: #fff;
            margin-left: auto;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .sidebar {
            background-color: #fff;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            margin-bottom: 1rem;
        }

        .sidebar ul li a {
            color: #333;
            text-decoration: none;
            font-weight: 600;
        }

        .content {
            margin-left: 2rem;
            flex-grow: 1;
        }

        .alert {
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
            }

            .btn-view-frontend {
                margin-left: 0;
                margin-top: 1rem;
            }

            .content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar">
            <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name', 'Laravel') }}</a>
            <a href="{{ url('/') }}" target="_blank" class="btn btn-view-frontend">View Application Frontend</a>
        </nav>

        <main>
            <div class="container d-flex">
                @auth
                    <div class="sidebar">
                        <ul>
                            <li><a href="{{ route('orders.index') }}">Orders</a></li>
                            <li><a href="{{ route('categories.index') }}">Category</a></li>
                            <li><a href="{{ route('subcategories.index') }}">Sub Category</a></li>
                            <li><a href="{{ route('products.index') }}">Products</a></li>
                            <li><a href="{{ route('slides.index') }}">Slides</a></li>
                            <li><a href="{{ route('coupon.index') }}">Coupons</a></li>
                            <li><a href="{{ route('contactMessages') }}">Messages</a></li>
                            <li><a href="{{ route('social-links.index') }}">Social Links</a></li>
                            <li><a href="{{ route('users.index') }}">Platform Users</a></li>
                            <li><a href="{{ route('partner.index') }}">Partners</a></li>
                            <li><a href="{{ route('system-settings.index') }}">System Settings</a></li>
                            <li><a href="{{ route('about.index') }}">About Info</a></li>
                            <li><a href="{{ route('privacy.index') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('terms.index') }}">Terms & Conditions</a></li>
                        </ul>
                    </div>
                    <div class="content">
                        @if (Session::has('success'))
                            <div class="alert alert-primary">{{ Session::get('success') }}</div>
                        @endif

                        @if (Session::has('error'))
                            <div class="alert alert-danger">{{ Session::get('error') }}</div>
                        @endif

                        @yield('content')
                    </div>
                @else
                    @yield('content')
                @endauth
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <livewire:scripts />
    @yield('scripts')
</body>

</html>
