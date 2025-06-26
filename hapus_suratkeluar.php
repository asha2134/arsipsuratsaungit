<?php
include 'config.php';

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM suratkeluar WHERE id_suratkeluar='$id'");

header("Location: surat_keluar.php");
