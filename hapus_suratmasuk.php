<?php
session_start();
include 'config.php';

// Pastikan parameter id disediakan
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Cek apakah data dengan id tersebut ada
    $cek = mysqli_query($koneksi, "SELECT * FROM suratmasuk WHERE id_suratmasuk = $id");
    if (mysqli_num_rows($cek) > 0) {
        // Hapus data
        $hapus = mysqli_query($koneksi, "DELETE FROM suratmasuk WHERE id_suratmasuk = $id");

        if ($hapus) {
            $_SESSION['alert'] = "Data surat berhasil dihapus.";
        } else {
            $_SESSION['alert'] = "Gagal menghapus data: " . mysqli_error($koneksi);
        }
    } else {
        $_SESSION['alert'] = "Data tidak ditemukan.";
    }
} else {
    $_SESSION['alert'] = "ID surat tidak valid.";
}

// Kembali ke halaman surat_masuk
header("Location: surat_masuk.php");
exit();
