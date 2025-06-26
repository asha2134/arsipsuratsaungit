<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no = mysqli_real_escape_string($koneksi, $_POST['no_suratkeluar']);
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul_suratkeluar']);
    $tujuan = mysqli_real_escape_string($koneksi, $_POST['tujuan']);
    $tanggal_keluar = $_POST['tanggal_keluar'];
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    $filePath = "";
    if (!empty($_FILES['file_surat']['name'])) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["file_surat"]["name"]);
        $targetFilePath = $targetDir . time() . "_" . $fileName;

        if (move_uploaded_file($_FILES["file_surat"]["tmp_name"], $targetFilePath)) {
            $filePath = $targetFilePath;
        }
    }

    $query = "INSERT INTO suratkeluar 
              (no_suratkeluar, judul_suratkeluar, tujuan, tanggal_keluar, keterangan, berkas_suratkeluar) 
            VALUES 
              ('$no', '$judul', '$tujuan', '$tanggal_keluar', '$keterangan', '$filePath')";

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['alert'] = "Data surat keluar berhasil ditambahkan.";
    } else {
        $_SESSION['alert'] = "Gagal menambahkan data: " . mysqli_error($koneksi);
    }

    header("Location: surat_keluar.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="asset/css/tambahsuratmasuk.css">
    <title>Tambah Surat Keluar</title>
</head>

<body>
    <h2>Tambah Surat Keluar</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <label>No Surat:</label><br>
        <input type="text" name="no_suratkeluar" required><br>

        <label>Judul Surat:</label><br>
        <input type="text" name="judul_suratkeluar" required><br>

        <label>Tujuan:</label><br>
        <input type="text" name="tujuan" required><br>

        <label>Tanggal Keluar:</label><br>
        <input type="date" name="tanggal_keluar" required><br>

        <label>Keterangan:</label><br>
        <textarea name="keterangan" rows="3" required></textarea><br>

        <label>Upload Dokumen:</label><br>
        <input type="file" name="file_surat" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"><br><br>

        <input type="submit" value="Simpan">
    </form>
</body>

</html>