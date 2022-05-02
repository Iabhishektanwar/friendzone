<nav class="navbar sticky-top navbar-expand-sm navbar-light bg-light">
    <div class="container">
        <a href="index.php" class="navbar-brand mb-0 h1">
            <img src="images/logo.png" width="50" height="50" class="d-inline-block align-top" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav  me-auto mb-2 mb-lg-0">
                <li class="nav-item active"></li>
            </ul>
            <div class="d-flex align-items-center">
                <?php if (isset($USER) && $USER["first_name"] != "") : ?>
                    <ul class="navbar-nav  me-auto mb-2 mb-lg-0">

                        <div class="input-group rounded" style="margin-right: 20px;">
                            <form method="get" , action="search.php">
                                <input type="text" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" id="search_box" name="find" />
                            </form>
                        </div>


                        <?php
                        $image = "images/defaultpic.svg";
                        if (file_exists($USER['profile_image']) && file_exists($USER['profile_image'])) {
                            $image = $USER['profile_image'];
                        }

                        ?>

                        <a href="profile.php" class="nav-link"><img src="<?php echo $image ?>" alt="Account" style="width: 30px;border-radius:50%"></a>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img src="images/setting.svg" alt="Account" style="width: 30px;"></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a href="index.php" class="dropdown-item"><img src="images/house.svg" alt="Account" style="padding-right: 15px; width: 40px;"> Home</a></li>
                                <li><a href="logout.php" class="dropdown-item"><img src="images/logout.svg" alt="Account" style="padding-right: 15px; width: 40px;"> Logout</a></li>
                            </ul>
                        </li>

                    </ul>
                <?php else : ?>
                    <ul class="navbar-nav  me-auto mb-2 mb-lg-0">
                        <a href="signin.php" class="btn btn-light form-control" style="width:120px; margin-right: 10px">Sign In</a>
                        <a href="signup.php" class="btn btn-primary form-control" style="width:120px">Sign Up</a>
                    </ul>

                <?php endif; ?>
            </div>
        </div>

    </div>
</nav>