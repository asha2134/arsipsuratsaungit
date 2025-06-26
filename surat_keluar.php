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

// Proses Edit Surat Keluar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_surat'])) {
    $id = intval($_POST['id_suratkeluar']);
    $no = mysqli_real_escape_string($koneksi, $_POST['no_suratkeluar']);
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul_suratkeluar']);
    $tujuan = mysqli_real_escape_string($koneksi, $_POST['tujuan']);
    $keluar = $_POST['tanggal_keluar'];
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    $file_sql = "";
    if (!empty($_FILES['file_surat']['name'])) {
        $targetDir = "uploads/";
        $fileName = time() . "_" . basename($_FILES["file_surat"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES["file_surat"]["tmp_name"], $targetFilePath)) {
            $file_sql = ", berkas_suratkeluar = '" . mysqli_real_escape_string($koneksi, $fileName) . "'";
        }
    }

    $query = "UPDATE suratkeluar SET 
              no_suratkeluar = '$no',
              judul_suratkeluar = '$judul',
              tujuan = '$tujuan',
              tanggal_keluar = '$keluar',
              keterangan = '$keterangan'
              $file_sql
            WHERE id_suratkeluar = $id";

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['alert'] = "Data surat keluar berhasil diubah.";
    } else {
        $_SESSION['alert'] = "Gagal mengubah data: " . mysqli_error($koneksi);
    }

    header("Location: surat_keluar.php");
    exit();
}

// Ambil Data
$data = mysqli_query($koneksi, "SELECT * FROM suratkeluar ORDER BY id_suratkeluar DESC");
$pageTitle = "Data Surat Keluar";
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
                        <th>Tujuan</th>
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
                            <td><?= htmlspecialchars($d['no_suratkeluar']) ?></td>
                            <td><?= htmlspecialchars($d['judul_suratkeluar']) ?></td>
                            <td><?= htmlspecialchars($d['tujuan']) ?></td>
                            <td><?= htmlspecialchars($d['tanggal_keluar']) ?></td>
                            <td><?= htmlspecialchars($d['keterangan']) ?></td>
                            <td>
                                <?php
                                $berkas = $d['berkas_suratkeluar'];
                                if ($berkas) {
                                    // Pastikan path diawali dengan "uploads/"
                                    $berkasPath = str_starts_with($berkas, 'uploads/') ? $berkas : 'uploads/' . $berkas;
                                    echo '<a href="' . $berkasPath . '" target="_blank" class="btn btn-sm btn-info">Lihat</a>';
                                } else {
                                    echo '<span class="text-muted">-</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $d['id_suratkeluar'] ?>">Edit</button>
                                <a href="hapus_suratkeluar.php?id=<?= $d['id_suratkeluar'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus surat ini?')">Hapus</a>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal<?= $d['id_suratkeluar'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <input type="hidden" name="id_suratkeluar" value="<?= $d['id_suratkeluar'] ?>">
                                        <input type="hidden" name="edit_surat" value="1">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Surat Keluar</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3"><label>No Surat</label>
                                                <input type="text" name="no_suratkeluar" class="form-control" value="<?= htmlspecialchars($d['no_suratkeluar']) ?>" required>
                                            </div>
                                            <div class="mb-3"><label>Judul</label>
                                                <input type="text" name="judul_suratkeluar" class="form-control" value="<?= htmlspecialchars($d['judul_suratkeluar']) ?>" required>
                                            </div>
                                            <div class="mb-3"><label>Tujuan</label>
                                                <input type="text" name="tujuan" class="form-control" value="<?= htmlspecialchars($d['tujuan']) ?>" required>
                                            </div>
                                            <div class="mb-3"><label>Tanggal Keluar</label>
                                                <input type="date" name="tanggal_keluar" class="form-control" value="<?= $d['tanggal_keluar'] ?>" required>
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
                <form method="POST" action="tambah_suratkeluar.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Surat Keluar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label>No Surat</label><input type="text" name="no_suratkeluar" class="form-control" required></div>
                        <div class="mb-3"><label>Judul Surat</label><input type="text" name="judul_suratkeluar" class="form-control" required></div>
                        <div class="mb-3"><label>Tujuan</label><input type="text" name="tujuan" class="form-control" required></div>
                        <div class="mb-3"><label>Tanggal Keluar</label><input type="date" name="tanggal_keluar" class="form-control" required></div>
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