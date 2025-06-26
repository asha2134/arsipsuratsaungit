<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$data = mysqli_query($koneksi, "SELECT * FROM disposisi ORDER BY id_disposisi DESC");
$pageTitle = "Data Disposisi";
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
            <h2 class="mb-3">Data Disposisi</h2>

            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahDisposisi">
                <i class="fas fa-plus"></i> Tambah Data
            </button>

            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Pengisi</th>
                        <th>Tujuan</th>
                        <th>Instruksi</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($d = mysqli_fetch_assoc($data)) {
                        $id = $d['id_disposisi'];
                        echo "<tr>
                                <td>$no</td>
                                <td>{$d['pengisi']}</td>
                                <td>{$d['tujuan']}</td>
                                <td>{$d['instruksi']}</td>
                                <td>{$d['catatan']}</td>
                                <td>
                                    <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEdit$id'>Edit</button>
                                    <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#modalHapus$id'>Hapus</button>
                                </td>
                            </tr>";

                        // Modal Edit
                        echo "
                        <div class='modal fade' id='modalEdit$id' tabindex='-1'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <form method='POST' action='edit_disposisi.php'>
                                        <input type='hidden' name='id_disposisi' value='$id'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title'>Edit Disposisi</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <div class='mb-3'>
                                                <label>Pengisi</label>
                                                <input type='text' name='pengisi' value='{$d['pengisi']}' class='form-control' required>
                                            </div>
                                            <div class='mb-3'>
                                                <label>Tujuan</label>
                                                <input type='text' name='tujuan' value='{$d['tujuan']}' class='form-control' required>
                                            </div>
                                            <div class='mb-3'>
                                                <label>Instruksi</label>
                                                <input type='text' name='instruksi' value='{$d['instruksi']}' class='form-control' required>
                                            </div>
                                            <div class='mb-3'>
                                                <label>Catatan</label>
                                                <textarea name='catatan' class='form-control' required>{$d['catatan']}</textarea>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='submit' class='btn btn-primary'>Simpan Perubahan</button>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>";

                        // Modal Hapus
                        echo "
                        <div class='modal fade' id='modalHapus$id' tabindex='-1'>
                            <div class='modal-dialog modal-sm'>
                                <div class='modal-content'>
                                    <form method='POST' action='hapus_disposisi.php'>
                                        <input type='hidden' name='id_disposisi' value='$id'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title'>Konfirmasi Hapus</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <p>Yakin ingin menghapus data ini?</p>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='submit' class='btn btn-danger'>Hapus</button>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>";

                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambahDisposisi" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="tambah_disposisi.php">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Disposisi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Pengisi</label>
                            <input type="text" name="pengisi" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Tujuan</label>
                            <input type="text" name="tujuan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Instruksi</label>
                            <input type="text" name="instruksi" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Catatan</label>
                            <textarea name="catatan" class="form-control" required></textarea>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>