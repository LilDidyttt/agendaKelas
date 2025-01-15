<?php
session_start();

$conn = mysqli_connect("sql105.byethost22.com", "b22_38103024", "komikanestar", "if0_38102915_db_agenda");

if (!$conn) {
    echo "Koneksi error";
}

function getAllKehadiran()
{
    global $conn;
    $sql = mysqli_query($conn, "SELECT * from kehadiran where DATE(jamHadir) = CURDATE()");
    return $sql;
}

function getAllGuru()
{
    global $conn;
    $sql = mysqli_query($conn, "SELECT * from guru");
    return $sql;
}

function addGuru($data)
{
    global $conn;
    if (isset($data['addGuru'])) {
        $nama = $data['nama'];
        $nip = $data['nip'];
        $jk = $data['jk'];
        $sql = mysqli_query($conn, "INSERT INTO guru (nama, nip, jk) VALUES ('$nama', '$nip', '$jk')");
        return $sql;
    }
}

function getGuruById($id)
{
    global $conn;
    $sql = mysqli_query($conn, "SELECT * FROM guru WHERE guruID=$id");
    return $sql;
}

function editGuru($data)
{
    global $conn;
    if (isset($data['editGuru'])) {
        $id = $data['id'];
        $nama = $data['nama'];
        $nip = $data['nip'];
        $jk = $data['jk'];
        $sql = mysqli_query($conn, "UPDATE guru SET nama='$nama', nip='$nip', jk='$jk' WHERE guruID=$id");
        return $sql;
    }
}

function hapusGuru($id)
{
    global $conn;
    $sql = mysqli_query($conn, "DELETE FROM guru WHERE guruID=$id");
    return $sql;
}

function getAllSiswaFromKelas()
{
    global $conn;
    if ($_SESSION['level'] == 'Admin') {
        $sql = mysqli_query($conn, "SELECT * from siswa");
    } else {
        $kelas = $_SESSION['kelas'];
        $sql = mysqli_query($conn, "SELECT * from siswa WHERE kelasID = '$kelas'");
    }
    return $sql;
}

function getAllMapel()
{
    global $conn;
    $sql = mysqli_query($conn, "SELECT * from mapel");
    return $sql;
}
function getAllUser()
{
    global $conn;
    $sql = mysqli_query($conn, "SELECT * FROM user");
    return $sql;
}
function edituser($data)
{
    global $conn;
    $id = $data['id'];
    $username = $data['username'];
    $level = $data['level'];
    $sql = mysqli_query($conn, "UPDATE `user` SET `username`='$username',`level`='$level' WHERE userID=$id");
    return mysqli_affected_rows($conn);
}
function tambahuser($data)
{
    global $conn;
    $username = $data['username'];
    $password = $data['password'];
    $level    = $data['level'];

    $ceksekretaris = mysqli_query($conn, "SELECT * from sekretaris where username = '$username' );");

    if (mysqli_num_rows($ceksekretaris) == 0) {
        $checkQuery = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($result) > 0) {
            // Username sudah ada
            return -1; // Kode untuk menandakan bahwa username sudah ada
        }

        // Enkripsi password
        $enkripsi = password_hash($password, PASSWORD_BCRYPT);

        // Query untuk menambahkan user baru
        $sql = "INSERT INTO user VALUES(NULL, '$username', '$enkripsi', '$level')";
        $query = mysqli_query($conn, $sql);

        return mysqli_affected_rows($conn);
    } else {
        return -1;
    }

    // Cek apakah username sudah ada di database

}

function tambahsiswa($data)
{
    global $conn;
    $nama = $data['nama'];
    $kelas = $data['kelas'];
    $UID    = $data['UID'];
    $NISN    = $data['NISN'];
    $NIPD    = $data['NIPD'];
    $jk    = $data['jk'];

    if (empty($data['uid'])) {
        $insertsiswa = mysqli_query($conn, "INSERT into siswa values (NULL, '$nama', '$kelas', default , '$NISN', '$NIPD', '$jk')");
    } else {
        $insertsiswa = mysqli_query($conn, "INSERT into siswa values (NULL, '$nama', '$kelas', '$UID', '$NISN', '$NIPD', '$jk')");
    }

    if ($insertsiswa) {
        return true;
    } else {
        return false;
    }
}

function editsiswa($data)
{
    global $conn;
    $id = $data['id'];
    $nama = $data['nama'];
    $kelas = $data['kelas'];
    $nisn    = $data['nisn'];
    $nipd    = $data['nipd'];
    $jk    = $data['jk'];

    $updatesiswa = mysqli_query($conn, "UPDATE siswa SET nama='$nama', kelasID='$kelas', nisn='$nisn', nisn='$nisn', jk='$jk' WHERE siswaID=$id");

    return mysqli_affected_rows($conn);
}

