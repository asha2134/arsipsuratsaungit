<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit();
}

$alert = "";
if (isset($_SESSION['alert'])) {
  $alert = $_SESSION['alert'];
  unset($_SESSION['alert']);
}

// Proses Edit Surat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_surat'])) {
  $id = intval($_POST['id_suratmasuk']);
  $no = mysqli_real_escape_string($koneksi, $_POST['no_surat']);
  $judul = mysqli_real_escape_string($koneksi, $_POST['judul_surat']);
  $asal = mysqli_real_escape_string($koneksi, $_POST['asal_surat']);
  $masuk = $_POST['tanggal_masuk'];
  $keluar = $_POST['tanggal_keluar'];
  $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

  $file_sql = "";
  if (!empty($_FILES['file_surat']['name'])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["file_surat"]["name"]);
    $targetFilePath = $targetDir . time() . "_" . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["file_surat"]["tmp_name"], $targetFilePath)) {
      $file_sql = ", berkas_surat_masuk = '" . mysqli_real_escape_string($koneksi, $targetFilePath) . "'";
    }
  }

  $query = "UPDATE suratmasuk SET 
              no_surat = '$no',
              judul_surat = '$judul',
              asal_surat = '$asal',
              tanggal_masuk = '$masuk',
              tanggal_keluar = '$keluar',
              keterangan = '$keterangan'
              $file_sql
            WHERE id_suratmasuk = $id";

  if (mysqli_query($koneksi, $query)) {
    $_SESSION['alert'] = "Data surat berhasil diubah.";
  } else {
    $_SESSION['alert'] = "Gagal mengubah data: " . mysqli_error($koneksi);
  }

  header("Location: surat_masuk.php");
  exit();
}

// Ambil Data
$data = mysqli_query($koneksi, "SELECT * FROM suratmasuk ORDER BY id_suratmasuk DESC");
$pageTitle = "Data Surat Masuk";
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $pageTitle ?></title>
  <link rel="stylesheet" href="asset/css/sidebar.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="layout">
  <?php include 'layout/sidebar.php'; ?>
  <div class="main">
    <?php include 'layout/topbar.php'; ?>
    <main class="content p-4">
      <h2 class="mb-3"> </h2>
      <?php if ($alert) : ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          <?= $alert ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahSurat">
        <i class="fas fa-plus"></i> Tambah Data
      </button>

      <table class="table table-bordered table-striped">
        <thead class="table-primary">
          <tr>
            <th>No</th>
            <th>No Surat</th>
            <th>Judul</th>
            <th>Asal</th>
            <th>Tgl Masuk</th>
            <th>Tgl Keluar</th>
            <th>Keterangan</th>
            <th>Berkas</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          while ($d = mysqli_fetch_assoc($data)) : ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= htmlspecialchars($d['no_surat']) ?></td>
              <td><?= htmlspecialchars($d['judul_surat']) ?></td>
              <td><?= htmlspecialchars($d['asal_surat']) ?></td>
              <td><?= htmlspecialchars($d['tanggal_masuk']) ?></td>
              <td><?= htmlspecialchars($d['tanggal_keluar']) ?></td>
              <td><?= htmlspecialchars($d['keterangan']) ?></td>
              <td>
                <?php if ($d['berkas_surat_masuk']) : ?>
                  <a href="<?= $d['berkas_surat_masuk'] ?>" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                <?php else : ?>
                  <span class="text-muted">-</span>
                <?php endif; ?>
              </td>
              <td>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $d['id_suratmasuk'] ?>">Edit</button>
                <a href="hapus_suratmasuk.php?id=<?= $d['id_suratmasuk'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus surat ini?')">Hapus</a>
              </td>
            </tr>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal<?= $d['id_suratmasuk'] ?>" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="id_suratmasuk" value="<?= $d['id_suratmasuk'] ?>">
                    <input type="hidden" name="edit_surat" value="1">
                    <div class="modal-header">
                      <h5 class="modal-title">Edit Surat Masuk</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3"><label>No Surat</label>
                        <input type="text" name="no_surat" class="form-control" value="<?= htmlspecialchars($d['no_surat']) ?>" required>
                      </div>
                      <div class="mb-3"><label>Judul</label>
                        <input type="text" name="judul_surat" class="form-control" value="<?= htmlspecialchars($d['judul_surat']) ?>" required>
                      </div>
                      <div class="mb-3"><label>Asal</label>
                        <input type="text" name="asal_surat" class="form-control" value="<?= htmlspecialchars($d['asal_surat']) ?>" required>
                      </div>
                      <div class="mb-3"><label>Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control" value="<?= $d['tanggal_masuk'] ?>" required>
                      </div>
                      <div class="mb-3"><label>Tanggal Keluar</label>
                        <input type="date" name="tanggal_keluar" class="form-control" value="<?= $d['tanggal_keluar'] ?>">
                      </div>
                      <div class="mb-3"><label>Keterangan</label>
                        <textarea name="keterangan" class="form-control"><?= htmlspecialchars($d['keterangan']) ?></textarea>
                      </div>
                      <div class="mb-3"><label>Upload Berkas Baru (Opsional)</label>
                        <input type="file" name="file_surat" class="form-control">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </tbody>
      </table>
    </main>
  </div>

  <!-- Modal Tambah -->
  <div class="modal fade" id="modalTambahSurat" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" action="tambah_suratmasuk.php" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Surat Masuk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3"><label>No Surat</label><input type="text" name="no_surat" class="form-control" required></div>
            <div class="mb-3"><label>Judul Surat</label><input type="text" name="judul_surat" class="form-control" required></div>
            <div class="mb-3"><label>Asal Surat</label><input type="text" name="asal_surat" class="form-control" required></div>
            <div class="mb-3"><label>Tanggal Masuk</label><input type="date" name="tanggal_masuk" class="form-control" required></div>
            <div class="mb-3"><label>Tanggal Keluar</label><input type="date" name="tanggal_keluar" class="form-control"></div>
            <div class="mb-3"><label>Keterangan</label><textarea name="keterangan" class="form-control" rows="3" required></textarea></div>
            <div class="mb-3"><label>Upload Berkas</label><input type="file" name="file_surat" class="form-control"></div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>