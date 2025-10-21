<?php
session_start();
include('assets/inc/config.php'); // get configuration file

if (isset($_POST['doc_login'])) {
    $doc_number = $_POST['doc_number'];
    $doc_pwd = sha1(md5($_POST['doc_pwd'])); // double encrypt for security

    // ✅ specify which role can log in
    $allowed_role = 'Regional Doctor'; // <-- change this to your desired category

    // include role in the SQL query
    $stmt = $mysqli->prepare("SELECT doc_id, doc_number, doc_role FROM his_docs WHERE doc_number=? AND doc_pwd=? AND doc_role=?");
    $stmt->bind_param('sss', $doc_number, $doc_pwd, $allowed_role);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // user found and allowed
        $stmt->bind_result($doc_id, $doc_number, $doc_role);
        $stmt->fetch();
        $_SESSION['doc_id'] = $doc_id;
        $_SESSION['doc_number'] = $doc_number;
        $_SESSION['doc_role'] = $doc_role;

        header("location:his_doc_dashboard.php");
        exit;
    } else {
        $err = "Access Denied. Only $allowed_role accounts can log in, or credentials are invalid.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Patient Management System - Regional</title>
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

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <a href="index.php">
                                    <span><img src="assets/images/pnp.png" alt="" height="44"></span>
                                </a>
                                <p class="text-muted mb-4 mt-3">Access Regional Panel.</p>
                            </div>

                            <form method='post'>
                                <div class="form-group mb-3">
                                    <label for="emailaddress">User</label>
                                    <input class="form-control" name="doc_number" type="text" id="emailaddress" required placeholder="User">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input class="form-control" name="doc_pwd" type="password" required id="password" placeholder="Enter your password">
                                </div>

                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-success btn-block" name="doc_login" type="submit"> Log In </button>
                                </div>
                            </form>

                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <p> <a href="his_doc_reset_pwd.php" class="text-white-50 ml-1">Forgot your password?</a></p>
                                </div>
                            </div>

                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container -->
    </div> <!-- end account-pages -->

    <?php include ("assets/inc/footer1.php");?>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>
    
</body>
</html>
