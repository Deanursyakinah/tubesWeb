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
        input[type="submit"],
        input[type="button"] {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            color: #fff;
            background-color: #007bff;
            cursor: pointer;
            width: 150px;
        }

        input[type="submit"]:hover,
        input[type="button"]:hover {
            background-color: #0069d9;
        }

        input[type="button"] {
            background-color: #6c757d;
        }

        input[type="button"]:hover {
            background-color: #5a6268;
        }

        body {
            margin: 20px;
        }
    </style>
</head>

<?php
session_start();
include "connectToSQL.php";

$discuss_id = $_GET['id'];
$username = $_GET['username'];

$getKomenan = "SELECT * FROM comment WHERE discuss_id = '$discuss_id'";
$query = mysqli_query($connectToSQL, $getKomenan);

if (isset($_POST['submit'])) {
    $dis_id = $_POST['id'];
    $user_name = $_POST['username'];
    $text = $_POST['comment'];
    $insertQuery = "INSERT INTO comment (discuss_id, user_id, reply_text) VALUES ('$dis_id', '{$_SESSION['user_id']}', '$text')";

    mysqli_query($connectToSQL, $insertQuery);

    header("Location: repplycomment.php?id=$dis_id&username=$user_name");
}

$getDiscuss = "SELECT * FROM discuss WHERE discuss_id = '$discuss_id'";
$discussQuery = mysqli_query($connectToSQL, $getDiscuss);
$dataDiscuss = mysqli_fetch_array($discussQuery);

echo "<h3>" . $dataDiscuss["topic"] . " by " . $username . "</h3>";
echo "<p>Description : " . $dataDiscuss["description"] . "</p>";
?>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="row g-5">
        <div class="col-lg-7">
            <div class="row g-3">
                <div class="col-12">
                    <label for="comment">Komen:</label><br>
                    <textarea name="comment" id="comment" class="form-control bg-light border-0 px-4" style="height: 150px;"></textarea>
                </div>
                <input type="hidden" name="id" value="<?php echo $discuss_id; ?>">
                <input type="hidden" name="username" value="<?php echo $username; ?>">
                <input type="submit" name="submit" value="Submit">
                <input type="button" value="Back" onclick="location.href='discuss.php'">
            </div>
        </div>
    </div>
</form>

<?php
while ($row = mysqli_fetch_assoc($query)) {
    $queryGetName = "SELECT * FROM user WHERE user_id = '{$row['user_id']}'";
    $sql = mysqli_query($connectToSQL, $queryGetName);
    $data = mysqli_fetch_assoc($sql);
    echo "<div style='display: flex; align-items:center;'><img style='width:50px; height:50px; border-radius:50%;' src='imgSignUp/{$data['profpict']}' alt=''><h4>{$data['username']}</h4></div>";
    echo "<p style='margin-top: px;' >{$row['reply_text']}</p><hr>";
}

?>