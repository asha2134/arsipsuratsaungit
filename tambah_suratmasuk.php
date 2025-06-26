<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $no = mysqli_real_escape_string($koneksi, $_POST['no_surat']);
  $judul = mysqli_real_escape_string($koneksi, $_POST['judul_surat']);
  $asal = mysqli_real_escape_string($koneksi, $_POST['asal_surat']);
  $masuk = $_POST['tanggal_masuk'];
  $keluar = $_POST['tanggal_keluar'];
  $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

  $filePath = "";
  if (!empty($_FILES['file_surat']['name'])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["file_surat"]["name"]);
    $targetFilePath = $targetDir . time() . "_" . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Proses upload file
    if (move_uploaded_file($_FILES["file_surat"]["tmp_name"], $targetFilePath)) {
      $filePath = $targetFilePath;
    }
  }

  $query = "INSERT INTO suratmasuk 
              (no_surat, judul_surat, asal_surat, tanggal_masuk, tanggal_keluar, keterangan, berkas_surat_masuk) 
            VALUES 
              ('$no', '$judul', '$asal', '$masuk', '$keluar', '$keterangan', '$filePath')";

  if (mysqli_query($koneksi, $query)) {
    $_SESSION['alert'] = "Data surat masuk berhasil ditambahkan.";
  } else {
    $_SESSION['alert'] = "Gagal menambahkan data: " . mysqli_error($koneksi);
  }

  header("Location: surat_masuk.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="asset/css/tambahsuratmasuk.css">
  <title>Tambah Surat Masuk</title>
</head>

<body>
  <h2>Tambah Surat Masuk</h2>
  <form method="POST" action="" enctype="multipart/form-data">
    <label>No Surat:</label><br>
    <input type="text" name="no_surat" required><br>

    <label>Judul Surat:</label><br>
    <input type="text" name="judul_surat" required><br>

    <label>Asal Surat:</label><br>
    <input type="text" name="asal_surat" required><br>

    <label>Tanggal Masuk:</label><br>
    <input type="date" name="tanggal_masuk" required><br>

    <label>Tanggal Keluar:</label><br>
    <input type="date" name="tanggal_keluar"><br>

    <label>Keterangan:</label><br>
    <textarea name="keterangan" rows="3" required></textarea><br>

    <label>Upload Dokumen:</label><br>
    <input type="file" name="dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"><br><br>

    <input type="submit" value="Simpan">
  </form>
</body>

</html>