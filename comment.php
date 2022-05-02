<div class="post border-bottom p-3 bg-light w-shadow" style="border-radius: 8px; margin-bottom: 10px; margin-top:10px;">
    <div class="media text-muted pt-3" style="display: flex;">
        <?php
        $image = "images/user_default.png";
        if (file_exists($ROW_USER['profile_image'])) {
            $image = $ROW_USER['profile_image'];
        }

        ?>

        <img src="<?php echo $image ?>" alt="Online user" class="mr-3 post-user-image" style="width: 55px;height: 55px; margin-right: 15px; border-radius:50%">
        <div class="media-body pb-3 mb-0 small lh-125" style="width: 100%;">
            <ul style="margin: 0; padding: 0; list-style: none;">
                <li style="margin: 0; padding: 0;">
                    <span class="post-type text-muted" style="font-size: 16px;"><a href="profile.php?id=<?php echo $ROW_USER['userid'] ?>" style="text-decoration: none; color: black;"><b>
                                <?php
                                echo htmlspecialchars($ROW_USER['first_name']) . " " . htmlspecialchars($ROW_USER['last_name']);
                                if ($COMMENT['is_profile_image']) {
                                    echo "<sapn style='font-weight:normal;color:#6c757d;font-size: 13px;'> updated profile image</sapn>";
                                }
                                if ($COMMENT['is_cover_image']) {
                                    echo "<sapn style='font-weight:normal;color:#6c757d;font-size: 13px;'> updated cover image</sapn>";
                                }

                                ?>
                            </b></a></span>

                </li>
                <li style="margin: 0; padding: 0;">
                    <span><?php echo $COMMENT['date'] ?></span>
                    <span style='float:right'>
                        <?php
                        $post = new Post();
                        if ($post->i_own_post($COMMENT['postid'], $_SESSION['friendzone_userid'])) {
                            echo "
                            <a href='edit.php?id=$COMMENT[postid]' style='text-decoration: none; color:#6c757d;'>
                                Edit
                            </a> /";
                        }
                        if (i_own_content($COMMENT)) {
                            echo "<a href='delete.php?id=$COMMENT[postid]' style='text-decoration: none;color:#6c757d;'>
                                Delete
                            </a>";
                        }

                        ?>
                    </span>
                </li>
            </ul>
        </div>
    </div>
    <div class="mt-3">
        <p><?php echo htmlspecialchars($COMMENT['post']) ?></p>

        <?php
        if (file_exists($COMMENT['image'])) {
            $im = $COMMENT['image'];
            // $post_image = $image_class->get_thumb_post($ROW['image']);
            echo "<img src='$im' style='width:100%'>";
        }

        ?>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-6 text-start">
            <a href="like.php?type=post&id=<?php echo $COMMENT['postid'] ?>" style='text-decoration: none; color:black'>
                <?php

                if ($COMMENT['likes'] > 0) {
                    $likes = $COMMENT['likes'];
                } else {
                    $likes = "";
                }
                ?>
                <i class=" far fa-thumbs-up"></i>
                <span>Like <?php echo $likes ?></span>
            </a>
            <div>
                <?php
                $i_liked = false;
                if (isset($_SESSION['friendzone_userid'])) {
                    $DB = new Database();
                    $query = "select likes from likes where type ='post' && contentid = '$COMMENT[postid]' limit 1";
                    $result = $DB->read($query);
                    if (is_array($result)) {
                        $likes = json_decode($result[0]['likes'], true);
                        $user_ids = array_column($likes, 'userid');

                        if (in_array($_SESSION['friendzone_userid'], $user_ids)) {
                            $i_liked = true;
                        }
                    }
                }


                if ($COMMENT['likes'] > 0) {

                    echo "<a href='likes.php?type=post&id=$COMMENT[postid]' style='text-decoration:none'>";


                    if ($COMMENT['likes'] == 1) {
                        echo "<br>";

                        if ($i_liked) {
                            echo "<span style='text-decoration: none; color:#6c757d; font-size: 12px;'>You liked this post</span>";
                        } else {
                            echo "<span style='text-decoration: none; color:#6c757d; font-size: 12px;'>1 person liked this post</span>";
                        }
                    } else {
                        echo "<br>";
                        if ($i_liked) {
                            $text = "others";
                            if (($COMMENT['likes'] - 1) == 1) {
                                $text = "other";
                            }
                            echo "<span style='text-decoration: none; color:#6c757d; font-size: 12px;'>You and " . ($COMMENT['likes'] - 1) . " " . $text . " liked this post</span>";
                        } else {
                            echo "<span style='text-decoration: none; color:#6c757d; font-size: 12px;'>" . $COMMENT['likes'] . " people liked this post</span>";
                        }
                    }
                    echo "</a>";
                }
                ?>

            </div>

        </div>
    </div>

</div>