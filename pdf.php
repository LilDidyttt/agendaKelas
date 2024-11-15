<?php
include "function.php";
// Load Dompdf melalui autoload Composer
require_once __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;  
$sql  = getWaktuAntara($_POST["A"],$_POST["B"]);
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman PDF</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f4f4f4;
    }
    </style>
</head>

<body>
    <h1>Data untuk PDF</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Siswa</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Kelamin</th>
                <th>Jam Hadir</th>
            </tr>
        </thead>
        <tbody>
            <?php
                                    
                                    $no = 0;
                                    while ($row = mysqli_fetch_array($sql)) {
                                        $idsiswa = $row['siswaID'];
                                        $s = mysqli_query($conn, "SELECT * FROM siswa WHERE siswaID = $idsiswa");
                                        $siswa = mysqli_fetch_assoc($s);
                                        $no++;
                                    ?>
            <tr>
                <td><?= $no; ?></td>
                <td><?= $row['siswaID']; ?></td>
                <td><?= $siswa['nama']; ?></td>
                <td><?= $siswa['kelas']; ?></td>
                <td><?= $siswa['jk'] ?></td>
                <td><?= date("d M Y H:i:s", strtotime($row['jamHadir'])) ?></td>
            </tr>
            <?php
                                    }
                                    ?>
        </tbody>
    </table>

</body>

</html>
<?php  
$html = ob_get_clean();

// Buat instance Dompdf
$dompdf = new Dompdf();

// Masukkan HTML ke Dompdf
$dompdf->loadHtml($html);

// Atur ukuran kertas dan orientasi
$dompdf->setPaper('A4', 'portrait');

// Render HTML menjadi PDF
$dompdf->render();

// Tampilkan file PDF di browser
$dompdf->stream("data_waktu.pdf", ["Attachment" => true]);
?>
?>