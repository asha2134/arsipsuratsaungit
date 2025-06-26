<?php
session_start();
include 'config.php';

// Cek jika user sudah login
if (isset($_SESSION['user'])) {
  header("Location: dashboard.php");
  exit();
}

// Jika form login dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = mysqli_real_escape_string($koneksi, $_POST['username']);
  $password = $_POST['password'];

  $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username' LIMIT 1");

  if (mysqli_num_rows($query) > 0) {
    $user = mysqli_fetch_assoc($query);

    // Verifikasi password
    if (password_verify($password, $user['password'])) {
      // Simpan user ke session
      $_SESSION['user'] = [
        'id' => $user['id_user'],
        'nama' => $user['nama_lengkap'],
        'username' => $user['username'],
        'level' => $user['level']
      ];
      header("Location: dashboard.php");
      exit();
    } else {
      $_SESSION['error'] = "Password salah!";
    }
  } else {
    $_SESSION['error'] = "Username tidak ditemukan!";
  }
}

// Pesan error
$message = '';
if (isset($_SESSION['error'])) {
  $message = "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
  unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="asset/css/login.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <div class="login-box">
      <h2>Login</h2>
      <?= $message; ?>
      <form method="POST" action="login.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <p class="mt-3">Belum punya akun? <a href="registrasi.php">Daftar di sini</a></p>
      </form>
    </div>
  </div>
</body>

</html>