function hapussiswa($id)
{
    global $conn;
    $sql = mysqli_query($conn, "DELETE FROM siswa WHERE siswaID=$id");
    if ($sql) {
        return true;
    } else {
        return false;
    }
}


function getAllAgenda()
{
    global $conn;
    $sql = mysqli_query($conn, "SELECT * FROM agenda");
    return $sql;
}

function tambahagenda($data)
{
    global $conn;
    $kelas = $data['kelas'];
    $guru = $data['guru'];
    $mapel = $data['mapel'];
    $keterangan = $data['keterangan'];
    $jam =  $data['jam'];
    $materi = $data['materi'];

    $insertagenda = mysqli_query($conn, "INSERT INTO agenda (guruID, kelasID, KodeMapel, materi, keterangan, jamPelajaran) values ('$guru', '$kelas', '$mapel', '$materi', '$keterangan', '$jam')");

    if ($insertagenda) {
        return true;
    } else {
        return false;
    }
}

function getAgendaGuru()
{
    global $conn;
    $iduser = $_SESSION['iduser'];
    $getidguru = mysqli_query($conn, "SELECT * FROM guru WHERE userID = '$iduser'");
    $ambilidguru = mysqli_fetch_array($getidguru);
    $idguru = $ambilidguru['guruID'];
    $sql = mysqli_query($conn, "SELECT * FROM agenda where GuruID = $idguru");
    return $sql;
}

function selectKelas()
{
    global $conn;
    $sql = mysqli_query($conn, "SELECT kelas from siswa group by kelas");
    return $sql;
}

function getAllSiswaTerlambat()
{
    global $conn;
    $sql = mysqli_query($conn, "SELECT k.*, s.nama 
                                FROM kehadiran k
                                INNER JOIN siswa s ON k.siswaID = s.siswaID
                                WHERE TIME(k.jamHadir) > '07:00:00' 
                                AND DATE(k.jamHadir) = CURDATE()
                                ORDER BY k.jamHadir DESC");
    return $sql;
}

function getWaktuAntara($waktuA, $waktuB)
{
    global $conn;
    $waktuawal = $waktuA;
    $waktuakhir = $waktuB;
    $sql = mysqli_query($conn, "SELECT k.*, s.nama
                                FROM kehadiran k
                                INNER JOIN siswa s ON k.siswaID = s.siswaID
                                WHERE 
                                    (TIME(k.jamHadir) > '07:00:00')
                                    AND
                                    (DATE(k.jamHadir) BETWEEN '$waktuawal' AND '$waktuakhir')
                                ORDER BY k.jamHadir DESC
                                ");
    return $sql;
}

function getAllSekretaris()
{
    global $conn;
    $getdata = mysqli_query($conn, "SELECT * from sekretaris");
    return $getdata;
}

function getAllKelas()
{
    global $conn;
    $getdata = mysqli_query($conn, "SELECT * from kelasmaster");
    return $getdata;
}

function tambahsekretaris($data)
{
    global $conn;
    $username = $data['username'];
    $password = $data['password'];
    $kelasID  = $data['kelas'];
    $siswaID  = $data['siswa'];

    // Cek apakah username sudah ada di database
    $checkQuery = "SELECT * FROM sekretaris WHERE username = '$username'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // Username sudah ada
        $error = true;
        return $error;
    }

    // Enkripsi password
    $enkripsi = password_hash($password, PASSWORD_BCRYPT);

    // Query untuk menambahkan user baru
    $sql = "INSERT INTO sekretaris VALUES(NULL, '$username', '$siswaID', '$kelasID', '$enkripsi')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        return true;
    } else {
        return false;
    }
}
function editsekretaris($data)
{
    global $conn;
    $id = $data['id'];
    $username = $data['username'];
    $kelasID  = $data['kelas'];
    $siswaID  = $data['siswa'];

    // Query untuk menambahkan user baru
    $sql = "UPDATE sekretaris set username = '$username', kelasID = '$kelasID', siswaID = '$siswaID' where sekretarisID = '$id'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        return true;
    } else {
        return false;
    }
}

function hapussekretaris($id)
{
    global $conn;
    $sql = mysqli_query($conn, "DELETE FROM sekretaris WHERE sekretarisID=$id");
    if ($sql) {
        return true;
    } else {
        return false;
    }
}

function resetpassword($data)
{
    global $conn;
    $id = $data['id'];
    $password = $data['password-baru'];

    $hash = password_hash($password, PASSWORD_BCRYPT);

    if (mysqli_query($conn, "UPDATE sekretaris SET password = '$hash' WHERE sekretarisID = '$id'")) {
        return true;
    } else {
        return false;
    }
}
