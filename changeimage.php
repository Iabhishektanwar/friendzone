<?php

if (isset($_GET['change']) && ($_GET['change'] == "profile" || $_GET['change'] == "cover")) {

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
