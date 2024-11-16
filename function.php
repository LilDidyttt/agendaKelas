<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "db_agenda");

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
        $sql = mysqli_query($conn, "SELECT * from siswa WHERE kelas = '$kelas'");
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
    $username   = $data['username'];
    $password   = $data['password'];
    $level      = $data['level'];

    $enkripsi = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO user VALUES(NULL,'$username','$enkripsi','$level')";
    $query = mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
}

function getAllAgenda()
{
    global $conn;
    $sql = mysqli_query($conn, "SELECT * FROM agenda");
    return $sql;
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
