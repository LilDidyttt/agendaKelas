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
