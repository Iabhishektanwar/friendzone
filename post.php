<!-- Delete post modal -->
<div class="modal fade" id="deletepostmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this post?
            </div>
            <div class="modal-footer">
                <input type="hidden" id="delete_id">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="delete_post()">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- post content -->
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
                    <span style='float:right'>
                        <?php
                        $post = new Post();
                        if ($post->i_own_post($ROW['postid'], $_SESSION['friendzone_userid'])) { ?>

                            <a href="edit.php?id=<?php echo $ROW['postid'] ?>" style='text-decoration: none; color:#6c757d;' style="margin-right: 15px;">
                                Edit
                            </a>
                            <a onclick='deletepostajax(event, <?php echo $ROW["postid"] ?>)' data-bs-toggle="modal" data-bs-target="#deletepostmodal" href="delete.php?id=<?php echo $ROW['postid'] ?>" style='text-decoration: none;color:#6c757d;'>
                                Delete
                            </a>
                        <?php } ?>

                    </span>
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
    <br>
    <div class="row">
        <div class="col-sm-6 text-start">
            <i class=" far fa-thumbs-up"></i>
            <a href="like.php?type=post&id=<?php echo $ROW['postid'] ?>" style='text-decoration: none; color:black' onclick='like_post(event)'>
                <?php

                if ($ROW['likes'] > 0) {
                    $likes = $ROW['likes'];
                } else {
                    $likes = "";
                }
                ?>

                Like <?php echo $likes ?>
            </a>
            <div>
                <?php
                $i_liked = false;
                if (isset($_SESSION['friendzone_userid'])) {
                    $DB = new Database();
                    $query = "select likes from likes where type ='post' && contentid = '$ROW[postid]' limit 1";
                    $result = $DB->read($query);
                    if (is_array($result)) {
                        $likes = json_decode($result[0]['likes'], true);
                        $user_ids = array_column($likes, 'userid');

                        if (in_array($_SESSION['friendzone_userid'], $user_ids)) {
                            $i_liked = true;
                        }
                    }
                }

                echo "<a id='info_$ROW[postid]' href='likes.php?type=post&id=$ROW[postid]' style='text-decoration:none'>";
                echo "<br>";

                if ($ROW['likes'] > 0) {



                    if ($ROW['likes'] == 1) {

                        if ($i_liked) {
                            echo "<span style='text-decoration: none; color:#6c757d; font-size: 12px;'>You liked this post</span>";
                        } else {
                            echo "<span style='text-decoration: none; color:#6c757d; font-size: 12px;'>1 person liked this post</span>";
                        }
                    } else {
                        if ($i_liked) {
                            $text = "others";
                            if (($ROW['likes'] - 1) == 1) {
                                $text = "other";
                            }
                            echo "<span style='text-decoration: none; color:#6c757d; font-size: 12px;'>You and " . ($ROW['likes'] - 1) . " " . $text . " liked this post</span>";
                        } else {
                            echo "<span style='text-decoration: none; color:#6c757d; font-size: 12px;'>" . $ROW['likes'] . " people liked this post</span>";
                        }
                    }
                }
                echo "</a>";

                ?>

            </div>

        </div>
        <div class="col-sm-6 text-end">
            <a href="singlepost.php?id=<?php echo $ROW['postid'] ?>" style='text-decoration: none; color:black'>
                <i class="far fa-comment"></i>
                <?php

                if ($ROW['comments'] > 0) {
                    $comments = $ROW['comments'];
                } else {
                    $comments = "";
                }
                ?>
                <span>Comment <?php echo $comments ?></span>
            </a>

        </div>
    </div>

</div>

<script type="text/javascript">
    function deletepostajax(event, id) {
        event.preventDefault();
        document.getElementById('delete_id').value = id;

    }

    function delete_post() {
        var id = document.getElementById('delete_id').value;
        var request = new XMLHttpRequest();
        request.open("GET", "delete_post_ajax.php?id=" + id, true);
        request.send();
        request.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                window.location = 'profile.php';
            }
        };
    }

    function ajax_send(data, element) {
        var ajax = new XMLHttpRequest();
        ajax.addEventListener('readystatechange', function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                response(ajax.responseText, element);
            }
        });
        data = JSON.stringify(data);

        ajax.open("post", "ajax.php", true);
        ajax.send(data);
    }

    function response(result, element) {
        if (result != "") {
            var obj = JSON.parse(result);
            console.log(obj);
            if (typeof obj.action != 'undefined') {
                if (obj.action == 'like_post') {
                    var likes = "";
                    if (typeof obj.likes != 'undefined') {

                        likes = (parseInt(obj.likes) > 0) ? "Like " + obj.likes + " " : "Like";
                        element.innerHTML = likes;
                    }

                    if (typeof obj.info != 'undefined') {
                        var info_element = document.getElementById(obj.id);
                        info_element.innerHTML = obj.info;
                    }
                }
            }
        }
    }

    function like_post(e) {
        e.preventDefault();
        var link = e.target.href;

        var data = {};
        data.link = link;
        data.action = "like_post";

        ajax_send(data, e.target);
    }
</script>