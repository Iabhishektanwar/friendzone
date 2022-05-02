<?php
session_start();

if (isset($_SESSION['friendzone_userid'])) {
    $_SESSION['friendzone_userid'] = NULL;
    unset($_SESSION['friendzone_userid']);
}

header("Location: signin.php");
die;
