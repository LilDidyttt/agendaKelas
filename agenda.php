<?php

include 'function.php';

if (!isset($_SESSION['login']) && $_SESSION['login'] != true) {
    header("Location: login.php");
    exit();
}

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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Agenda Kelas
                                <?= (isset($_SESSION['kelas'])) ? $_SESSION["kelas"] : "" ?>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <button class="btn btn-outline-success mb-2" data-bs-toggle="modal"
                                data-bs-target="#tambahModal">+ Tambah Agenda</button>
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
                        <!-- /.card-body -->
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
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Agenda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="tambahMapelForm" action="" method="post">
                        <div class="mb-3">
                            <label for="namaGuru" class="form-label">Nama Guru</label>
                            <select name="guru" id="namaGuru" class="form-control">
                                <option value="">Pilih Guru</option>


                                <?php
                                $sql = getAllGuru();

                                ?>
                                <?php
                                while ($row = mysqli_fetch_assoc($sql)) :
                                ?>
                                <option value="<?= $row["guruID"] ?>">
                                    <?= $row["nama"] ?>
                                </option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select name="kelas" class="form-control" id="kelas">
                                <?php
                                $sql = selectKelas();
                                $kelas = mysqli_fetch_assoc($sql);
                                do { ?>
                                <option value="<?php echo $kelas['kelas'] ?>"><?php echo $kelas['kelas'] ?></option>
                                <?php } while ($kelas = mysqli_fetch_assoc($sql)); ?>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mapel" class="form-label">Mapel</label>
                            <select name="mapel" class="form-control" id="mapel">
                                <?php $sql = getAllMapel();
                                while ($row = mysqli_fetch_assoc($sql)): ?>
                                <option value="<?php echo $row['KodeMapel'] ?>"><?php echo $row['namaMapel'] ?></option>
                                <?php endwhile; ?>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="materi" class="form-label">Materi</label>
                            <input type="text" class="form-control" id="materi" name="materi" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">keterangan</label>
                            <select name="keterangan" id="keterangan" class="form-control">
                                <option value=""></option>
                                <option value="Hadir">Hadir</option>
                                <option value="Tidak Hadir">Tidak Hadir</option>
                                <option value="Tugas">Tugas</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jampelajaran" class="form-label">jam pelajaran</label>
                            <select name="jampelajaran" id="jampelajaran" class="form-control">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="tambah" class="btn btn-primary">Tambah Agenda</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>

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

    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
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