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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
        if ($_FILES['file']['type'] == "image/jpeg") {
            $allowed_size = (1024 * 1024) * 7;
            if ($_FILES['file']['size'] < $allowed_size) {
                $folder = "uploads/" . $user_data['userid'] . "/";

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }
                $image = new Image();
                $filename = $folder . $image->generate_filename(15) . ".jpg";
                move_uploaded_file($_FILES['file']['tmp_name'], $filename);

                $change = 'profile';
                if (isset($_GET['change'])) {
                    $change = $_GET['change'];
                }

                if ($change == "cover") {
                    if (file_exists($user_data['cover_image'])) {
                        // unlink($user_data['cover_image']);
                    }
                    $image->crop_image($filename, $filename, 1366, 488);
                } else {
                    if (file_exists($user_data['profile_image'])) {
                        // unlink($user_data['profile_image']);
                    }
                    $image->crop_image($filename, $filename, 800, 800);
                }

                if (file_exists($filename)) {
                    $userid = $user_data['userid'];

                    if ($change == "cover") {
                        $query = "update users set cover_image = '$filename' where userid = '$userid' limit 1";
                        $_POST['is_cover_image'] = 1;
                    } else {
                        $query = "update users set profile_image = '$filename' where userid = '$userid' limit 1";
                        $_POST['is_profile_image'] = 1;
                    }

                    $DB = new Database();
                    $DB->save($query);

                    //Create a post when user changes profile photo.
                    $post = new Post();

                    $post->create_post($userid, $_POST, $filename);

                    header("Location: profile.php ");
                    die;
                }
            } else {
                echo "<div>";
                echo "Only images of size 3MB or lower are allowed!";
                echo "</div>";
            }
        } else {
            echo "<div>";
            echo "Only images of JPEG are allowed!";
            echo "</div>";
        }
    } else {
        echo "<div>";
        echo "Please upload a valid file";
        echo "</div>";
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
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="stylesheet" href="assets/css/forms.css">
    <!--  -->
    <title>Edit Profile | FriendZone</title>
</head>

<body>
    <?php include("navigation.php"); ?>

    <div id="profile">
        <form enctype="multipart/form-data" action="" method="POST">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <?php
                        $image = "images/background-image.jpg";
                        if (file_exists($user_data['cover_image'])) {
                            $image = $user_data['cover_image'];
                        }

                        ?>
                        <div class="box" style="background:url(<?php echo $image ?>);background-position: center;background-repeat: no-repeat;background-size: cover;">
                            <div class="" style="position: absolute;top: 300px;right: 4rem;">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="">
                        <div class="profile-info-left">
                            <div class="text-center">
                                <div class="profile-img w-shadow">
                                    <div class="profile-img-overlay"></div>
                                    <?php
                                    $image = "images/user_default.png";
                                    if (file_exists($user_data['profile_image'])) {
                                        $image = $user_data['profile_image'];
                                    }

                                    ?>
                                    <img src="<?php echo $image ?>" alt="Avatar" class="avatar img-circle">
                                    <div class="profile-img-caption">
                                        <label for="updateProfilePic" class="upload">
                                            <?php
                                            if ($_GET['change'] == 'cover') {
                                                echo '<img src="images/camera.png" style="width: 15px;"><p style="font-size:12px">Update cover photo</p>';
                                            }
                                            if ($_GET['change'] == 'profile') {
                                                echo '<img src="images/camera.png" style="width: 15px;"><p style="font-size:12px">Update profile photo</p>';
                                            }

                                            ?>
                                            <input type="file" name="file" id="updateProfilePicInput" class="upload">
                                        </label>

                                    </div>
                                </div>
                                <p class="profile-fullname mt-3"><?php echo $user_data['first_name'] . " " . $user_data['last_name'] ?></p>
                                <p class="profile-username mb-3 text-muted">@<?php echo $user_data['username'] ?></p>
                            </div>

                            <div class="intro mv-hidden" style="max-width:500px; margin:auto;">
                                <div class="container">
                                    <div class="py-5 text-center">

                                        <div class="row">
                                            <input id="updateProfile" name="updateProfile" type="submit" class="btn btn-primary form-control" value="Update">
                                        </div>
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