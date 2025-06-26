<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id_disposisi'];
    $pengisi = $_POST['pengisi'];
    $tujuan = $_POST['tujuan'];
    $instruksi = $_POST['instruksi'];
    $catatan = $_POST['catatan'];

    mysqli_query($koneksi, "UPDATE disposisi SET pengisi='$pengisi', tujuan='$tujuan', instruksi='$instruksi', catatan='$catatan' WHERE id_disposisi=$id");
}

header("Location: disposisi.php");
exit();
