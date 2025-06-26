<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit();
}

$masuk = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM suratmasuk");
$jumlah_masuk = mysqli_fetch_assoc($masuk)['total'];

$keluar = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM suratkeluar");
$jumlah_keluar = mysqli_fetch_assoc($keluar)['total'];

$user = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM users");
$jumlah_user = mysqli_fetch_assoc($user)['total'];

$disposisi = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM disposisi");
$jumlah_disposisi = mysqli_fetch_assoc($disposisi)['total'];

$pageTitle = "Dashboard";
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $pageTitle ?></title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="asset/css/sidebar.css">
  <!-- Ganti bagian CSS <style> di dalam <head> seperti ini: -->
  <style>
    .statistik {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin-top: 1rem;
    }

    .stat-box {
      flex: 1 1 220px;
      padding: 1.2rem;
      border-radius: 12px;
      color: #fff;
      text-align: center;
      text-decoration: none;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .stat-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      opacity: 0.95;
      text-decoration: none;
    }

    .stat-box h5 {
      margin-top: 0.5rem;
      font-weight: bold;
    }

    .stat-box p {
      font-size: 1.8rem;
      color: #fff;
      margin: 0;
    }

    .stat-box i {
      font-size: 2.2rem;
      margin-bottom: 0.5rem;
    }

    /* Warna berbeda untuk tiap kotak */
    .masuk {
      background: linear-gradient(135deg, #007bff, #0056b3);
      /* Biru */
    }

    .keluar {
      background: linear-gradient(135deg, #28a745, #1e7e34);
      /* Hijau */
    }

    .user {
      background: linear-gradient(135deg, #6f42c1, #4b2a99);
      /* Ungu */
    }

    .disposisi {
      background: linear-gradient(135deg, #fd7e14, #e8590c);
      /* Oranye */
    }
  </style>

<body class="layout">
  <?php include 'layout/sidebar.php'; ?>

  <div class="main">
    <?php include 'layout/topbar.php'; ?>

    <main class="content">
      <h4>SELAMAT DATANG DI SISTEM INFORMASI ARSIP SURAT SAUNG IT BUMIAYU</h4>

      <div class="statistik">
        <a href="surat_masuk.php" class="stat-box masuk">
          <i class="fas fa-envelope-open-text"></i>
          <h5>Surat Masuk</h5>
          <p><?= $jumlah_masuk; ?></p>
        </a>

        <a href="surat_keluar.php" class="stat-box keluar">
          <i class="fas fa-paper-plane"></i>
          <h5>Surat Keluar</h5>
          <p><?= $jumlah_keluar; ?></p>
        </a>

        <a href="user.php" class="stat-box user">
          <i class="fas fa-users-cog"></i>
          <h5>Pengguna</h5>
          <p><?= $jumlah_user; ?></p>
        </a>

        <a href="disposisi.php" class="stat-box disposisi">
          <i class="fas fa-file-signature"></i>
          <h5>Disposisi</h5>
          <p><?= $jumlah_disposisi; ?></p>
        </a>
      </div>
    </main>
  </div>

  <script>
    const collapseBtn = document.querySelector('.collapse-btn button');
    const sidebar = document.querySelector('.sidebar');
    if (collapseBtn && sidebar) {
      collapseBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
      });
    }
  </script>
</body>

</html>