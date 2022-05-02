<?php
require_once("database/initialise_database.php");
include("classes/autoload.php");


$login = new Login();
$_SESSION['friendzone_userid'] = isset($_SESSION['friendzone_userid']) ? $_SESSION['friendzone_userid'] : 0;
$user_data = $login->check_login($_SESSION['friendzone_userid'], false);
if (!isset($user_data)) {
    $user_data = array(
        "id" => "",
        "userid" => "", "first_name" => "", "last_name" => "", "email" => "", "username" => "", "password" => "", "url_address" => "", "date" => "", "profile_image" => "",   "cover_image" =>  "", "likes" => "",  "bio" =>  "", "work" => "",  "education" => "",  "hometown" => "",  "contact" => ""
    );
}

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

    include("changeimage.php");

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="stylesheet" href="assets/css/forms.css">

    <!--  -->
    <title><?php echo $user_data['first_name'] . " " . $user_data['last_name'] ?> | FriendZone</title>
</head>

<body>
    <?php include("navigation.php"); ?>

    <!-- Change profile picture from the same page -->
    <div id="change_profile_image" style=" display:none; position:absolute; width:100%; height:91vh; z-index: 1; background-color: #000000aa;">
        <form enctype="multipart/form-data" action="editprofile.php?change=profile" method="POST">
            <div class="container">
                <div class="row">

                    <div class="profile-info-left" style="margin-top:250px">
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
                                        <img src="images/camera.png" style="width: 15px;">
                                        <p style="font-size:12px">Update</p>
                                        <input type="file" name="file" id="updateProfilePicInput" class="upload">
                                    </label>

                                </div>
                            </div>
                        </div>

                        <div class="intro mv-hidden" style="max-width:250px; margin:auto;">
                            <div class="container">
                                <div class="py-5 text-center">
                                    <div class="row">
                                        <input id="updateProfile" name="updateProfile" type="submit" class="btn btn-primary form-control" value="Update Image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <!-- Change cover picture from the same page -->
    <div id="change_cover_image" style=" display:none; position:absolute; width:100%; height:91vh; z-index: 1; background-color: #000000aa;">
        <div id="profile">
            <form enctype="multipart/form-data" action="editprofile.php?change=cover" method="POST">
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
                                                <img src="images/camera.png" style="width: 15px;">
                                                <p style="font-size:12px">Update Cover Image</p>
                                                <input type="file" name="file" id="updateProfilePicInput" class="upload">
                                            </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="intro mv-hidden" style="max-width:300px; margin:auto;">
                                    <div class="container">
                                        <div class="py-5 text-center">

                                            <div class="row">
                                                <input id="updateProfile" name="updateProfile" type="submit" class="btn btn-primary form-control" value="Update Cover">
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
    </div>

    <!-- Update bio from profile page -->
    <div class="modal fade" id="bioformmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update intro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="update_bio">
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
                </div>
            </div>
        </div>
    </div>

    <div id="profile">
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
                        <div class="cover-overlay">
                            <?php
                            if (i_own_content($user_data)) : ?>
                                <a onclick="show_change_cover_image(event)" href="editprofile.php?change=cover" class="btn btn-update-cover"><img src="images/camera.png" style="width: 20px;">
                                    Update Cover Photo</a>;
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <!-- Info -->
                <div class="col-sm-4">
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
                                    <label class="upload">
                                        <?php
                                        if ($user_data['userid'] == $_SESSION['friendzone_userid']) {
                                            echo '<a onclick="show_change_profile_image(event)"  href="editprofile.php?change=profile" class="text-center upload" style="text-decoration: none;">Update</a>';
                                        }
                                        ?>
                                    </label>
                                </div>
                            </div>
                            <p class="profile-fullname mt-3"><?php echo $user_data['first_name'] . " " . $user_data['last_name'] ?></p>
                            <p class="profile-username mb-3 text-muted">@<?php echo $user_data['username'] ?></p>
                            <?php
                            $mylikes = "";
                            if ($user_data['likes'] > 0) {
                                $mylikes = $user_data['likes'] . " Followers";
                            }

                            ?>
                            <a href="like.php?type=user&id=<?php echo $user_data['userid'] ?>">
                                <input type="submit" id="post_button" value="+ Follow  <?php echo $mylikes ?>" class="btn btn-primary w-100 form-control"></a>
                        </div>

                        <div class="intro mt-5 mv-hidden">
                            <div class="intro-item d-flex justify-content-between align-items-center">
                                <h3 class="intro-about">Intro</h3>
                            </div>
                            <div class="intro-item d-flex justify-content-between align-items-center">
                                <p class="intro-title text-muted"><i class='bx bx-briefcase text-primary'><img src="images/about.png" style=" width: 15px; vertical-align: -0.25em;"></i>
                                    <?php echo $user_data['bio'] ?></p>
                            </div>
                            <div class="intro-item d-flex justify-content-between align-items-center">
                                <p class="intro-title text-muted"><i class='bx bx-briefcase text-primary'><img src="images/work.png" style=" width: 15px; vertical-align: -0.25em;"></i>
                                    <?php echo $user_data['work'] ?></p>
                            </div>
                            <div class="intro-item d-flex justify-content-between align-items-center">
                                <p class="intro-title text-muted"><i class='bx bx-map text-primary'><img src="images/education.png" style=" width: 15px; vertical-align: -0.25em;"></i> <?php echo $user_data['education'] ?></p>
                            </div>
                            <div class="intro-item d-flex justify-content-between align-items-center">
                                <p class="intro-title text-muted"><i class='bx bx-map text-primary'><img src="images/lives.png" style=" width: 15px; vertical-align: -0.25em;"></i>
                                    <?php echo $user_data['hometown'] ?></p>
                            </div>
                            <div class="intro-item d-flex justify-content-between align-items-center">
                                <p class="intro-title text-muted"><i class='bx bx-time text-primary'><img src="images/phone.png" style=" width: 15px; vertical-align: -0.25em;"></i> <?php echo $user_data['contact'] ?></p>
                            </div>
                            <div class="intro-item d-flex 
                            justify-content-between align-items-center">
                                <?php
                                if ($user_data['userid'] == $_SESSION['friendzone_userid']) {
                                    echo '<a href="settings.php?section=settings&id=' . $user_data['userid'] . '" class="btn btn-quick-link join-group-btn border w-100 form-control" data-bs-toggle="modal" data-bs-target="#bioformmodal">Edit intro</a>';
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Write and fetch Post -->
                <div class="col-sm-8 mt-1">
                    <div class="container">
                        <div class="col-sm-12">

                            <div class="profile-info-right">
                                <form enctype="multipart/form-data" action="" method="POST">
                                    <div class="row g-2" style="padding: 15px 5px;">
                                        <div class="col-sm-12 ">
                                            <?php
                                            if ($user_data['userid'] == $_SESSION['friendzone_userid']) {

                                                echo "<textarea id='post' name='post' class='bg-light form-control' rows='5' style='width: 100%; border-radius:6px; padding:10px; border:none;' placeholder=\"What's on your mind, $user_data[first_name] ?\"></textarea>";
                                            }
                                            ?>
                                        </div>

                                        <div class="col-sm-6">
                                            <?php
                                            if ($user_data['userid'] == $_SESSION['friendzone_userid']) {

                                                echo '<button type="button" class="btn btn-outline-secondary w-100 form-control" onclick="document.getElementById("getFile").click()"><img src="images/addimage.png" width="20" /> Photo</button>
                                            <input type="file" name="file" id="getFile" style="display:none">';
                                            }
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?php
                                            if ($user_data['userid'] == $_SESSION['friendzone_userid']) {

                                                echo '<input type="submit" id="post_button" value="Post" class="btn btn-primary w-100 form-control">';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- first Post -->
                            <div>
                                <?php
                                if ($posts) {
                                    foreach ($posts as $ROW) {
                                        $user = new User();
                                        $ROW_USER = $user->get_user($ROW['userid']);
                                        include("post.php");
                                    }
                                }
                                $pg = pagination_link();
                                ?>
                                <br>
                                <div class="container">
                                    <div class="row">

                                        <div class="col-sm-6" style="width:50%">
                                            <a href="<?php echo ($pg['previous_page']) ?>">
                                                <input type="button" id="post_button" value="Previous Page" class="btn btn-primary w-100 form-control">
                                            </a>
                                        </div>
                                        <div class="col-sm-6" style="width:50%">
                                            <a href="<?php echo ($pg['next_page']) ?>">
                                                <input type="button" id="post_button" value="Next Page" class="btn btn-primary w-100 form-control">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>

<script>
    function show_change_profile_image(event) {
        event.preventDefault();
        var profile_image = document.getElementById("change_profile_image");
        profile_image.style.display = "block";
    }

    function hide_change_profile_image() {
        var profile_image = document.getElementById("change_profile_image");
        profile_image.style.display = "none";
    }

    function show_change_cover_image(event) {
        event.preventDefault();
        var cover_image = document.getElementById("change_cover_image");
        cover_image.style.display = "block";
    }

    function hide_change_cover_image() {
        var cover_image = document.getElementById("change_cover_image");
        cover_image.style.display = "none";
    }

    window.onkeydown = function(key) {
        if (key.keyCode == 27) {
            hide_change_profile_image();
            hide_change_cover_image();
        }
    }
</script>