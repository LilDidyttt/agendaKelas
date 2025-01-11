<?php
include '../function.php'; // Pastikan file koneksi database sudah benar

if (isset($_GET['kelasID'])) {
    $kelasID = $_GET['kelasID'];

    $query = "SELECT siswaID, nama FROM siswa WHERE kelasID = '$kelasID'";
    $result = mysqli_query($conn, $query);

    $siswa = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $siswa[] = $row;
    }

    // Kirim data dalam format JSON
    echo json_encode($siswa);
}
