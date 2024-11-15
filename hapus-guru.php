<?php
include 'function.php';


if (isset($_GET['guruID']) && !empty($_GET['guruID'])) {
    $id = $_GET['guruID'];

    $sql = "DELETE FROM guru where guruID = '$id'";

    if (mysqli_query($conn, $sql)) {
        // Jika berhasil
        echo "<script>alert('Data berhasil dihapus'); window.location.href='list-guru.php';</script>";
    } else {
        // Jika gagal
        echo "<script>alert('Gagal menghapus data'); window.location.href='list-guru.php';</script>";
    }
} else {
    header("Location: guru.php");
    exit();
}
