<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pengisi = $_POST['pengisi'];
    $tujuan = $_POST['tujuan'];
    $instruksi = $_POST['instruksi'];
    $catatan = $_POST['catatan'];

    $query = "INSERT INTO disposisi (pengisi, tujuan, instruksi, catatan)
              VALUES ('$pengisi', '$tujuan', '$instruksi', '$catatan')";

    mysqli_query($koneksi, $query);
    header("Location: disposisi.php");
    exit();
}
