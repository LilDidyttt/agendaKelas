<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "db_agenda");

if (!$conn) {
    echo "Koneksi error";
}

function getAllKehadiran()
{
    global $conn;
    $sql = mysqli_query($conn, "SELECT * from kehadiran");
    return $sql;
}

function getAllGuru()
{
    global $conn;
    $sql = mysqli_query($conn, "SELECT * from guru");
    return $sql;
}

function getGuruById($id)
{
    global $conn;
    $sql = mysqli_query($conn, "SELECT * FROM guru WHERE guruID=$id");
    header("location: edit-guru.php");
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
