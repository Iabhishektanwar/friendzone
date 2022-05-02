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

    $post = new Post();
    $id = $_SESSION['friendzone_userid'];
    $result = $post->create_post($id, $_POST, $_FILES);

    if ($result == "") {
        header("Location: index.php");
    } else {
        echo "<div>";
        echo "The following errors occured<br>";
        echo $result;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="stylesheet" href="assets/css/forms.css">
    <!--  -->
    <title>Home | FriendZone</title>
</head>

<body>
    <?php include("navigation.php"); ?>

    <div id="profile">
        <div class="container">
            <div class="row">
                <!-- Info -->
                <div class="col-sm-4">
                    <div class="profile-info-left" style="margin-top: 105px;">
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
                                    <?php
                                    if (i_own_content($user_data)) : ?>
                                        <label class="upload">
                                            <a href="profile.php" class="text-center upload" style="text-decoration: none;">View profile</a>
                                        </label>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <p class="profile-fullname mt-3"><?php echo $user_data['first_name'] . " " . $user_data['last_name'] ?></p>
                            <p class="profile-username mb-3 text-muted">@<?php echo $user_data['username'] ?></p>
                        </div>

                    </div>
                </div>
                <!-- Write and fetch Post -->
                <div class="col-sm-8">
                    <div class="container">
                        <div class="col-sm-12">
                            <div class="profile-info-right">
                                <?php
                                if (i_own_content($user_data)) : ?>
                                    <form enctype="multipart/form-data" action="" method="POST">
                                        <div class="row g-2" style="padding: 15px 5px;">
                                            <div class="col-sm-12 ">
                                                <textarea id="post" name="post" class="bg-light form-control" rows="3" placeholder="What's on your mind, <?php echo $user_data['first_name'] ?>?" style="width: 100%; border-radius:6px; padding:10px; border:none;"></textarea>
                                            </div>
                                            <div class="col-sm-6">

                                                <button type="button" class="btn btn-outline-secondary w-100 form-control" onclick="document.getElementById('getFile').click()"><img src="images/addimage.png" width="20" /> Photo</button>
                                                <input type='file' name="file" id="getFile" style="display:none">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="submit" id="post_button" value="Post" class="btn btn-primary w-100 form-control">
                                            </div>
                                        </div>
                                    </form>
                                <?php endif; ?>
                                <!-- </div> -->
                            </div>
                            <!-- first Post -->
                            <div>
                                <?php

                                $page_number = 1;
                                if (isset($_GET['page'])) {
                                    $page_number = (int)$_GET['page'];
                                }
                                if ($page_number < 1) {
                                    $page_number = 1;
                                }




                                $limit = 10;
                                $offset = ($page_number - 1) * $limit;


                                $DB = new Database();
                                $sql = "select * from posts where parent = 0 order by id desc limit $limit offset $offset";
                                $posts = $DB->read($sql);
                                if (isset($posts) && $posts) {
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