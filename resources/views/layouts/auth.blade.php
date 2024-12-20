<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laravel App')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional Custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
        }

        .navbar {
            background-color: #333333; /* Light black / dark gray background */
        }

        .navbar-brand, .nav-link {
            color: #ffffff !important; /* White text color for consistency */
            font-family: 'Arial', sans-serif;
        }

        .navbar .register-btn {
            background-color: transparent;
            color: #ffffff;
            font-family: 'Arial', sans-serif; 
            font-weight: bold;
            font-size: 1.2rem;
            text-transform: uppercase;
            border: none;
        }

        .navbar .register-btn:hover {
            background-color: #007bff;
            color: #ffffff;
        }

        .background-wrapper {
            background-image: url('{{ asset('tenten.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            padding-top: 20px;
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
        }

        .footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 10px 0;
            text-align: center;
        }

        .footer a {
            color: #ffffff;
            text-decoration: underline;
        }

        /* Card Styling */
        .card {
            background-color: rgba(128, 128, 128, 0.8); /* Slightly transparent gray for card */
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: rgba(0, 0, 0, 0.6); /* Matching header to navbar color */
            color: #fff;
        }

        .form-control, .btn, .form-check-label {
            color: #fff; /* White text for form elements */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <span class="navbar-brand">🗣️αвѕσυℓυтє вσσкιмα</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Conditionally Display Register Button -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link">
                                <button class="register-btn btn" onclick="window.location.href='{{ route('register') }}'">
                                    𝚁𝚎𝚐𝚒𝚜𝚝𝚎𝚛
                                </button>
                            </a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Background Wrapper -->
    <div class="background-wrapper">
        <!-- Content Wrapper -->
        <div class="container content-wrapper mt-4">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
