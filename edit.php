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
        if ($ROW['userid'] != $_SESSION['friendzone_userid']) {
            $ERROR = "Access denied! You cannot delete this post!";
        }
    }
} else {
    $ERROR = "This post does not exist!";
}
if (isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "edit.php")) {
    $_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $Post->edit_post($_POST, $_FILES);


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
    <title>Edit Post | FriendZone</title>
</head>

<body>
    <?php include("navigation.php"); ?>

    <div id="profile">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <form method="POST" enctype="multipart/form-data">
                        <?php
                        if ($ERROR != "") {
                            echo "<div class='post border-bottom p-3 bg-light w-shadow text-center' style='border-radius: 8px; margin-top: 20px;'> $ERROR
                            </div>";
                        } else {
                            if ($ROW) {
                                echo "<br>";

                                echo
                                "<div class='row g-2' style='padding: 15px 5px;'>
                                <div class='col-sm-12'>
                                    <textarea id='post' name='post' class='bg-light form-control' rows='3' style='width: 100%; border-radius:6px; padding:10px; border:none;'>" . $ROW["post"] . "</textarea>
                                </div>";
                                if (file_exists($ROW['image'])) {
                                    $im = $ROW['image'];

                                    echo "<img src='$im' style='width:100%'>";
                                }

                                echo "<br>";
                                $pid = $ROW['postid'];
                                echo "<input type='hidden' name='postid' value='$pid'>";
                                echo "<input type='submit' id='post_button' value='Edit' class='btn btn-primary form-control'>";
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