<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>MOVIE MINGGLE</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="Free HTML Templates" name="keywords" />
  <meta content="Free HTML Templates" name="description" />

  <!-- Favicon -->
  <link href="img/favicon.ico" rel="icon" />

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet" />

  <!-- Icon Font Stylesheet -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="lib/flaticon/font/flaticon.css" rel="stylesheet" />

  <!-- Libraries Stylesheet -->
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />

  <!-- Customized Bootstrap Stylesheet -->
  <link href="css/bootstrap.min.css" rel="stylesheet" />

  <!-- Template Stylesheet -->
  <link href="css/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/profile.css">
</head>
<!-- Navbar End -->

<body>
  <!-- SIGN UP DISINI -->
  <?php

  session_start(); 
  include "connectToSQL.php";

  if (isset($_POST['password'], $_POST['password2']) && $_POST['password'] != $_POST['password2']) {
    echo "<script>alert('Maaf! password yang anda input tidak sama'); window.location.href = 'signup2.php';</script>";
    exit;
  }
  
  if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['email']) && isset($_FILES['profile_picture'])) {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['password2'] = $_POST['password2']; //ini buat validasi tidak kebaca di database, yang kebaca password
    $_SESSION['email'] = $_POST['email'];

    $username = $_SESSION['username'];
    $password = md5($_SESSION['password']);
    $password2 = $_SESSION['password2'];
    $email = $_SESSION['email'];
    $pfp = "pfp.jpg";

    $row = mysqli_query($connectToSQL, "SELECT * FROM users WHERE username = '$username';");
    $ngambilrownya = mysqli_fetch_assoc($row);

    if (isset($ngambilrownya['username'])) {
      echo "<script>alert('username yang anda input sudah ada, silahkan input ulang'); window.location.href = 'signup2.php';</script>";
      exit;
    }
    if (!empty($_FILES['profile_picture']['name'])) {
      $pfp = basename($_FILES['profile_picture']['name']);
      $tmp_pict = $_FILES['profile_picture']['tmp_name'];
      move_uploaded_file($tmp_pict, "imgSignUp/" . $pfp);
    }

    // query SQL untuk menyimpan data ke dalam database
    $sql = "INSERT INTO users (username, password, email, profile_picture) VALUES ('$username', '$password', '$email', '$pfp')";

    if (mysqli_query($connectToSQL, $sql)) {
      $_SESSION['user_id'] = $ngambilrownya['user_id']; // store the user ID in a session variable
      setcookie('username', $ngambilrownya['username'], time() + (3600 * 5), '');
      $_SESSION['profile_picture'] = $pfp;
      setcookie('profile_picture', $pfp, time() + (3600 * 5), '');
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($connectToSQL);

    // redirect ke halaman sign in
    echo "<script>alert('Akun berhasil di buat silahkan login!'); window.location.href = 'index.php';</script>";
  }
  ?>
  <!-- SIGN UP END -->
  
  <!-- Navbar Start -->
  <?php include "navbar.php"?>
  <!-- Navbar End -->

  <!-- Contact Start -->
  <div class="container-fluid pt-5">
    <div class="container">
      <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px">
        <h6 class="text-primary text-uppercase">Sign Up</h6>
        <h1 class="display-5 text-uppercase mb-0">Sign UP To Your Account</h1>
      </div>
      <div class="row g-5">
        <div class="col-lg-7">
          <!-- FORM DARI SINI -->
          <form method="POST" action="signup2.php" enctype="multipart/form-data">
            <div class="row g-3">
              <div class="col-12">
                <input type="text" name="username" class="form-control bg-light border-0 px-4" placeholder="Your Name"
                  style="height: 55px" />
              </div>
              <div class="col-12">
                <input type="password" name="password" class="form-control bg-light border-0 px-4"
                  placeholder="Password" style="height: 55px" />
              </div>
              <div class="col-12">
                <input type="password" name="password2" class="form-control bg-light border-0 px-4"
                  placeholder="Retype-Password" style="height: 55px" />
              </div>
              <div class="col-12">
                <input type="email" name="email" class="form-control bg-light border-0 px-4" placeholder="Email"
                  style="height: 55px" />
              </div>
              <div class="col-12">
                <input type="file" accept="image/*" name="profile_picture" class="form-control bg-light border-0 px-4"
                  placeholder="Password" style="height: 55px" />
              </div>
              <div class="col-12">
                <button class="btn btn-primary w-100 py-3" type="submit" name="submit">
                  Sign Up
                </button>
              </div>
              <p>Sudah punya akun ?</p>
              <a href="signin2.php">klik ini</a>
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