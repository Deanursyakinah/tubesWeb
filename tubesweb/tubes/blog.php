<?php
include "connectToSQL.php";
$sql = "SELECT * FROM article";

if (isset($_POST["search"])) {
    if ($_POST["search"] == "Find") {
        $keyword = $_POST["keyword"];

        $sql = "SELECT * FROM article WHERE article_title LIKE '%$keyword%'"; // %: untuk nyari kemiripan antara karakter depan atau belakang dari text yang dimasukkan user
    }
}
$query = mysqli_query($connectToSQL, $sql);
$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
if (isset($_POST['submit'])) {
    session_start();
    session_unset();
    session_destroy();
    setcookie("profpict", "", 1, "");
    setcookie("username", "", 1, "");
    header('Location: signin2.php');
}
?>

<head>
    <meta charset="utf-8">
    <title>MOVIE MINGGLE</title>
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
    <!-- Navbar Start -->
    <?php include "navbar.php"?>
    <!-- Navbar End -->

    <!-- Blog Start -->
    <div class="container py-5">
        <div style="display:flex;">
            <form method="POST" class="input-group">
                <input type="text" name="keyword" class="form-control p-3" placeholder="Keyword"
                    style="margin-bottom: 10px; ">
                <input type="submit" class="btn btn-primary"
                    style="margin-bottom: 10px; color: #FFF; margin: 0px 5px 10px 0px; padding: 14px 6px; text-align: center; font-family:Roboto, sans-serif; font-size: 18px; text-align: center;"
                    name="search" value="Find">
                <input type="submit" name="reset" class="btn btn-primary"
                    style="margin-bottom: 10px; color: #FFF; margin: 0px 10px 10px 0px;  text-align: center; font-family:Roboto, sans-serif; font-size: 18px; text-align: center;"
                    value="Reset">
            </form>
            <a href="newArticle.php">
                <input type="submit" name="new_post" class="bg-primary new-post"
                    value="NEW POST">
            </a>
        </div>
        <div class="mb-5" style="float: right;">
        </div>
        <div class="row g-5">
            <!-- Blog list Start -->
            <div class="col-lg-8">
                <?php foreach (array_reverse($data) as $q) { ?>
                    <div class="blog-item mb-5">
                        <div class="row g-0 bs-goldbrown overflow-hidden col-article">
                            <div class="col-12 col-sm-5 h-100">
                                <img class="img-fluid h-100"
                                    src="<?php echo "postArticle/imgArticle/" . $q['article_pic'] ?>"
                                    style="object-fit: cover;">
                            </div>
                            <div class="col-12 col-sm-7 h-100 d-flex flex-column justify-content-center">
                                <div class="p-4">
                                    <div class="d-flex mb-3">
                                        <small class="me-3"><i class="bi bi-bookmarks me-2"></i>
                                            <?php echo $q['article_topic']; ?>
                                        </small>
                                        <small><i class="bi bi-calendar-date me-2"></i>
                                            <?php echo $q['publish_date']; ?>
                                        </small>
                                    </div>
                                    <h5 class="text-uppercase mb-3">
                                        <?php echo $q['article_title']; ?>
                                    </h5>
                                    <p class="pblog">
                                        <?php
                                        $dbPath = $q['article_filename']; //get dari db
                                        $path = "postArticle/fileArticle/$dbPath" . ".txt";
                                        $data = fopen($path, "r");
                                        while ($line = fgets($data)) {
                                            echo (substr($line, 0, 50) . " ...");
                                        }
                                        ?>
                                    </p>
                                    <a class="blog-ahref text-uppercase"
                                        href="viewArticle.php?article_id=<?php echo $q['article_id'] ?>">Read More
                                        <!-- <iclass="bi bi-chevron-right"></iclass=>-->
                                        </a> 
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- tag cloud -->
        </div>
    </div>
    <!-- Blog End -->


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
</body>

</html>