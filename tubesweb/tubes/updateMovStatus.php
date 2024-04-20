<?php
include "connectToSQL.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pet_id = $_POST["pet_id"];
    
    // Update the status of the selected pet to "In negotiations"
    $sql = "UPDATE adopt SET status='In negotiations' WHERE pet_id=$pet_id";
    
    if ($connectToSQL->query($sql) === TRUE) {
        echo "Pet status updated successfully";
    } else {
        echo "Error updating pet status: " . $connectToSQL->error;
    }
}

// Close database connection
$connectToSQL->close();
?>