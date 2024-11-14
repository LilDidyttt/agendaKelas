<?php

include 'function.php';

if (isset($_GET['mapel'])) {
    $id = $_GET['mapel'];

    $sql = "DELETE FROM mapel where KodeMapel = '$id'";

    if (mysqli_query($conn, $sql)) {
        // Jika berhasil
        echo "<script>alert('Data berhasil dihapus'); window.location.href='mapel.php';</script>";
    } else {
        // Jika gagal
        echo "<script>alert('Gagal menghapus data'); window.location.href='mapel.php';</script>";
    }
}
