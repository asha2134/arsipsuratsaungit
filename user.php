<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Ambil data user
$users = mysqli_query($koneksi, "SELECT * FROM users");

// Tambah user
if (isset($_POST['tambah_user'])) {
    $nama = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $level = 2; // hanya user

    mysqli_query($koneksi, "INSERT INTO users (username, password, nama_lengkap, level) VALUES ('$username', '$password', '$nama', '$level')");
    header("Location: user.php");
    exit();
}

// Update user
if (isset($_POST['update_user'])) {
    $id = $_POST['id_user'];
    $nama = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $level = 2; // tetap user

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        mysqli_query($koneksi, "UPDATE users SET nama_lengkap='$nama', username='$username', password='$password', level='$level' WHERE id_user='$id'");
    } else {
        mysqli_query($koneksi, "UPDATE users SET nama_lengkap='$nama', username='$username', level='$level' WHERE id_user='$id'");
    }

    header("Location: user.php");
    exit();
}

// Hapus user
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM users WHERE id_user='$id'");
    header("Location: user.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data User</title>
    <link rel="stylesheet" href="asset/css/sidebar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="layout">

    <?php include 'layout/sidebar.php'; ?>

    <div class="main">
        <?php include 'layout/topbar.php'; ?>

        <main class="content p-4">
            <h2 class="mb-3">Data User</h2>

            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                <i class="fas fa-user-plus"></i> Tambah User
            </button>

            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Level</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    while ($row = mysqli_fetch_assoc($users)) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                            <td><?= htmlspecialchars($row['username']); ?></td>
                            <td>User</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id_user']; ?>">Edit</button>
                                <a href="user.php?hapus=<?= $row['id_user']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</a>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal<?= $row['id_user']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $row['id_user']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id_user" value="<?= $row['id_user']; ?>">
                                            <input type="hidden" name="level" value="2">

                                            <div class="mb-3">
                                                <label>Nama Lengkap</label>
                                                <input type="text" name="nama_lengkap" class="form-control" value="<?= $row['nama_lengkap']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Username</label>
                                                <input type="text" name="username" class="form-control" value="<?= $row['username']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Password (Kosongkan jika tidak ingin mengubah)</label>
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="update_user" class="btn btn-primary">Simpan</button>
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

    <!-- Modal Tambah User -->
    <div class="modal fade" id="modalTambahUser" tabindex="-1" aria-labelledby="modalTambahUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="level" value="2">
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="tambah_user" class="btn btn-primary">Simpan</button>
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