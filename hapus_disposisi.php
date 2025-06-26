<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id_disposisi'];
    mysqli_query($koneksi, "DELETE FROM disposisi WHERE id_disposisi=$id");
}

header("Location: disposisi.php");
exit();
