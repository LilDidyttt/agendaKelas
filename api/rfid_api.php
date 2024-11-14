<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_project";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan UID dari query string
$uid = isset($_GET['uid']) ? strtoupper(trim($_GET['uid'])) : '';

if (!empty($uid)) {
    // Query untuk mendapatkan siswaID berdasarkan UID
    $sql = "SELECT siswaID FROM siswa WHERE uid = '$uid'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Jika UID ditemukan, ambil siswaID
        $row = $result->fetch_assoc();
        $siswaID = $row['siswaID'];

        // Dapatkan waktu saat ini untuk jamHadir
        $jamHadir = date("Y-m-d H:i:s");

        // Masukkan data ke tabel kehadiran
        $insertSQL = "INSERT INTO kehadiran (siswaID, jamHadir, keterangan) VALUES ('$siswaID', '$jamHadir', 'hadir')";

        if ($conn->query($insertSQL) === TRUE) {
            echo "true";  // Berhasil menambahkan kehadiran
        } else {
            echo "error"; // Gagal menambahkan kehadiran
        }
    } else {
        // UID tidak ditemukan di tabel siswa
        echo "false";
    }
} else {
    echo "No UID provided.";
}

// Tutup koneksi
$conn->close();