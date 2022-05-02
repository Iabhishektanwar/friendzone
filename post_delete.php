<div class="post border-bottom p-3 bg-light w-shadow" style="border-radius: 8px; margin-top: 20px;">
    <div class="media text-muted pt-3" style="display: flex;">
        <?php
        $image = "images/user_default.png";
        if (file_exists($user_data['profile_image'])) {
            $image = $user_data['profile_image'];
        }

        ?>
        <img src="<?php echo $image ?>" alt="Online user" class="mr-3 post-user-image" style="width: 55px;height: 55px; margin-right: 15px; border-radius:50%">
        <div class="media-body pb-3 mb-0 small lh-125" style="width: 100%;">
            <ul style="margin: 0; padding: 0; list-style: none;">
                <li style="margin: 0; padding: 0;">
                    <span class="post-type text-muted" style="font-size: 16px;"><a href="profile.php?id=<?php echo $ROW_USER['userid'] ?>" style="text-decoration: none; color: black;"><b>
                                <?php
                                echo htmlspecialchars($ROW_USER['first_name']) . " " . htmlspecialchars($ROW_USER['last_name']);
                                if ($ROW['is_profile_image']) {
                                    echo "<sapn style='font-weight:normal;color:#6c757d;font-size: 13px;'> updated profile image</sapn>";
                                }
                                if ($ROW['is_cover_image']) {
                                    echo "<sapn style='font-weight:normal;color:#6c757d;font-size: 13px;'> updated cover image</sapn>";
                                }

                                ?>
                            </b></a></span>

                </li>
                <li style="margin: 0; padding: 0;">
                    <span><?php echo $ROW['date'] ?></span>

                </li>
            </ul>
        </div>
    </div>
    <div class="mt-3">
        <p><?php echo htmlspecialchars($ROW['post']) ?></p>

        <?php
        if (file_exists($ROW['image'])) {
            $im = $ROW['image'];
            echo "<img src='$im' style='width:100%'>";
        }

        ?>
    </div>

</div>