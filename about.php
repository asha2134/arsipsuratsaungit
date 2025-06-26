<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = "Tentang Instansi";
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="asset/css/sidebar.css">
    <link rel="stylesheet" href="asset/css/about.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="layout">
    <?php include 'layout/sidebar.php'; ?>
    <div class="main">
        <?php include 'layout/topbar.php'; ?>
        <main class="content p-4">
            <div class="container">
                <h2 class="mb-4"></h2>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- Kiri: Profil dan logo -->
                            <div class="col-md-6 d-flex flex-column align-items-center">
                                <div class="logo-container text-center mb-3">
                                    <img src="asset/img/logo.png" alt="Logo Saung IT">
                                    <p>SAUNG IT BUMIAYU</p>
                                </div>
                                <p class="tentang-text">
                                    CV. Saung Information Technology didirikan pada tahun 2020 oleh Mohammad Defirda Irfanda, S.Kom yang mana ide ini berasal dari inisiatif pendiri untuk membuat wadah bagi penggiat IT dari segala bidang teknologi untuk memudahkan masyarakat dalam menyelesaikan permasalahan mengenai teknologi IT yang ada di wilayah Bumiayu dan sekitarnya. <br><br>
                                    CV. Saung IT menyediakan berbagai jasa pelayanan mulai dari instalasi jaringan, service computer & printer, pengadaan barang instansi, percetakan & fotocopy, instalasi CCTV, jasa legalitas usaha, pembuatan aplikasi web, jasa desain grafis dan lain-lain. <br><br>
                                    Alamat CV. SAUNG IT terletak di Dk. Kramat Rt.001/ Rw.006, Kec. Bumiayu, Kab. Brebes, Jawa Tengah 52273
                                </p>
                            </div>
                            <!-- Kanan: Visi dan Misi -->
                            <div class="col-md-6 visi-misi">
                                <h4 class="fw-bold mb-3">Visi dan Misi</h4>
                                <h5>Visi</h5>
                                <p>
                                    Mempersiapkan sumber daya manusia yang taqwa, berakhlak mulia, berintegritas, handal dan terampil di bidang IT dalam upaya mengurangi pengangguran dan menciptakan wirausahawan baru.
                                </p>
                                <h5>Misi</h5>
                                <ol>
                                    <li>Ikut mendukung pembangunan nasional melalui bidang Pendidikan non formal dan mengurangi angka pengangguran.</li>
                                    <li>Membentuk wirausahawan yang kuat untuk usaha mandiri sehingga dapat membuka lapangan kerja baru.</li>
                                    <li>Menjalin kerjasama dengan instansi pendidikan dalam upaya peningkatan mutu instansi terkait.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>