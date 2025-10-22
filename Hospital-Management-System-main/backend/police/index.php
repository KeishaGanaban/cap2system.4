<?php
session_start();
include('assets/inc/config.php');

if (isset($_POST['pat_login'])) {
    $pat_number = $_POST['pat_number'];
    $pat_pwd    = $_POST['pat_pwd'];

    // Prepare and execute query
    $stmt = $mysqli->prepare("SELECT pat_id, pat_number, pat_pwd FROM his_patients WHERE pat_number=?");
    $stmt->bind_param('s', $pat_number);
    $stmt->execute();
    $stmt->bind_result($db_pat_id, $db_pat_number, $db_pat_pwd);
    $rs = $stmt->fetch();

    if ($rs && password_verify($pat_pwd, $db_pat_pwd)) {
        // Correct password
        $_SESSION['pat_id'] = $db_pat_id;
        $_SESSION['pat_number'] = $db_pat_number;
        header("Location: his_pat_account.php");
        exit();
    } else {
        // Invalid login
        $err = "Access Denied! Please check your credentials.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Police Login - Patient Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/pnp.png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Montserrat:wght@700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <!-- SweetAlert -->
    <script src="assets/js/swal.js"></script>
    <?php if(isset($success)) {?>
    <script>
        setTimeout(function () { swal("Success","<?php echo $success;?>","success"); }, 100);
    </script>
    <?php } ?>
    <?php if(isset($err)) {?>
    <script>
        setTimeout(function () { swal("Failed","<?php echo $err;?>","error"); }, 100);
    </script>
    <?php } ?>

    <style>
        body, html {
            font-family: 'Roboto', sans-serif;
            height: 100%;
            margin: 0;
        }

        .authentication-bg-pattern {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
            background: url('assets/images/pnp-bg.jpg') no-repeat center center;
            background-size: cover;
        }

        /* Dark overlay */
        .authentication-bg-pattern::before {
            content: "";
            position: absolute;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background: rgba(13,71,161,0.6);
            z-index:1;
        }

        /* Floating shapes */
        .auth-shape {
            position: absolute;
            border-radius: 50%;
            z-index: 0;
        }
        .shape-yellow { background: rgba(255,202,40,0.2); width:150px; height:150px; top: -50px; left:-50px; }
        .shape-blue { background: rgba(13,71,161,0.1); width:200px; height:200px; bottom:-60px; right:-60px; }

        .account-pages {
            position: relative;
            z-index:2; /* Above overlay and shapes */
            width: 100%;
        }

        .card.bg-pattern {
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
            background: rgba(255,255,255,0.95);
            position: relative;
            padding: 40px;
        }

        .card-body img {
            animation: float 3s ease-in-out infinite;
            margin-bottom: 20px;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .form-control {
            border-radius: 10px;
            height: 45px;
        }

        .btn-success {
            border-radius: 50px;
            background-color: #0d47a1;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #ffca28;
            color: #0d47a1;
        }

        p.text-muted {
            font-size: 0.95rem;
            color: #333;
        }

        a.text-white-50 {
            color: #ffca28 !important;
            text-decoration: none;
        }

        a.text-white-50:hover {
            color: #fff !important;
        }
    </style>
</head>

<body class="authentication-bg-pattern">

    <!-- Floating Shapes -->
    <div class="auth-shape shape-yellow"></div>
    <div class="auth-shape shape-blue"></div>

    <div class="account-pages">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-pattern">

                        <div class="card-body text-center">

                            <div class="text-center w-75 m-auto">
                                <a href="index.php">
                                    <img src="assets/images/pnp.png" alt="" height="60">
                                </a>
                                <p class="text-muted mb-4 mt-3">Enter your account number and password to access Police Panel.</p>
                            </div>

                            <form method='post'>
                                <div class="form-group mb-3 text-left">
                                    <label for="pat_number">User</label>
                                    <input class="form-control" name="pat_number" type="text" id="pat_number" required placeholder="User">
                                </div>

                                <div class="form-group mb-3 text-left">
                                    <label for="password">Password</label>
                                    <input class="form-control" name="pat_pwd" type="password" id="password" required placeholder="Enter your password">
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-success btn-block" name="pat_login" type="submit"> Log In </button>
                                </div>
                            </form>

                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <p> <a href="his_doc_reset_pwd.php" class="text-white-50">Forgot your password?</a></p>
                                </div>
                            </div>

                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </div> <!-- end account-pages -->

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>
    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>
</html>
