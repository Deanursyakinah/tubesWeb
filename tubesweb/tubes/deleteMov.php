<?php
include "connectToSQL.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pet_id"])) {
    $pet_id = $_POST["pet_id"];

    $sql = "DELETE FROM adopt WHERE pet_id = $pet_id";
    $result = $connectToSQL->query($sql);

    if ($result) {
        echo "Pet adoption successfull!";
    } else {
        echo "Error deleting pet: " . $connectToSQL -> error;
    }
}
?>