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

$ERROR = "";
$Post = new Post();

if (isset($_GET['id'])) {

    $ROW = $Post->get_one_post($_GET['id']);

    if (!$ROW) {
        $ERROR = "This post does not exist!";
    } else {
        if (!i_own_content($ROW)) {
            $ERROR = "Access denied! You cannot delete this post!";
        }
    }
} else {
    $ERROR = "This post does not exist!";
}


// if something was posted
if ($ERROR == "" && $_SERVER['REQUEST_METHOD'] == "POST") {

    $Post->delete_post($_POST['postid']);


    header("Location: " . $_SESSION['return_to']);
    die;
}

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
    <title>Delete Post | FriendZone</title>
</head>

<body>
    <?php include("navigation.php"); ?>

    <div id="profile">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <form method="POST">
                        <?php
                        if ($ERROR != "") {
                            echo "<div class='post border-bottom p-3 bg-light w-shadow text-center' style='border-radius: 8px; margin-top: 20px;'> $ERROR
                            </div>";
                        } else {
                            if ($ROW) {
                                $user = new User();
                                $ROW_USER = $user->get_user($ROW['userid']);

                                include("post_delete.php");

                                echo "<br>";
                                $pid = $ROW['postid'];
                                echo "<input type='hidden' name='postid' value='$pid'>";
                                echo "<input type='submit' id='post_button' value='Delete' class='btn btn-primary form-control'>";
                            }
                        }

                        ?>
                    </form>
                </div>

            </div>
        </div>
    </div>




    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>