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

if (isset($_SERVER['HTTP_REFERER'])) {
    $return_to = $_SERVER['HTTP_REFERER'];
} else {
    $return_to = "profile.php";
}
if (isset($_GET['type']) && isset($_GET['id'])) {
    if (is_numeric($_GET['id'])) {
        $allowed[] = "post";
        $allowed[] = "user";
        $allowed[] = "comment";

        if (in_array($_GET['type'], $allowed)) {
            $post = new Post();
            $post->like_post($_GET['id'], $_GET['type'], $_SESSION['friendzone_userid']);
        }
    }
}

header("Location: " . $return_to);
die;
