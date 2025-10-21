<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Management System</title>
    <link rel="shortcut icon" href="assets/images/pnp.png" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap-4.1.3.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome-4.7.0.min.css">
    <link rel="stylesheet" href="assets/css/animate-3.7.0.css">
    <link rel="stylesheet" href="assets/css/owl-carousel.min.css">
    <link rel="stylesheet" href="assets/css/jquery.datetimepicker.min.css">

    <style>
        /* General Reset */
        body, html {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
            background: #f5f6fa;
        }

        /* Preloader */
        .preloader {
            position: fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:#fff;
            display:flex;
            justify-content:center;
            align-items:center;
            z-index:9999;
        }
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #ffca28;
            border-top: 5px solid #0d47a1;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
        }

        /* Header */
        .header-area {
            background: #0d47a1;
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .header-area #logo a {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
        }
        .nav-menu-container ul.nav-menu {
            list-style: none;
            display: flex;
            gap: 25px;
            margin: 0;
            padding: 0;
        }
        .nav-menu-container ul.nav-menu li a {
            color: #fff;
            font-weight: 500;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }
        .nav-menu-container ul.nav-menu li a:hover,
        .nav-menu-container ul.nav-menu li.menu-active a {
            color: #ffca28;
        }

        /* Banner */
        .banner-area {
            background: linear-gradient(to right, #0d47a1, #1976d2);
            color: #fff;
            padding: 120px 0 60px 0;
            text-align: center;
            position: relative;
        }
        .banner-area h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .banner-area h4 {
            font-weight: 500;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }
        .banner-area p {
            font-size: 1.1rem;
            color: #e0e0e0;
        }
        .banner-area img {
            animation: float 3s ease-in-out infinite;
            margin-bottom: 20px;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        /* Login Cards Section */
        .login-cards-area {
            padding: 60px 0;
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            position: relative;
            overflow: hidden;
        }
        /* Abstract shapes */
        .login-cards-area .shape {
            position: absolute;
            border-radius: 50%;
            z-index: 0;
        }
        .shape-yellow { background: rgba(255,202,40,0.2); width:200px; height:200px; top:-50px; left:-50px; }
        .shape-blue { background: rgba(13,71,161,0.1); width:250px; height:250px; bottom:-60px; right:-60px; }

        /* Cards */
        .login-card {
            display: block;
            background: #fff;
            border-radius: 20px;
            padding: 50px 25px;
            text-decoration: none;
            color: #0d47a1;
            box-shadow: 0 12px 30px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            position: relative;
            z-index: 2;
        }
        .login-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            color: #ffca28;
        }
        .login-card .card-icon {
            margin-bottom: 20px;
            color: #ffca28;
            transition: all 0.4s ease;
        }
        .login-card:hover .card-icon {
            transform: rotate(10deg);
            color: #0d47a1;
        }
        .login-card h4 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.4rem;
            margin: 0;
        }
        @media (max-width: 767px){
            .login-card {
                padding: 30px 15px;
            }
            .login-card .card-icon {
                font-size: 2.5rem !important;
            }
        }
    </style>
</head>
<body>

    <!-- Preloader -->
    <div class="preloader">
        <div class="spinner"></div>
    </div>

    <!-- Header -->
    <header class="header-area">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div id="logo">
                    <a href="index.php">CAR PNP PMS</a>
                </div>
                <nav id="nav-menu-container">
                    <ul class="nav-menu">
                        <li class="menu-active"><a href="index.php">Home</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Banner -->
    <section class="banner-area">
        <div class="container">
            <img src="assets/images/pnp.png" alt="Logo" height="120">
            <h4>Welcome to CAR PNP</h4>
            <h1>Patient Management System</h1>
            <p>Capstone Project</p>
        </div>
    </section>

    <!-- Login Cards -->
    <section class="login-cards-area">
        <!-- Abstract shapes -->
        <div class="shape shape-yellow"></div>
        <div class="shape shape-blue"></div>

        <div class="container" style="position: relative; z-index:1;">
            <h2 class="text-center mb-5" style="font-family: 'Montserrat', sans-serif; color: #0d47a1;">Login Portal</h2>
            <div class="row justify-content-center">
                
                <!-- Police Login Card -->
                <div class="col-md-3 mb-4">
                    <a href="backend/police/index.php" class="login-card text-center">
                        <div class="card-icon">
                            <i class="fa fa-shield fa-3x"></i>
                        </div>
                        <h4>Police Login</h4>
                    </a>
                </div>

                <!-- SHU Login Card -->
                <div class="col-md-3 mb-4">
                    <a href="backend/shu/index.php" class="login-card text-center">
                        <div class="card-icon">
                            <i class="fa fa-lock fa-3x"></i>
                        </div>
                        <h4>SHU Login</h4>
                    </a>
                </div>

                <!-- Regional Login Card -->
                <div class="col-md-3 mb-4">
                    <a href="backend/doc/index.php" class="login-card text-center">
                        <div class="card-icon">
                            <i class="fa fa-user-md fa-3x"></i>
                        </div>
                        <h4>Regional Login</h4>
                    </a>
                </div>

                <!-- Administrator Login Card -->
                <div class="col-md-3 mb-4">
                    <a href="backend/admin/index.php" class="login-card text-center">
                        <div class="card-icon">
                            <i class="fa fa-cogs fa-3x"></i>
                        </div>
                        <h4>Administrator Login</h4>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- Javascript -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="assets/js/vendor/bootstrap-4.1.3.min.js"></script>
    <script>
        $(window).on('load', function(){
            $('.preloader').fadeOut('slow');
        });
    </script>
</body>
</html>
