<?php
require_once("database/initialise_database.php");
session_start();
include("classes/connect.php");
include("classes/signin.php");

$email = "";
$password = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $login = new Login();
    $result = $login->evaluate($_POST);
    if ($result != "") {
        $error_message = $_SESSION['error_mess'];
    } else {
        header("Location: index.php");
        die;
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
}

if (!isset($error_message)) {
    $error_message = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/logo.png" />
    <title>Sign In | FriendZone</title>

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
                <div class="auth-logo text-center mb-5">
                    <div class="col-md">
                        <img src="images/logo.png" class="logo-img" alt="Logo" width="100px">
                    </div>
                    <div class="col-md">
                        <p>FriendZone</p>
                        <span>Sign up to see photos from your friends</span>
                    </div>
                </div>
                <form id="loginform" class="needs-validation" novalidate method="post">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
                                <small id="email_live_validation" class="error email_live_validation"></small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                <small id="password_validation" class="error password_validation"></small>
                                <small class="error text-center"><?php echo $error_message; ?></small>
                            </div>
                        </div>
                        <input value="Sign In" id="loginbtn" name="loginbtn" type="submit" class="btn btn-primary form-control">
                        <span class="text-center">Not yet a member? <a href="signup.php">Sign Up</a></span>
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
                    <h2 class="create-account mb-3">Welcome Back</h2>
                    <p>Thank you for joining. Updates and new features are released daily.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js" type="text/javascript"></script>

    <script src="assets/js/signin_validations.js"></script>

</body>

</html>

<?php
unset($_SESSION['error_mess']);
?>