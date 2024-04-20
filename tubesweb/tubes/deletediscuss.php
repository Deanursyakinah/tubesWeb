<?php
include "connectToSQL.php";

$discuss_id = $_GET["id"];

$deleteComment = "DELETE FROM comment WHERE discuss_id = '$discuss_id'";
mysqli_query($connectToSQL, $deleteComment);
$query = "DELETE FROM discuss WHERE discuss_id = '$discuss_id'";

if (mysqli_query($connectToSQL, $query)) {
    header("Location: discuss.php");
    exit();
} else {
    echo "Error : " . mysqli_error($connectToSQL);
}
?>