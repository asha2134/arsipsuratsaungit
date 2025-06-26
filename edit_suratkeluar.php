<?php
include 'config.php';

$id     = $_POST['id_suratkeluar'];
$no     = $_POST['no_suratkeluar'];
$judul  = $_POST['judul_suratkeluar'];
$tujuan = $_POST['tujuan'];
$tgl    = $_POST['tanggal_keluar'];
$ket    = $_POST['keterangan'];

mysqli_query($koneksi, "UPDATE suratkeluar SET 
    no_suratkeluar = '$no',
    judul_suratkeluar = '$judul',
    tujuan = '$tujuan',
    tanggal_keluar = '$tgl',
    keterangan = '$ket'
    WHERE id_suratkeluar = '$id'");

header("Location: surat_keluar.php");
