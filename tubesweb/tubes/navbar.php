<nav class="navbar navbar-expand-lg bg-dark2 navbar-light shadow-sm py-3 py-lg-0 px-3 px-lg-0">
    <a href="index.php" class="navbar-brand ms-lg-5">
        <div>
            <?php if (isset ($_COOKIE['username'])) { ?>
                <img class="profile-pic" src="imgSignUp/<?php echo $_COOKIE['profile_picture']; ?>" alt="Profile Picture">
                <span class="username">
                    <?php echo $_COOKIE['username']; ?>
                </span>
            <?php } ?>
        </div>
    </a>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0">
            <a href="index.php" class="nav-item nav-link">Home</a>
            <a href="blog.php" class="nav-item nav-link">Article</a>
            <a href="infoMov.php" class="nav-item nav-link">Info Film</a>
            <a href="discuss.php" class="nav-item nav-link">Discussion</a>
            <a href="adopt.php" class="nav-item nav-link">Wishlist</a>
            <?php if (isset ($_COOKIE['username'])) { ?>
                <form action="" method="post">
                    <button type="submit" name="submit"
                        class="btn nav-item nav-link nav-contact bg-primary text-white px-5 ms-lg-5">LOG OUT</button>
                </form>
            <?php } else { ?>
                <a href="signin2.php" class="nav-item nav-link nav-contact bg-primary text-white px-5 ms-lg-5">LOGIN
                    <i class="bi bi-arrow-right"></i></a>
            <?php } ?>
        </div>
    </div>
</nav>