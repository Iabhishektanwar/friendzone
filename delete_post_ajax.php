<?php
include("classes/autoload.php");
$postid = $_GET['id'];
$post = new Post();
$post->delete_post($postid);
