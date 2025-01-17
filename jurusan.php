<?php

ob_start(); // Start output buffering

include 'function.php';

if (!isset($_SESSION['login']) && $_SESSION['login'] != true) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['level'] == 'Sekretaris') {
    header("Location: siswa.php");
}

$halaman = 'jurusan';

if (isset($_POST['tambah'])) {
    if (tambahjurusan($_POST)) {
        $message = "Jurusan berhasil ditambahkan!";
        $alertClass = "alert-success";
    } else {
        $message = "Jurusan gagal ditambahkan!";
        $alertClass = "alert-danger";
    }
}

if (isset($_POST['hapusdata'])) {
    $idjurusan = $_POST['idjurusan'];

    if (hapusjurusan($idjurusan)) {
        $message = "Jurusan berhasil dihapus.";
        $alertClass = "alert-success";
    } else {
        $message = "Jurusan gagal dihapus.";
        $alertClass = "alert-danger";
    }
}

if (isset($_POST['edit'])) {
    if (editjurusan($_POST)) {
        $message = "Jurusan berhasil diupdate!";
        $alertClass = "alert-success";
    } else {
        $message = "Jurusan gagal diupdate!";
        $alertClass = "alert-danger";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Jurusan | AgendaKelas</title>

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
                            <h1 class="m-0">Jurusan</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Jurusan</li>
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
                            <h3 class="card-title">Data Jurusan</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php if (isset($message) && !empty($message)) : ?>

                                <div class="alert <?= $alertClass ?> alert-dismissible fade show" role="alert" id="autoHideAlert">
                                    <?= $message ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <?php header("refresh:5;url=jurusan.php") ?>

                            <?php endif; ?>
                            <a href="#" data-toggle="modal" data-target="#tambahModal"><button
                                    class="btn btn-outline-success mb-2">+ Tambah Jurusan</button></a>
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Jurusan</th>
                                            <th>Nama Jurusan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = getAllJurusan();
                                        $no = 0;
                                        while ($row = mysqli_fetch_array($sql)) {
                                            $no++
                                        ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td>ID <?= $row['jurusanID']; ?></td>
                                                <td><?= $row['nama_jurusan']; ?></td>
                                                <td>
                                                    <button class="btn btn-outline-warning mb-2"
                                                        data-target="#modal-edit"
                                                        data-toggle="modal"
                                                        data-kode="<?= $row['jurusanID']; ?>"
                                                        data-nama="<?= $row['nama_jurusan']; ?>">Edit</button>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="idjurusan" value="<?= $row['jurusanID'] ?>">
                                                        <button type="submit" onclick="return confirm('Ingin menghapus data jurusan <?= $row['nama_jurusan'] ?>? Data kelas dengan jurusan ini akan ikut terhapus.')" name="hapusdata" class="btn btn-outline-danger">Hapus Data</button>
                                                    </form>
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
                    <!-- /.card -->
                </div>
                <!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Edit Modal -->
        <div class="modal fade" id="modal-edit">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Mata Pelajaran</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="jurusanid" class="form-label">ID Jurusan : <span id="spanID">-</span></label>
                                <input type="hidden" class="form-control" id="jurusanid" name="id_jurusan" readonly
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="namajurusan" class="form-label">Nama Jurusan</label>
                                <input type="text" class="form-control" id="namajurusan" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk Tambah Mata Pelajaran -->
        <div class="modal fade" id="tambahModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Mata Jurusan</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="namaMapel" class="form-label">Nama Jurusan</label>
                                <input type="text" class="form-control" id="namaMapel" name="nama_jurusan" required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="tambah" class="btn btn-primary">Tambah Jurusan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


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

        $(document).on('click', '.btn-outline-warning', function() {
            var jurusanID = $(this).data('kode');
            var namaJurusan = $(this).data('nama');

            var spanID = document.getElementById('spanID');

            // Set form values ke modal
            spanID.textContent = jurusanID;
            $('#namajurusan').val(namaJurusan);
            $('#jurusanid').val(jurusanID);

            // Set ID hidden di form agar nanti dikirim saat submit
        });
    </script>
</body>

</html>

<?php
ob_end_flush();  // Send the output to the browser
?>