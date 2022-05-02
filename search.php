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

if (isset($_GET['find'])) {
    $find = addslashes($_GET['find']);
    $sql = "select * from users where first_name like '%$find%' or last_name like '%$find%' limit 30";
    $DB = new Database();
    $results = $DB->read($sql);
} else {
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
    <title>Likes | FriendZone</title>
</head>

<body>
    <?php include("navigation.php"); ?>

    <div id="profile">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">

                    <?php
                    $User = new User();
                    if (is_array($results)) {
                        foreach ($results as $row) {
                            $FRIEND_ROW = $User->get_user($row['userid']);
                            echo "<br>";
                            include("user.php");
                        }
                    } else {
                        echo "<div class='post border-bottom p-3 bg-light w-shadow text-center' style='border-radius: 8px; margin-top: 20px;'> No results were found
                            </div>";
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