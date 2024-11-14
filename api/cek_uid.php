<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_agenda";

// Set zona waktu sesuai lokasi
date_default_timezone_set('Asia/Jakarta');

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

        // Mendapatkan tanggal dan jam sekarang
        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");

        // Cek apakah sudah ada data kehadiran siswa untuk hari ini
        $checkSQL = "SELECT * FROM kehadiran WHERE siswaID = '$siswaID' AND DATE(jamHadir) = '$currentDate'";
        $checkResult = $conn->query($checkSQL);

        if ($checkResult->num_rows > 0) {
            // Ambil data kehadiran
            $attendanceData = $checkResult->fetch_assoc();

            // Cek apakah sudah absen pulang
            if ($attendanceData['ketPulang'] == 'Sudah') {
                echo "sudahAbsenLengkap"; // Sudah absen masuk dan pulang
            } else {
                // Cek apakah sudah waktunya pulang (setelah jam 15:00)
                if (strtotime($currentTime) >= strtotime('15:00:00')) {
                    // Jika sudah jam 15:00 atau lebih, update ketPulang menjadi Sudah
                    $updateSQL = "UPDATE kehadiran 
                                 SET ketPulang = 'Sudah'
                                 WHERE siswaID = '$siswaID' 
                                 AND DATE(jamHadir) = '$currentDate'";

                    if ($conn->query($updateSQL) === TRUE) {
                        echo "updated";  // Berhasil update ketPulang
                    } else {
                        echo "error"; // Gagal update
                    }
                } else {
                    // Jika belum jam 15:00, jangan update dan beri pesan
                    echo "belumWaktuPulang";
                }
            }
        } else {
            // Jika belum ada data untuk hari ini, insert baru
            $insertSQL = "INSERT INTO kehadiran (siswaID, jamHadir, keterangan, ketPulang) 
                         VALUES ('$siswaID', NOW(), 'Hadir', 'Belum')";

            if ($conn->query($insertSQL) === TRUE) {
                echo "inserted";  // Berhasil insert data baru
            } else {
                echo "error"; // Gagal insert
            }
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