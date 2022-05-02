<?php

$login = new Login();
$_SESSION['friendzone_userid'] = isset($_SESSION['friendzone_userid']) ? $_SESSION['friendzone_userid'] : 0;
$user_data = $login->check_login($_SESSION['friendzone_userid'], false);

//check if not logged in
if ($_SESSION['friendzone_userid'] == 0) {
    $obj = (object)[];
    $obj->action = "like_post";

    echo json_encode($obj);
    die;
}

$query_string = explode("?", $data->link);
$query_string = end($query_string);

$str = explode("&", $query_string);
foreach ($str as $value) {
    $value = explode("=", $value);
    $_GET[$value[0]] = $value[1];
}

$_GET['id'] = addslashes($_GET['id']);
$_GET['type'] = addslashes($_GET['type']);
if (isset($_GET['type']) && isset($_GET['id'])) {
    $post = new Post();
    if (is_numeric($_GET['id'])) {
        $allowed[] = "post";
        $allowed[] = "user";
        $allowed[] = "comment";

        if (in_array($_GET['type'], $allowed)) {

            $post->like_post($_GET['id'], $_GET['type'], $_SESSION['friendzone_userid']);
        }
    }

    $likes = $post->get_likes($_GET['id'], $_GET['type']);

    //create info
    $likes = array();
    $info = "";
    $i_liked = false;
    if (isset($_SESSION['friendzone_userid'])) {
        $DB = new Database();
        $query = "select likes from likes where type ='post' && contentid = '$_GET[id]' limit 1";
        $result = $DB->read($query);
        if (is_array($result)) {
            $likes = json_decode($result[0]['likes'], true);
            $user_ids = array_column($likes, 'userid');

            if (in_array($_SESSION['friendzone_userid'], $user_ids)) {
                $i_liked = true;
            }
        }
    }

    $like_count = count($likes);
    if ($like_count > 0) {

        $info .= "<br>";


        if ($like_count == 1) {

            if ($i_liked) {
                $info .= "<span style='text-decoration: none; color:#6c757d; font-size: 12px;'>You liked this post</span>";
            } else {
                $info .= "<span style='text-decoration: none; color:#6c757d; font-size: 12px;'>1 person liked this post</span>";
            }
        } else {
            if ($i_liked) {
                $text = "others";
                if (($like_count - 1) == 1) {
                    $text = "other";
                }
                $info .= "<span style='text-decoration: none; color:#6c757d; font-size: 12px;'>You and " . ($like_count - 1) . " " . $text . " liked this post</span>";
            } else {
                $info .= "<span style='text-decoration: none; color:#6c757d; font-size: 12px;'>" . $like_count . " people liked this post</span>";
            }
        }
    }

    /////
    $obj = (object)[];
    $obj->likes = count($likes);
    $obj->action = "like_post";
    $obj->info = $info;
    $obj->id = "info_$_GET[id]";
    echo json_encode($obj);
}
