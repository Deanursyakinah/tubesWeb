<?php
include "connectToSQL.php";
$id = $_GET["article_id"];

$sql = "DELETE FROM article WHERE article_id = '$id'";

if (mysqli_query($connectToSQL, $sql)) {
    echo "<script>
        alert('Artikel Anda berhasil dihapus');
        location.href = 'blog.php';
</script>";
} else {
    echo ("There's something wrong: " . mysqli_error($connectToSQL));
}

mysqli_close($connectToSQL);
?>