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
    <!-- <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet"> -->

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
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        header("Location: signin2.php");
        exit;
    }

    if (isset($user_id) && isset($_POST['petname']) && isset($_POST['category']) && isset($_POST['species']) && isset($_POST['age']) && isset($_POST['desc']) && isset($_POST['price']) && isset($_FILES['petpic'])) {
        $petname = $_POST['petname'];
        $category = $_POST['category'];
        $species = $_POST['species'];
        $age = $_POST['age'];
        $description = $_POST['desc'];
        $price = $_POST['price'];
        // $pet_pic = $_FILES['petpic']['tmp_name'];
        $pet_pic = addslashes(file_get_contents($_FILES['petpic']['tmp_name']));

        // Prepare the SQL statement with placeholders
        $sql = "INSERT INTO adopt (user_id, pet_name, category, species, age, description, price, pet_pic, status) VALUES ('$user_id', '$petname', '$category', '$species', '$age', '$description', '$price', '$pet_pic', 'Available')";
        if (mysqli_query($connectToSQL, $sql)) {
            // exit;
            header("Location: adopt.php");
            // echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connectToSQL);
        }       
    }
    // mysqli_stmt_close($stmt);
    mysqli_close($connectToSQL);
    ?>

    <!-- Navbar Start -->
    <?php include "navbar.php"?>
    <!-- Navbar End -->


    <!-- SIgn Up Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
            <h6 class="text-primary text-uppercase">Adoption</h6>
            <h1 class="display-5 text-uppercase mb-0">Sign Up Your Pet For Adoption</h1>
            </div>
            <div class="row g-5">
                <div class="col-lg-7">
                    <form method="POST" enctype='multipart/form-data'>
                        <div class="row g-3">
                            <div class="col-12">
                                <input type="text" name="petname" class="form-control bg-light border-0 px-4"
                                    placeholder="Name" style="height: 55px;">
                            </div>
                            <div class="col-12">
                                <input type="text" name="category" class="form-control bg-light border-0 px-4"
                                    placeholder="Category" style="height: 55px;">
                            </div>
                            <div class="col-12">
                                <input type="text" name="species" class="form-control bg-light border-0 px-4"
                                    placeholder="Species" style="height: 55px;">
                            </div>
                            <div class="col-12">
                                <input type="text" name="age" class="form-control bg-light border-0 px-4"
                                    placeholder="Age" style="height: 55px;">
                            </div>
                            <div class="col-12">
                                <input type="text" name="desc" class="form-control bg-light border-0 px-4"
                                    placeholder="Description ur pet and drop ur contact" style="height: 55px;">
                            </div>
                            <div class="col-12">
                                <input type="text" name="price" class="form-control bg-light border-0 px-4"
                                    placeholder="Price" style="height: 55px;">
                            </div>
                            <div class="col-12">
                                <input type="file" name="petpic" class="form-control bg-light border-0 px-4"
                                    placeholder="Pet Picture" style="height: 55px;">
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Sign Up Pet For
                                    Adoption</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- SIgn Up End -->

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