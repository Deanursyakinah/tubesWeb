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

<?php
include "connectToSQL.php";

$discuss_id = $_GET["id"];

$query = "SELECT * FROM discuss WHERE discuss_id = '$discuss_id'";

$sql = mysqli_query($connectToSQL, $query);
$row = mysqli_fetch_assoc($sql);

if (isset($_POST['submit'])) {
    $topic = $_POST['topic'];
    $id = $_POST['id'];
    $description = $_POST['description'];
    $update = "UPDATE discuss SET topic = '$topic', description = '$description' WHERE discuss_id = '$id'";
    mysqli_query($connectToSQL, $update);
    header("Location: discuss.php");
}
// print_r($row);
// if (mysqli_query($connectToSQL, $query)) {
//     header("Location: discuss.php");
//     exit();
// } else {
//     echo "Error : " . mysqli_error($connectToSQL);
// }
?>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="row g-5">
        <div class="col-lg-7">
            <form method="POST">
                <div class="row g-3">
                    <div class="col-12">
                        <label for="topic">Discussion Title :</label><br>
                        <input  type="text" value="<?php echo $row['topic']; ?>" name="topic" id="topic" class="form-control bg-light border-0 px-4" style="height: 55px;">
                    </div>
                    <div class="col-12">
                        <label for="description">Description:</label><br>
                        <textarea name="description" id="description" class="form-control bg-light border-0 px-4" style="height: 150px;"><?php echo $row['description']; ?></textarea>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $discuss_id; ?>">
                    <input type="submit" name="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
</form>