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

    $post = new Post();
    $id = $_SESSION['friendzone_userid'];
    $result = $post->create_post($id, $_POST, $_FILES);

    if ($result == "") {
        header("Location: singlepost.php?id=$_GET[id]");
        die;
    } else {
        echo "<div>";
        echo "The following errors occured<br>";
        echo $result;
        echo "</div>";
    }
}

$ERROR = "";
$ROW = false;
$Post = new Post();
if (isset($_GET['id'])) {
    $ROW = $Post->get_one_post($_GET['id']);
} else {
    $ERROR = "No post was found!";
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
    <title>Post | FriendZone</title>
</head>

<body>
    <?php include("navigation.php"); ?>

    <div id="profile">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <?php
                    $user = new User();
                    if (is_array($ROW)) {
                        $ROW_USER = $user->get_user($ROW['userid']);

                        include("post.php");
                    }
                    ?>
                    <div class="profile-info-right">
                        <form enctype="multipart/form-data" action="" method="POST">
                            <div class="row g-2" style="padding: 15px 5px;">
                                <div class="col-sm-12 ">
                                    <?php
                                    if ($user_data['userid'] == $_SESSION['friendzone_userid']) {

                                        echo "<textarea id='post' name='post' class='bg-light form-control' rows='1' style='width: 100%; border-radius:6px; padding:10px; border:none;' placeholder='Comment'></textarea>";
                                    }
                                    ?>
                                </div>

                                <div class="col-sm-6">

                                    <input type="hidden" name="parent" style="display:none" value="<?php echo $ROW['postid'] ?>">

                                    <button type="button" class="btn btn-outline-secondary w-100 form-control" onclick="document.getElementById('getFile').click()"><img src="images/addimage.png" width="20" /> Photo</button>
                                    <input type="file" name="file" id="getFile" style="display:none">

                                </div>
                                <div class="col-sm-6">
                                    <input type="submit" id="post_button" value="Post" class="btn btn-primary w-100 form-control">
                                </div>
                            </div>
                        </form>

                    </div>
                    <?php
                    $comments = $Post->get_comments($ROW['postid']);
                    if (is_array($comments)) {
                        foreach ($comments as $COMMENT) {
                            $ROW_USER = $user->get_user($COMMENT['userid']);
                            include("comment.php");
                        }
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>




    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>