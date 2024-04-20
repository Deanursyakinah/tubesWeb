<!DOCTYPE html>
<html lang="en">

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
<!-- Navbar End -->

<body>
    <!-- INI SIGN IN -->
    <?php
    session_start(); 
    include "connectToSQL.php";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        //check kalau user udah ada dan pw nya bener
        $query = "SELECT * FROM users WHERE username = '$username';";
        $result = mysqli_query($connectToSQL, $query);

        // if the query returns a row, the user is authenticated
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) == 1) {
            $_SESSION['user_id'] = $row['user_id']; // store the user ID in a session variable
            setcookie('username', $row['username'], time() + (3600 * 5), "");
            setcookie('profile_picture', $row['profile_picture'], time() + (3600 * 5), "");
    
            echo "<script>alert('Login berhasil'); window.location.href = 'index.php';</script>";
            exit;
        } else {
            echo "<script>alert('Username atau password salah');</script>";
        }
    }
    ?>
    <!-- SIGN IN END -->

    <!-- Navbar Start -->
    <?php include "navbar.php"?>
    <!-- Navbar End -->

    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Sign In</h6>
                <h1 class="display-5 text-uppercase text-white mb-0">Sign in to your account</h1>
                <!-- <h1 class="display-5 text-uppercase mb-0">Sign In To Your Account</h1> -->
            </div>
            <div class="row g-5">
                <div class="col-lg-7">
                    <!-- FORM NYA -->
                    <form method="POST" action="signin2.php">
                        <div class="row g-3">
                            <div class="col-12">
                                <input type="text" name="username" class="form-control bg-light border-0 px-4"
                                    placeholder="Your Name" style="height: 55px;">
                            </div>
                            <div class="col-12">
                                <input type="password" name="password" class="form-control bg-light border-0 px-4"
                                    placeholder="Password" style="height: 55px;">
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Sign In</button>
                            </div>
                            <p>Belum punya akun? <a href="signup2.php">klik ini</a></p>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

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