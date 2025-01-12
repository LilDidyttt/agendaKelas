<?php

ob_start();

include 'function.php';

if (!isset($_SESSION['login']) && $_SESSION['login'] != true) {
    header("Location: login.php");

    exit();
}
if ($_SESSION['level'] == 'Sekretaris') {
    header("Location: siswa.php");
}
if ($_SESSION['level'] == 'Guru') {
    header("Location: agendasaya.php");
}

$halaman = 'index';

$sql = mysqli_query($conn, "SELECT * FROM setjam limit 1");
$jam = mysqli_fetch_assoc($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | AgendaKelas</title>

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
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
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
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-stopwatch"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Set Waktu Pulang</span>
                                    <form action="" method="post">
                                        <div class="input-group">
                                            <input type="time" name="waktu" value="<?= $jam['jamPulang'] ?>" class="form-control">
                                        </div>
                                        <button class="btn mt-1 btn-primary" name="set">Set</button>
                                    </form>

                                </div>
                                <?php
                                if (isset($_POST['set'])) {
                                    $jam = $_POST["waktu"];
                                    $sql = mysqli_query($conn, "UPDATE setjam SET jamPulang = '$jam' WHERE jamID =1 ");

                                    if ($sql) {
                                        $message = "Jam pulang berhasil di set ke jam " . date('H:i', strtotime($jam)) . ".";
                                        $alertClass = "alert-success";
                                    } else {
                                        $message = "Terjadi Kesalahan.";
                                        $alertClass = "alert-danger";
                                    }
                                }
                                ?>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <?php if (isset($message) && !empty($message)) : ?>
                        <div class="card">
                            <div class="card-body">

                                <div class="alert <?= $alertClass ?> alert-dismissible fade show" role="alert" id="autoHideAlert">
                                    <?= $message ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <?php header("refresh:3;url=index.php") ?>

                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- tabel kehadiran -->
                    <div class="content">
                        <div class="container-fluid">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Kehadiran Siswa</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>ID Siswa</th>
                                                    <th>Nama Siswa</th>
                                                    <th>Jam Hadir</th>
                                                    <th>Jam Pulang</th>
                                                    <th>Keterangan</th>
                                                    <th>Ket. Pulang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = getAllKehadiran();
                                                $no = 0;
                                                while ($row = mysqli_fetch_array($sql)) {
                                                    $idsiswa = $row['siswaID'];
                                                    $ambilnama = mysqli_query($conn, "select * from siswa where siswaID = '$idsiswa'");
                                                    $s = mysqli_fetch_array($ambilnama);
                                                    $no++
                                                ?>
                                                    <tr>
                                                        <td><?= $no; ?></td>
                                                        <td><?= $row['siswaID']; ?></td>
                                                        <td><?= $s['nama']; ?></td>
                                                        <td><?= date("d M Y H:i:s", strtotime($row['jamHadir'])) ?></td>
                                                        <td><?= ($row['ketPulang'] == 'Sudah') ? date("d M Y H:i:s", strtotime($row['jamPulang'])) : $row['jamPulang'] ?>
                                                        </td>
                                                        <td><?= $row['keterangan'] ?></td>
                                                        <td><?= $row['ketPulang'] ?></td>
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
        $(document).ready(function() {
            $('#example1').DataTable();
        });

        $(document).on('click', '#logout-btn', function() {
            Swal.fire({
                title: 'Ingin logout?',
                text: `Kamu akan keluar dari aplikasi AgendaKelas`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna menekan tombol "Ya, hapus!", arahkan ke URL
                    window.location.href = `logout.php`;
                }
            });
        });
    </script>
</body>

</html>

<?php
ob_end_flush();
?>