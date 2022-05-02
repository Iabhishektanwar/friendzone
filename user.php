<div class="post border-bottom p-3 bg-light w-shadow" style="border-radius: 8px; margin-bottom: 5px;" id="friends">
    <div class="media text-muted" style="display: flex;align-items:center;">
        <?php
        $image = "images/defaultpic.svg";
        if (file_exists($FRIEND_ROW['profile_image'])) {
            $image = $FRIEND_ROW['profile_image'];
        }

        ?>
        <a href="profile.php?id=<?php echo $FRIEND_ROW['userid']; ?> ">
            <img id="friends_img" style="width:60px; float:left;margin:8px; border-radius:50%;" src="<?php echo $image ?>">

            <span class="post-type text-muted" style="font-size: 16px;"><a href="profile.php?id=<?php echo $FRIEND_ROW['userid'] ?>" style="text-decoration: none; color: black;"><b>
                        <?php
                        echo htmlspecialchars($FRIEND_ROW['first_name']) . " " . htmlspecialchars($FRIEND_ROW['last_name']);

                        ?>
                    </b>
                </a>
            </span>
        </a>
    </div>
</div>