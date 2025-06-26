<?php
session_start();
include 'config.php';

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $konfirmasi = mysqli_real_escape_string($koneksi, $_POST['konfirmasi_password']);

    // Validasi password
    if ($password !== $konfirmasi) {
        $_SESSION['error'] = "Password dan konfirmasi tidak cocok!";
        header("Location: registrasi.php");
        exit();
    }

    // Cek apakah username sudah digunakan
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['error'] = "Username sudah terdaftar!";
        header("Location: registrasi.php");
        exit();
    }

    // Simpan user baru
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    mysqli_query($koneksi, "INSERT INTO users (nama_lengkap, username, password, level) VALUES ('$nama', '$username', '$hashedPassword', 2)");

    $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
    header("Location: login.php");
    exit();
}

// Tampilkan pesan jika ada
$message = '';
if (isset($_SESSION['error'])) {
    $message = "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
} elseif (isset($_SESSION['success'])) {
    $message = "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
    unset($_SESSION['success']);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
    <link rel="stylesheet" href="asset/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="login-box">
            <h2>Registrasi Akun</h2>
            <?= $message; ?>
            <form method="POST" action="registrasi.php">
                <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="konfirmasi_password" placeholder="Konfirmasi Password" required>

                <button type="submit">Daftar</button>
                <p class="mt-3">Sudah punya akun? <a href="login.php">Login di sini</a></p>
            </form>
        </div>
    </div>
</body>

</html>