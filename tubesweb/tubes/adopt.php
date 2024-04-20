<!DOCTYPE html>
<html lang="en">

<?php
if (isset ($_POST['submit'])) {
    session_start();
    session_unset();
    session_destroy();
    setcookie("profpict", "", 1, "");
    setcookie("username", "", 1, "");
    header('Location: signin2.php');
}

session_start();
if (isset ($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    echo "<script>alert('Anda harus login terlebih dahulu'); window.location.href = 'signin2.php';</script>";
    exit;
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
    <style>
        th {
            color: white;
            font-size: 20px;
        }
        td {
            font-family: fontKetiga;
            src: url(His\ Heart\ is\ Mine.ttf);
            color: white;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    <?php include "navbar.php" ?>
    <!-- Navbar End -->

    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Buy now</h6>
                <h1 class="display-5 text-uppercase text-white mb-0">Your signed up movies</h1>
            </div>
        </div>
    </div>
    <!-- Products End -->

    <!-- User Table Start -->
    <?php
    include "connectToSQL.php";

    $user_id = isset ($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    $sql = "SELECT * FROM adopt WHERE user_id = $user_id";
    $result = $connectToSQL->query($sql);

    if ($result->num_rows > 0):
        ?>

        <div class="table-responsive">
            <table class="table table-striped table-bordered" style="padding: 20px;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Species</th>
                        <th>Age</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Picture</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()):
                        ?>
                        <tr>
                            <td>
                                <?= $row["pet_name"] ?>
                            </td>
                            <td>
                                <?= $row["category"] ?>
                            </td>
                            <td>
                                <?= $row["species"] ?>
                            </td>
                            <td>
                                <?= $row["age"] ?>
                            </td>
                            <td>
                                <?= $row["description"] ?>
                            </td>
                            <td>
                                <?= $row["price"] ?>
                            </td>
                            <td><img src="data:image/jpeg;base64,<?= base64_encode($row['pet_pic']) ?>" height="100px"
                                    width="auto" /></td>
                            <td>
                                <?= $row["status"] ?>
                            </td>
                            <td>
                                <?php if ($row["status"] == "In negotiations"): ?>
                                    <button class="btn btn-success py-2 px-3"
                                        onclick="confirmAdoption(<?= $row['pet_id'] ?>, '<?= $row['pet_name'] ?>')"><i
                                            class="bi bi-check"></i></button>
                                    <button class="btn btn-danger py-2 px-3"
                                        onclick="denyAdoption(<?= $row['pet_id'] ?>, '<?= $row['pet_name'] ?>')"><i
                                            class="bi bi-x"></i></button>
                                <?php endif; ?>
                                <button class="btn btn-danger py-2 px-3"
                                    onclick="deleteMov(<?= $row['pet_id'] ?>, '<?= $row['pet_name'] ?>')"><i
                                        class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <?php
                    endwhile;
                    ?>
                </tbody>
            </table>
        </div>

        <?php
    else:
        ?>
        <div class="alert alert-warning" role="alert">
            You have not signed up any pets yet.
        </div>
        <?php
    endif;
    ?>
    <!-- User Table End -->

    <div class="container-fluid py-5">
        <div class="container">
            <a class="btn btn-primary py-2 px-3" href="addadopt.php">Sign Up Your Pet For Adoption</a>
        </div>

        <!-- Products Start -->
        <div class="container-fluid py-5">
            <div class="container">
                <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                    <h6 class="text-primary text-uppercase">Buy now</h6>
                    <h1 class="display-5 text-uppercase text-white mb-0">Make your wishlist comes true</h1>
                </div>
            </div>
        </div>
        <!-- Products End -->


        <!-- Table Start -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered" style="padding: 20px;">
                <thead>
                    <tr>
                        <th>Owner</th>
                        <th>Category</th>
                        <th>Species</th>
                        <th>Age</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Picture</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "connectToSQL.php";

                    $sql = "SELECT a.*, u.username as user_name FROM adopt a INNER JOIN user u ON a.user_id = u.user_id WHERE a.user_id != $user_id";
                    $result = $connectToSQL->query($sql);

                    if ($result->num_rows > 0):
                        while ($row = $result->fetch_assoc()):
                            ?>
                            <tr>
                                <td>
                                    <?= $row["user_name"] ?>
                                </td>
                                <td>
                                    <?= $row["category"] ?>
                                </td>
                                <td>
                                    <?= $row["species"] ?>
                                </td>
                                <td>
                                    <?= $row["age"] ?>
                                </td>
                                <td>
                                    <?= $row["description"] ?>
                                </td>
                                <td>
                                    <?= $row["price"] ?>
                                </td>
                                <td><img src="data:image/jpeg;base64,<?= base64_encode($row['pet_pic']) ?>" height="100px"
                                        width="auto" /></td>
                                <td>
                                    <?= $row["status"] ?>
                                </td>
                                <td>
                                    <button class="btn btn-primary py-2 px-3"
                                        onclick="adoptPet(<?= $row['pet_id'] ?>, '<?= $row['pet_name'] ?>')"><i
                                            class="bi bi-cart"></i></button>
                                </td>
                            </tr>
                            <?php
                        endwhile;
                    endif;
                    $connectToSQL->close();

                    ?>
                </tbody>
            </table>
        </div>
        <!-- Table End  -->


        <script>
            function adoptPet(pet_id, pet_name) {
                var confirmed = confirm("Are you sure you want to adopt " + pet_name + "? Make sure you already contacted the owner if you want to adopt them");
                if (confirmed) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "updateMovStatus.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            location.reload();
                        }
                    }
                    xhr.send("pet_id=" + pet_id + "&status=In negotiations");
                    alert("You have confirmed your adoption for " + pet_name + ", we have contacted the owner to inform you for further informations");
                }
            }

            function deleteMov(petId, petName) {
                if (confirm("Are you sure you want to delete " + petName + "?")) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "deleteMov.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            window.location.reload();
                        }
                    };
                    xhr.send("pet_id=" + petId);
                }
            }

            function denyAdoption(pet_id, pet_name) {
                if (confirm(`Are you sure you want to deny adoption for ${pet_name}?`)) {
                    $.ajax({
                        url: "denyAdoption.php",
                        type: "POST",
                        data: {
                            pet_id: pet_id
                        },
                        success: function () {
                            location.reload();
                        }
                    });
                }
            }

            function confirmAdoption(petId, petName) {
                if (confirm("Are you going to confirm the adoption of " + petName + "?")) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "deleteMov.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            window.location.reload();
                        }
                    };
                    xhr.send("pet_id=" + petId);
                }
            }

        </script>

        <!-- <script>
            function adoptPet(pet_id, pet_name) {
                var confirmed = confirm("Are you sure you want to adopt " + pet_name + "? Make sure you already contacted the owner if you want to adopt them");
                if (confirmed) {
                    // Send AJAX request to delete the selected pet from the SQL table
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "deleteMov.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // Reload the page to show the updated list of pets
                            location.reload();
                        }
                    }
                    xhr.send("pet_id=" + pet_id);
                    alert("You have confirmed your adoption for " + pet_name + ", we have contacted the owner to inform you for further informations");
                }
            }
        </script> -->



        <!-- Footer Start -->
        <?php include "footer.php" ?>
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