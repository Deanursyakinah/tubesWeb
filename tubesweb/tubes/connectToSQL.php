<?php
$connectToSQL = mysqli_connect('localhost', 'root', '', 'moviemingle');
if (!$connectToSQL) {
    die("Error to connect: " . mysqli_connect_error());
}
?>