<?php
$host = "localhost";
$user = "root";
$pass = ""; // sesuaikan dengan password MySQL kamu
$db   = "arsipsurat"; // sesuaikan dengan nama database kamu

$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
