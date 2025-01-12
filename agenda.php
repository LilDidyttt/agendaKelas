<?php

include 'function.php';

if (!isset($_SESSION['login']) && $_SESSION['login'] != true) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['level'] == 'Kepala Sekolah' && $_SESSION['level'] == 'Wakil Kepala Sekolah') {
    header("Location: siswa-terlambat.php");
    exit();
}

$halaman = 'agenda';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agenda | AgendaKelas</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
    <!-- CSS SELECT 2 -->
    <link rel="stylesheet" href="dist/css/select2.css">

    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <?php include 'template/topbar.php'; ?>

        <?php include 'template/sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Agenda Kelas</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Agenda Kelas</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->

                    <!-- /.row -->

                    <!-- tabel kehadiran -->
                    <div class="container-fluid">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <?php
                                $idkelas = $_SESSION['kelas'];
                                $getnamakelas = mysqli_query(
                                    $conn,
                                    "SELECT kelasmaster.nama_kelas from kelasmaster inner join siswa on kelasmaster.kelasID = '$idkelas'"
                                );
                                $namaKelas = mysqli_fetch_array($getnamakelas)['nama_kelas'];
                                ?>
                                <h3 class="card-title">Data Agenda Kelas
                                    <?= (isset($_SESSION['kelas'])) ? $namaKelas : "" ?>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <?php if ($_SESSION['level'] == 'Sekretaris') : ?>
                                    <button class="btn btn-outline-success mb-2" data-toggle="modal"
                                        data-target="#modal-tambah">+ Tambah Agenda</button>
                                <?php endif; ?>
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Agenda ID</th>
                                                <th>Guru</th>
                                                <th>Kelas</th>
                                                <th>Mata Pelajaran</th>
                                                <th>Materi</th>
                                                <th>Keterangan</th>
                                                <th>Jam Pelajaran</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = getAllAgenda();
                                            $no = 0;
                                            while ($row = mysqli_fetch_array($sql)) {
                                                $idguru = $row['guruID'];
                                                $kodeMapel = $row['KodeMapel'];
                                                $guru = mysqli_query($conn, "select * from guru where guruID = '$idguru'");
                                                $mapel = mysqli_query($conn, "select * from mapel where KodeMapel = '$kodeMapel'");
                                                $g = mysqli_fetch_array($guru);
                                                $m = mysqli_fetch_array($mapel);
                                                $no++
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>

                                                    <td><?= $row["agendaID"] ?></td>
                                                    <td><?= $g['nama']; ?></td>
                                                    <td><?= $row["kelas"] ?></td>
                                                    <td><?= $m["namaMapel"] ?></td>
                                                    <td><?= $row["materi"] ?></td>
                                                    <td><?= $row["keterangan"] ?></td>
                                                    <td><?= $row["jamPelajaran"] ?></td>
                                                    <td><?= date("d M Y H:i:s", strtotime($row['tanggal'])) ?></td>
                                                    <td>
                                                        <a href="?h=<?= $row["agendaID"] ?>" class="btn btn-danger"><i
                                                                class="fas fa-trash"></i>
                                                        </a>
                                                        <a href="editagenda.php?id=<?= $row['agendaID'] ?>"
                                                            class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                                    </td>

                                                </tr>
                                            <?php
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 AgendaKelas.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>
    </div>

    <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Siswa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-primary">
                        <!-- form start -->
                        <form action="" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputNama">Nama</label>
                                    <input type="text" id="exampleInputNama" class="form-control" name="nama">
                                </div>
                                <div class="mb-3">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <select name="kelas" id="kelas" class="form-control">
                                        <option value="" disabled selected>Pilih Kelas</option>
                                        <?php
                                        $ambilkelas = mysqli_query($conn, "SELECT * FROM kelasmaster");
                                        while ($row = mysqli_fetch_array($ambilkelas)) { ?>
                                            <option value="<?php echo $row['kelasID']; ?>"> <?php echo htmlspecialchars($row['nama_kelas'], ENT_QUOTES, 'UTF-8'); ?> </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputUID">UID</label>
                                    <input type="text" id="exampleInputUID" class="form-control" name="UID" placeholder="Boleh dikosongkan.">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputNISN">NISN</label>
                                    <input type="number" id="exampleInputNISN" class="form-control" name="NISN">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputNIPD">NIPD</label>
                                    <input type="text" id="exampleInputNIPD" class="form-control" name="NIPD">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputJK">Jenis Kelamin</label>
                                    <div class="form-check">
                                        <input type="radio" name="jk" value="L" id="laki" class="form-check-input">
                                        <label for="laki" class="form-check-label">Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="jk" value="P" id="perempuan" class="form-check-input">
                                        <label for="perempuan" class="form-check-label">Perempuan</label>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="tambahsiswa">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>

    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <!-- AdminLTE for demo purposes -->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard2.js"></script>
    <script>
        $(document).on('click', '.btn-outline-success', function() {
            var id = $(this).data('id');

            var nama = $(this).data('nama');

            // Set form values ke modal
            $('#idsiswa').val(id);
            $('#nama').val(nama);
            $('#tambahModal').modal('show');

            // Set ID hidden di form agar nanti dikirim saat submit
        });

        $(document).ready(function() {
            $('#example1').DataTable();

            $("#kelas").select2({
                placeholder: "Pilih Kelas", // Placeholder untuk dropdown
                allowClear: true, // Tambahkan opsi clear
            });
        });
    </script>

</body>

</html>
<?php
if (isset($_POST['tambah'])) {

    $idGuru = $_POST['guru'];
    $kelas = $_POST['kelas'];
    $mapel = $_POST['mapel'];
    $materi = $_POST['materi'];
    $keterangan = $_POST['keterangan'];
    $jamPelajaran = $_POST['jampelajaran'];
    $sql = mysqli_query($conn, "INSERT INTO agenda(guruID, kelas, KodeMapel, materi, keterangan, jamPelajaran) VALUES ('$idGuru','$kelas','$mapel','$materi','$keterangan','$jamPelajaran')");
    echo "<script>
 window.location.href = 'agenda.php';
 </script>";
}
if (isset($_GET['h'])) {

    $id = $_GET['h'];
    mysqli_query($conn, "DELETE FROM agenda WHERE agendaID = $id");
    echo "<script>
    window.location.href = 'agenda.php';
    </script>";
}
?>