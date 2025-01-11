<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_agenda";

// Set zona waktu
date_default_timezone_set('Asia/Jakarta');

// Koneksi database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil UID dari query string
$uid = isset($_GET['uid']) ? strtoupper(trim($_GET['uid'])) : '';

if (!empty($uid)) {
    // Cek apakah UID ada di tabel siswa
    $sql = "SELECT siswaID FROM siswa WHERE uid = '$uid'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Jika UID ditemukan
        $row = $result->fetch_assoc();
        $siswaID = $row['siswaID'];
        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");

        // Ambil jam pulang dari database
        $jamPulang = "15:00:00";
        $jamPulangSQL = "SELECT jamPulang FROM setJam LIMIT 1";
        $jamPulangResult = $conn->query($jamPulangSQL);
        if ($jamPulangResult->num_rows > 0) {
            $jamPulangRow = $jamPulangResult->fetch_assoc();
            $jamPulang = $jamPulangRow['jamPulang'];
        }

        // Cek absensi hari ini
        $checkSQL = "SELECT * FROM kehadiran WHERE siswaID = '$siswaID' AND DATE(jamHadir) = '$currentDate'";
        $checkResult = $conn->query($checkSQL);

        if ($checkResult->num_rows > 0) {
            // Sudah ada data kehadiran
            $attendanceData = $checkResult->fetch_assoc();
            if ($attendanceData['ketPulang'] == 'Sudah') {
                echo "sudahAbsenLengkap";
            } else {
                if (strtotime($currentTime) >= strtotime($jamPulang)) {
                    $updateSQL = "UPDATE kehadiran SET ketPulang = 'Sudah' WHERE siswaID = '$siswaID' AND DATE(jamHadir) = '$currentDate'";
                    echo ($conn->query($updateSQL) === TRUE) ? "updated" : "error";
                } else {
                    echo "belumWaktuPulang";
                }
            }
        } else {
            // Insert absensi baru
            $insertSQL = "INSERT INTO kehadiran (siswaID, jamHadir, keterangan, ketPulang) 
                          VALUES ('$siswaID', NOW(), 'Hadir', 'Belum')";
            echo ($conn->query($insertSQL) === TRUE) ? "inserted" : "error";
        }
    } else {
        // UID tidak ditemukan
        echo "kartu Tidak Terdaftar";
    }
} else {
    echo "No UID provided.";
}

$conn->close();
