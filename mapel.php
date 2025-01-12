<?php

include 'function.php';

if (!isset($_SESSION['login']) && $_SESSION['login'] != true) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['level'] == 'Sekretaris') {
    header("Location: siswa.php");
}

$halaman = 'mapel';


if (isset($_POST['edit'])) {
    // Ambil data yang dikirim dari form
    $kodeMapel = $_POST['kodeMapel'];
    $namaMapel = $_POST['namaMapel'];

    // Update data di database
    $sql = "UPDATE mapel SET namaMapel = '$namaMapel' WHERE KodeMapel = $kodeMapel";

    if (mysqli_query($conn, $sql)) {
        // Jika berhasil
        echo "<script>alert('Data berhasil diupdate'); window.location.href='mapel.php';</script>";
    } else {
        // Jika gagal
        echo "<script>alert('Gagal memperbarui data');</script>";
    }
}

if (isset($_POST['tambah'])) {
    // Ambil data dari form
    $namaMapel = $_POST['namaMapel'];

    // Insert data ke database
    $sql = "INSERT INTO mapel (KodeMapel, namaMapel) VALUES ('$kodeMapel', '$namaMapel')";

    if (mysqli_query($conn, $sql)) {
        // Jika berhasil
        echo "<script>alert('Mata Pelajaran berhasil ditambahkan'); window.location.href='mapel.php';</script>";
    } else {
        // Jika gagal
        echo "<script>alert('Gagal menambahkan mata pelajaran');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mapel | AgendaKelas</title>

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
                            <h1 class="m-0">Mata Pelajaran</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Mata Pelajaran</li>
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
                            <h3 class="card-title">Data Mata Pelajaran</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#tambahModal"><button
                                    class="btn btn-outline-success mb-2">+ Tambah Mapel</button></a>
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Mapel</th>
                                            <th>Nama Mapel</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = getAllMapel();
                                        $no = 0;
                                        while ($row = mysqli_fetch_array($sql)) {
                                            $no++
                                        ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $row['KodeMapel']; ?></td>
                                                <td><?= $row['namaMapel']; ?></td>
                                                <td>
                                                    <a href="hapusmapel.php?mapel=<?= $row['KodeMapel'] ?>"
                                                        onclick="return confirm('Menghapus mapel <?= $row['namaMapel'] ?> ')"><button
                                                            class="btn btn-outline-danger">Hapus</button></a>
                                                    <button class="btn btn-outline-warning"
                                                        data-kode="<?= $row['KodeMapel']; ?>"
                                                        data-nama="<?= $row['namaMapel']; ?>">Edit</button>
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
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Mata Pelajaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editMapelForm" action="" method="post">
                            <div class="mb-3">
                                <label for="kodeMapel" class="form-label">Kode Mapel</label>
                                <input type="text" class="form-control" id="kodeMapel" name="kodeMapel" readonly
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="namaMapel" class="form-label">Nama Mapel</label>
                                <input type="text" class="form-control" id="namaMapel" name="namaMapel" required>
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
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Mata Pelajaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="tambahMapelForm" action="" method="post">
                            <div class="mb-3">
                                <label for="namaMapel" class="form-label">Nama Mapel</label>
                                <input type="text" class="form-control" id="namaMapel" name="namaMapel" required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="tambah" class="btn btn-primary">Tambah Mata
                                    Pelajaran</button>
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
            var id = $(this).data('id');
            var kodeMapel = $(this).data('kode');
            var namaMapel = $(this).data('nama');

            // Set form values ke modal
            $('#kodeMapel').val(kodeMapel);
            $('#namaMapel').val(namaMapel);
            $('#editModal').modal('show');

            // Set ID hidden di form agar nanti dikirim saat submit
            $('#editMapelForm').data('id', id);
        });


        // Open modal and fill data when clicking "Edit" button
        $(document).on('click', '.btn-outline-success', function() {
            // Set form values ke modal
            $('#tambahModal').modal('show');

            // Set ID hidden di form agar nanti dikirim saat submit
        });
    </script>
</body>

</html>