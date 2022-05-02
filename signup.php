<?php
require_once("database/initialise_database.php");
include("classes/connect.php");
include("classes/signup.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $signup = new Signup();
    $result = $signup->evaluate($_POST);
    if ($result != "") {
        echo "<div class='error text-center'>";
        echo $result;
        echo "</div>";
    } else {
        header("Location: signin.php");
        die;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/logo.png" />
    <title>Sign Up | FriendZone</title>

    <link href="https://fonts.googleapis.com/css?family=Major+Mono+Display" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@1.9.2/css/boxicons.min.css' rel='stylesheet'>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/auth.css">
    <link rel="stylesheet" href="assets/css/forms.css">
    <link rel="stylesheet" href="assets/css/media.css">
</head>

<body>
    <div class="row ht-100v flex-row-reverse no-gutters">
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="signup-form" style="padding:15px;">
                <div class="auth-logo text-center">
                    <div class="col-md">
                        <img src="images/logo.png" class="logo-img" alt="Logo" width="100px">
                    </div>
                    <div class="col-md">
                        <p>FriendZone</p>
                        <span>Sign up to see photos from your friends</span>
                    </div>
                </div>
                <form id="signupform" class="needs-validation pt-5" novalidate method="post">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control firstName-check" name="firstName" id="firstName" placeholder="First Name" require autofocus>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="email" class="form-control checking_email" id="email" name="email" placeholder="Email Address" required>
                                <small class="error email_live_validation"></small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="agree-privacy">By clicking the Sign Up button below you agreed to our privacy policy and terms of use of our website.</p>
                        </div>
                        <input id="button" name="register" type="submit" class="btn btn-primary form-control" value="Sign Up">
                        <span class="text-center">Already a member? <a href="signin.php">Sign In</a></span>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6 auth-bg-image d-flex justify-content-center align-items-center">
            <div class="auth-left-content mt-5 mb-5 text-center">
                <div class="weather-small text-white">
                    <p class="current-weather"><i class='bx bx-sun'></i> <span>17&deg;</span></p>
                    <p class="weather-city">Silverdale</p>
                </div>
                <div class="text-white mt-5 mb-5">
                    <h2 class="create-account mb-3">Create Account</h2>
                    <p>Enter your personal details and start journey with us.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js" type="text/javascript"></script>

    <script src="assets/js/signup_validations.js"></script>
    <script src="assets/js/ajax_signup.js"></script>
</body>

</html>