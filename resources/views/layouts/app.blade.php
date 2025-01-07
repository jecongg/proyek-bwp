<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pool Essential - Billiard Equipment Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <style>
        :root {
            --primary-dark: #2E5077;    /* Biru tua */
            --primary: #4DA1A9;         /* Tosca */
            --secondary: #79D7BE;       /* Mint */
            --light: #F6F4F0;          /* Off-white */
        }

        body {
            background-color: var(--light);
        }

        .navbar {
            background-color: var(--primary-dark) !important;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .navbar-brand img {
            height: 80px;
            width: auto;
            margin-right: 15px;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .category-card {
            transition: transform 0.3s;
            border-color: var(--primary);
            background-color: white;
        }

        .category-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(77, 161, 169, 0.2);
        }

        .card-title {
            color: var(--primary-dark);
        }

        footer {
            background-color: var(--primary-dark) !important;
            padding: 40px 0;
        }

        footer h5 {
            color: var(--secondary);
            font-size: 1.4rem;
            margin-bottom: 20px;
            font-weight: 600;
        }

        footer p {
            color: var(--light);
            opacity: 0.9;
            line-height: 1.6;
        }

        .footer-copyright {
            color: var(--light);
            opacity: 0.7;
            font-size: 0.9rem;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: var(--light);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--secondary);
        }

        .section-title {
            color: var(--primary-dark);
            border-bottom: 3px solid var(--secondary);
            display: inline-block;
            padding-bottom: 5px;
        }

        .price-tag {
            color: var(--primary);
            font-weight: bold;
        }

        .site-title {
            color: var(--light);
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 0;
            line-height: 1.2;
        }

        .page-title {
            color: var(--secondary);
            font-size: 1.2rem;
            margin-bottom: 0;
            opacity: 0.9;
            line-height: 1;
        }

        .title-divider {
            color: var(--secondary);
            margin: 0 10px;
        }

        .brand-container {
            display: flex;
            align-items: center;
        }

        .title-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Style untuk nav items - versi elegan */
        .navbar-nav .nav-item {
            margin: 0 15px;
        }

        .navbar-nav .nav-link {
            color: var(--light) !important;
            font-size: 1.2rem;
            font-weight: 400;
            padding: 5px 0;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--secondary);
            transition: width 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: var(--secondary) !important;
        }

        .navbar-nav .nav-link:hover::after {
            width: 100%;
        }

        .navbar-nav .nav-link.active {
            color: var(--secondary) !important;
            font-weight: 500;
        }

        .navbar-nav .nav-link.active::after {
            width: 100%;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
        }

        .user-name {
            font-weight: 500;
            color: var(--light);
        }

        .user-role {
            font-size: 0.9em;
            color: var(--secondary);
            opacity: 0.9;
        }

        .dropdown-menu {
            background-color: white;
            border: none;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-top: 10px;
        }

        .dropdown-item {
            padding: 8px 20px;
            color: var(--primary-dark);
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: var(--light);
            color: var(--primary);
        }

        .dropdown-divider {
            border-color: var(--light);
            margin: 0.5rem 0;
        }

        /* Styling untuk tombol logout */
        .dropdown-item[type="submit"] {
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <div class="brand-container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Pool Essential">
                </a>
                <div class="title-container">
                    <h1 class="site-title">Pool Essential</h1>
                    <span class="page-title">
                        @if(Request::is('/'))
                            Home
                        @elseif(Request::is('catalog'))
                            Catalog
                        @endif
                    </span>
                </div>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('catalog') ? 'active' : '' }}" href="{{ route('catalog') }}">Catalog</a>
                    </li>

                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-info" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <span class="user-role">({{ Auth::user()->role }})</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                @if(Auth::user()->role === 'Admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.products') }}">Manage Products</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.categories') }}">Add Category</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Pool Essential</h5>
                    <p>Your one-stop shop for premium billiard equipment. We provide high-quality products for both amateur and professional players.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('catalog') }}">Catalog</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Info</h5>
                    <p>Email: info@poolessential.com</p>
                    <p>Phone: (021) 123-4567</p>
                    <p>Address: Jakarta, Indonesia</p>
                </div>
            </div>
            <hr style="border-color: var(--secondary); opacity: 0.3; margin: 30px 0;">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="footer-copyright">&copy; 2024 Pool Essential. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
