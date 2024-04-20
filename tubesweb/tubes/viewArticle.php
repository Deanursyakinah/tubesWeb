<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MOVIE SHOP - Movie Shopping Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/profile.css">

</head>

<body>
    <?php
    include "connectToSQL.php";
    session_start();
    $sql = "SELECT * FROM article";
    if (isset($_REQUEST['article_id'])) {
        $article_id = $_REQUEST['article_id'];
        $sql = "SELECT * FROM article WHERE article_id = $article_id";
        $query = mysqli_query($connectToSQL, $sql);
    }
    $query = mysqli_query($connectToSQL, $sql);
    $q = mysqli_fetch_assoc($query);
    ?>
    <!-- Navbar Start -->
    <?php include "navbar.php"?>
    <!-- Navbar End -->


    <!-- Blog Start -->
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-8">
                <!-- Blog Detail Start -->
                <div class="mb-5">
                    <img class="img-fluid w-100 rounded mb-5"
                        src="postArticle/imgArticle/<?php echo $q['article_pic']; ?>" alt="">
                    <p style="text-align: right;">Uploaded by <strong>
                            <?php
                            $queryUsername = "SELECT username FROM user WHERE user_id = '{$q['user_id']}'";
                            $querySql = mysqli_query($connectToSQL, $queryUsername);
                            $username = mysqli_fetch_assoc($querySql)['username'];
                            echo $username;
                            ?>
                        </strong></p>
                    <h1 class="text-uppercase mb-4">
                        <?php echo $q['article_title'] ?>
                    </h1>
                    <p>
                        <?php
                        $dbPath = $q['article_filename']; //get dari db
                        $path = "postArticle/fileArticle/$dbPath" . ".txt";
                        $data = fopen($path, "r");
                        while ($line = fgets($data)) {
                            echo $line;
                        }
                        ?>
                    </p>
                    <!-- line yg diatas ini untuk tampilin artikel yang ditulis sama user -->
                    <?php if (isset($_COOKIE['username']) && $_COOKIE['username'] == $username) { ?>
                        <a href="editArticle.php?article_id=<?php echo $q['article_id']; ?>">
                            <input type="submit" name="edit" class="btn btn-primary"
                                style="margin-bottom: 10px; color: #FFF; margin: 0px 10px 10px 0px;  text-align: center; font-family:Roboto, sans-serif; font-size: 18px; text-align: center;"
                                value="Edit">
                        </a>
                        <button
                            style="margin-bottom: 10px; color: #FFF; margin: 0px 10px 10px 0px; text-align: center; font-family:Roboto, sans-serif; font-size: 18px; text-align: center;"
                            class="btn btn-primary" onclick="deletePost(<?= $q['article_id']; ?>)">Delete</button>
                    <?php } ?>
                </div>
            </div>

            <!-- Sidebar Start -->

        </div>
    </div>


    <!-- Footer Start -->
    <?php include "footer.php"?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
    function deletePost(id) {
        let bool = confirm("Apakah Anda yakin untuk menghapus artikel ini?");
        if (bool) {
            location.href = "deleteArticle.php?article_id=" + id; 
        }
    }   
    </script>
</body>

</html>