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
    <?php
    include "connectToSQL.php";
    session_start();
    $article_id = $_GET['article_id'];
    $arrOpt = [
        // array topic
        "Choose Your Topic",
        "Pet Health Care",
        "Pet Exercise & Play",
        "Pet First Aid & Emergency Case",
        "Pet Nutrition & Diet",
        "Pet Fun Facts",
        "Pet Events",
        "Other"
    ];

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        echo "<script>alert('Anda harus login terlebih dahulu'); window.location.href = 'signin2.php';</script>";
        exit;
    }
    if (isset($_POST['edit'])) {
        $topic = "";
        if (isset($_POST['other-topic'])) {
            $topic = $_POST['other-topic'];
        } else {
            $topic = $_POST['article_topic'];
        }
        $article_id = $_POST['article_id'];
        $title = $_POST['article_title'];
        $newArticle = $_POST['new_article'];
        $article_pic = $_POST["hidden_name_pic"];
        if (!empty($_FILES['article_pic']['name'])) {
            $article_pic = basename($_FILES['article_pic']['name']); // ambil nama file dari $_FILES['article_pic']
            $tmp_pict = $_FILES['article_pic']['tmp_name'];
            move_uploaded_file($tmp_pict, "postArticle/imgArticle/" . $article_pic);
        }

        // Cek apakah judul artikel sudah ada di database
        $sql = "SELECT * FROM article WHERE article_title = '$title' AND user_id != '{$_SESSION['user_id']}'";
        $result = mysqli_query($connectToSQL, $sql);
        if (mysqli_num_rows($result) > 0) {
            $error = "Judul artikel sudah digunakan oleh user lain.";
        } else {
            $publishDate = date('Ymd');
            $folder = "postArticle/fileArticle/";
            $sql = "SELECT article_filename FROM article WHERE article_id = '$article_id'";
            $result2 = mysqli_query($connectToSQL, $sql);
            $dataDb = mysqli_fetch_assoc($result2);
            unlink($folder . $dataDb['article_filename'] . ".txt"); //buat ganti nama file yang lama
            $filename = $user_id . '_' . $publishDate . "_" . str_replace(' ', '_', $title);
            $target_file = $folder . $filename . ".txt";
            $file = fopen($target_file, "w");
            fwrite($file, $newArticle);
            fclose($file);

            if (file_exists($target_file)) {
                $sql = "UPDATE article SET article_topic = '$topic', article_title = '$title', article_pic = '$article_pic', article_filename = '$filename', publish_date = '$publishDate' WHERE article_id = '$article_id'";
                if (mysqli_query($connectToSQL, $sql)) {
                    echo "<script>alert('Artikel Anda berhasil dipublish'); window.location.href = 'blog.php?info=';</script>";
                    exit;
                } else {
                    echo ("There something wrong: " . mysqli_error($connectToSQL));
                }
            } else {
                echo "There was an error uploading your file.";
            }
        }
    }
    $sql = "SELECT * FROM article WHERE article_id = '$article_id'";
    $result = mysqli_query($connectToSQL, $sql);

    $data = mysqli_fetch_assoc($result);
    ?>
    <!-- Navbar Start -->
    <?php include "navbar.php"?>
    <!-- Navbar End -->


    <!-- Edit Article Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">New Post</h6>
                <h1 class="display-5 text-uppercase mb-0">Drop Your Article Now</h1>
            </div>
            <div class="row g-5">
                <div class="col-lg-7">
                    <?php if (isset($error)): ?>
                        <div style="color:red;">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <select onchange="gantiValue()" name="article_topic"
                                    class="form-control bg-light border-0">
                                    <?php foreach ($arrOpt as $val) { ?>
                                        <option value="<?= $val ?>" <?= $val == $data['article_topic'] ? "selected" : (!in_array($data['article_topic'], $arrOpt) && $val == "Other" ? "selected" : "") ?>><?= $val ?></option>
                                        <!-- selected itu kyk atribut ex. required -->
                                    <?php } ?>
                                </select>
                                <div id="other">
                                    <?php
                                    if (!in_array($data['article_topic'], $arrOpt)) {
                                        echo "<div class='col-12 col-sm-6' style='margin-top:5px'><input type='text' name='other-topic' id='other-topic' class='form-control bg-light border-0' placeholder='Other topic' value='{$data['article_topic']}'></div>";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="text" class="form-control bg-light border-0" name="article_title"
                                    placeholder="Your Article Title" value="<?php echo $data['article_title']; ?>"
                                    style="height: 55px;" required>
                            </div>
                            <div class="col-12">
                                <textarea required class="form-control bg-light border-0 px-4 py-3" name="new_article"
                                    rows="8" placeholder="Type Your Article"><?php
                                    $dbPath = $data['article_filename']; //get dari db
                                    $path = "postArticle/fileArticle/$dbPath" . ".txt";
                                    $a = fopen($path, "r");
                                    while ($line = fgets($a)) {
                                        echo $line;
                                    } ?></textarea>
                            </div>
                            <div class="col-12">
                                <input type="file" name="article_pic" class="form-control bg-light border-0 px-4" />
                                <input type="hidden" name="hidden_name_pic" value="<?= $data['article_pic'] ?>" />
                                <input type="hidden" name="article_id" value="<?= $article_id ?>" />
                                <!-- biar ga keliatan dan bisa get value -->
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit" name="edit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Article End -->


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
        function gantiValue() {
            var selectedValue = document.querySelector('select[name="article_topic"]').value;
            if (selectedValue == '7') {
                document.getElementById("other").innerHTML = `<div class="col-12 col-sm-6" style="margin-top:5px"><input type="text" name="other-topic" id="other-topic" class="form-control bg-light border-0" placeholder="Other topic"></div>`
            } else {
                document.getElementById("other").innerHTML = ""
            }
        }
    </script>
</body>

</html>