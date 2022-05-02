<?php

function pagination_link()
{
    $arr['next_page'] = "";
    $arr['previous_page'] = "";

    $page_number = 1;
    if (isset($_GET['page'])) {
        $page_number = (int)$_GET['page'];
    }
    if ($page_number < 1) {
        $page_number = 1;
    }

    $url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];
    $url .= "?";
    $num = 0;

    $next_page_link = $url;
    $previous_page_link = $url;
    $page_found = false;
    foreach ($_GET as $key => $value) {
        $num++;

        if ($num == 1) {
            if ($key == "page") {
                $next_page_link .= $key . "=" . ($page_number + 1);
                $previous_page_link .= $key . "=" . ($page_number - 1);
                $page_found = true;
            } else {
                $next_page_link .= $key . "=" . $value;
                $previous_page_link .= $key . "=" . $value;
            }
        } else {
            if ($key == "page") {
                $next_page_link .= "&" . $key . "=" . ($page_number + 1);
                $previous_page_link .= "&" . $key . "=" . ($page_number - 1);
                $page_found = true;
            } else {
                $next_page_link .= "&" . $key . "=" . $value;
                $previous_page_link .= "&" . $key . "=" . $value;
            }
        }
    }

    $arr['next_page'] = $next_page_link;
    $arr['previous_page'] = $previous_page_link;
    if (!$page_found) {
        $arr['next_page'] = $next_page_link . "&page=2";
        $arr['previous_page'] = $previous_page_link . "&page=1";
    }

    return $arr;
}

function i_own_content($row)
{
    $myid = $_SESSION['friendzone_userid'];

    if ($myid == $row['userid']) {
        return true;
    }

    if (isset($row['postid'])) {
        if ($myid == $row['userid']) {
            return true;
        } else {
            $Post = new Post();
            $one_post = $Post->get_one_post($row['parent']);

            if ($myid == $one_post) {
                return true;
            }
        }
    }

    return false;
}
