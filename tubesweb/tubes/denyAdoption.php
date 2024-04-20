<?php
include "connectToSQL.php";
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$pet_id = isset($_POST['pet_id']) ? $_POST['pet_id'] : null;

// Update the status of the pet to "Available"
$sql = "UPDATE adopt SET status = 'Available' WHERE pet_id = $pet_id";
$result = $connectToSQL->query($sql);

if ($result) {
  echo "success";
} else {
  echo "error";
}
?>