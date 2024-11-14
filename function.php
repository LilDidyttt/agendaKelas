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
function getAllSiswaFromKelas()
{
    global $conn;
    $sql = mysqli_query($conn, "SELECT * from siswa WHERE kelas = '12 RPL 1'");
    return $sql;
}
function getAllMapel()
{
    global $conn;
    $sql = mysqli_query($conn, "SELECT * from mapel");
    return $sql;
}
