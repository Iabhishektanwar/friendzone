<?php

include("classes/autoload.php");


$login = new Login();
$user_data = $login->check_login($_SESSION['friendzone_userid']);

$USER = $user_data;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $profile = new Profile();
    $profile_data = $profile->get_profile($_GET['id']);
    if (is_array($profile_data)) {
        $user_data = $profile_data[0];
    }
}

// For posting
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['first_name'])) {
        $settings_class = new Settings();
        $settings = $settings_class->save_settings($_POST, $_SESSION['friendzone_userid']);
    } else {
        $post = new Post();
        $id = $_SESSION['friendzone_userid'];
        $result = $post->create_post($id, $_POST, $_FILES);

        if ($result == "") {
            header("Location: profile.php");
            die;
        } else {
            echo "<div>";
            echo "The following errors occured<br>";
            echo $result;
            echo "</div>";
        }
    }
}

//collect posts

$post = new Post();
$id = $user_data['userid'];
$posts = $post->get_post($id);


//collect friends

$user = new User();
$friends = $user->get_friends($id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/logo.png" />
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="stylesheet" href="assets/css/forms.css">
    <!--  -->
    <title>Edit Details | FriendZone</title>
</head>

<body>
    <?php include("navigation.php"); ?>

    <div id="profile">
        <form enctype="multipart/form-data" action="" method="POST">
            <div class="container">
                <div class="row">
                    <div class="">
                        <div class="profile-info-left">

                            <div class="intro mv-hidden" style="max-width:500px; margin:auto; margin-top:70px">
                                <div class="container">
                                    <div class="py-5 text-center">

                                        <?php

                                        $settings_class = new Settings();
                                        $settings = $settings_class->get_settings($_SESSION['friendzone_userid']);

                                        if (is_array($settings)) {
                                            echo "<div class='row g-3'>
                                            <div class='form-group col-sm-6'>
                                                <input type='text' class='form-control' id='first_name' name='first_name' placeholder='First name' value='" . htmlspecialchars($settings['first_name']) . "'>
                                            </div>
                                            <div class='form-group col-sm-6'>
                                                <input type='text' class='form-control' id='last_name' name='last_name' placeholder='Last name' value='" . htmlspecialchars($settings['last_name']) . "'>
                                            </div>
                                            <div class='form-group col-12'>
                                                <div class='input-group'>
                                                    <input type='text' class='form-control' id='username' name='username' placeholder='Username' value='" . htmlspecialchars($settings['username']) . "
                                                    '>
                                                </div>
                                            </div>
                                            <div class='form-group col-12'>
                                                <div class='input-group'>
                                                    <textarea type='text' class='form-control' id='bio' name='bio' placeholder='Bio' >" . htmlspecialchars($settings['bio']) . "</textarea>
                                                </div>
                                            </div>
                                            <div class='form-group col-12'>
                                                <div class='input-group'>
                                                    <input type='text' class='form-control' id='work' name='work' placeholder='Work' value='" . htmlspecialchars($settings['work']) . "'>
                                                </div>
                                            </div>
                                            <div class='form-group col-12'>
                                                <div class='input-group'>
                                                    <input type='text' class='form-control' id='education' name='education' placeholder='Education' value='" . htmlspecialchars($settings['education']) . "'>
                                                </div>
                                            </div>
                                            <div class='form-group col-12'>
                                                <div class='input-group'>
                                                    <input type='text' class='form-control' id='hometown' name='hometown' placeholder='Hometown' value='" . htmlspecialchars($settings['hometown']) . "'>
                                                </div>
                                            </div>
                                            <div class='form-group col-12'>
                                                <div class='input-group'>
                                                    <input type='text' class='form-control' id='contact' name='contact' placeholder='Contact' value='" . htmlspecialchars($settings['contact']) . "'>
                                                </div>
                                            </div>
                                            <hr class='my-4'>
                                            <input id='editdetails' name='editdetails' type='submit' class='btn btn-primary form-control' value='Update'>
                                        </div>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>



    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>