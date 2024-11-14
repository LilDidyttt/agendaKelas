<?php
include 'function.php';

if (isset($_GET['guruID'])) {
    $guruID = $_GET['guruID'];

    // Panggil fungsi hapusGuru
    $result = hapusGuru($guruID);

    if ($result) {
        // Jika berhasil dihapus, redirect ke list-guru.php dengan pesan sukses
        header("Location: list-guru.php?status=success&message=Data guru berhasil dihapus");
    } else {
        // Jika gagal, redirect ke list-guru.php dengan pesan error
        header("Location: list-guru.php?status=error&message=Gagal menghapus data guru");
    }
} else {
    // Jika tidak ada guruID, redirect ke list-guru.php
    header("Location: list-guru.php");
}
exit();
