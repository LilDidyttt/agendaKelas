<?php

ob_start(); // Start output buffering

include 'function.php';

if (isset($_POST['edit'])) {
    $keterangan = mysqli_real_escape_string($conn, $_POST['status_kehadiran']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $idsiswa = mysqli_real_escape_string($conn, $_POST['idsiswa']);

    $cek = mysqli_query($conn, "SELECT * FROM keterangan WHERE siswaID = '$idsiswa' AND DATE(tanggal) = CURDATE() ");

    if (mysqli_fetch_array($cek) > 0) {
        $setket = mysqli_query($conn, "UPDATE keterangan set keterangan = '$keterangan' where siswaID = '$idsiswa' AND DATE(tanggal) = CURDATE()");
    } else {
        $setket = mysqli_query($conn, "INSERT into keterangan (siswaID, keterangan) values ('$idsiswa',  '$keterangan')");
    }

    if ($setket) {
        $message = "Keterangan " . $nama . " diubah menjadi " . $keterangan . ".";
        $alertClass = "alert-success";
    } else {
        $message = "Gagal mengubah keterangan.";
        $alertClass = "alert-danger";
    }
}

if (isset($_POST['tambahuid'])) {
    $kodeuid = mysqli_real_escape_string($conn, $_POST['uid']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $idsiswa = mysqli_real_escape_string($conn, $_POST['idsiswa']);

    $sql = mysqli_query($conn, "UPDATE siswa SET uid = '$kodeuid' where siswaID = '$idsiswa'");

    if ($sql) {
        $message = "Set UID Kartu " . $nama . " berhasil ditambahkan!";
        $alertClass = "alert-success";
    } else {
        $message = "Gagal menambahkan uid.";
        $alertClass = "alert-danger";
    }
}

if (isset($_POST['edituid'])) {
    $kodeuid = mysqli_real_escape_string($conn, $_POST['uid']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $idsiswa = mysqli_real_escape_string($conn, $_POST['idsiswa']);

    $sql = mysqli_query($conn, "UPDATE siswa SET uid = '$kodeuid' where siswaID = '$idsiswa'");
    if ($sql) {
        $message = "UID Kartu " . $nama . " berhasil diubah!";
        $alertClass = "alert-success";
    } else {
        $message = "Gagal mengubah uid.";
        $alertClass = "alert-danger";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Siswa Kelas | AgendaKelas</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
                                <li class="breadcrumb-item active">Data Siswa</li>
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
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                                <?php
                                $sql = mysqli_query($conn, "SELECT COUNT(siswaID) as totalsiswa from siswa WHERE kelas = '12 RPL 1'");
                                $total = mysqli_fetch_array($sql);
                                ?>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Siswa</span>
                                    <span class="info-box-number">
                                        <?= $total['totalsiswa']; ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-injured"></i></span>
                                <?php
                                $sql = mysqli_query($conn, "SELECT COUNT(siswaID) as siswasakit FROM keterangan WHERE keterangan = 'Sakit' AND DATE(tanggal) = CURDATE()");
                                $sakit = mysqli_fetch_array($sql);
                                ?>
                                <div class="info-box-content">
                                    <span class="info-box-text">Siswa Sakit</span>
                                    <span class="info-box-number"><?= $sakit['siswasakit'] ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-check"></i></span>
                                <?php
                                $sql = mysqli_query($conn, "SELECT COUNT(siswaID) as siswaizin FROM keterangan WHERE keterangan = 'Izin' AND DATE(tanggal) = CURDATE()");
                                $izin = mysqli_fetch_array($sql);
                                ?>
                                <div class="info-box-content">
                                    <span class="info-box-text">Siswa Izin</span>
                                    <span class="info-box-number"><?= $izin['siswaizin'] ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-times-circle"></i></span>
                                <?php
                                $sql = mysqli_query($conn, "SELECT COUNT(siswaID) as siswaalpha FROM keterangan WHERE keterangan = 'Alpha' AND DATE(tanggal) = CURDATE()");
                                $total = mysqli_fetch_array($sql);
                                $ambilsiswa = mysqli_query($conn, "SELECT * FROM siswa WHERE siswaID NOT IN (SELECT siswaID FROM kehadiran WHERE DATE(jamHadir) = CURDATE())");
                                $totalalpha = mysqli_num_rows($ambilsiswa) + $total['siswaalpha'] - $izin['siswaizin'] - $sakit['siswasakit'];
                                ?>
                                <div class="info-box-content">
                                    <span class="info-box-text">Siswa Tanpa Keterangan</span>
                                    <span class="info-box-number"><?= $totalalpha; ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- tabel kehadiran -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"> <?= ($_SESSION['level'] == 'Admin') ? "Data Semua Siswa" : "Data Siswa Kelas " . $_SESSION['kelas'] . "." ?></h3>
                        </div>

                        <?php if (isset($message) && !empty($message)) : ?>

                            <div class="alert <?= $alertClass ?> alert-dismissible fade show" role="alert" id="autoHideAlert">
                                <?= $message ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <?php header("refresh:5;url=siswa.php") ?>

                        <?php endif; ?>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Siswa</th>
                                        <th>Nama Siswa</th>
                                        <th>NISN</th>
                                        <th>NIPD</th>
                                        <th>UID Kartu</th>
                                        <th>Jk</th>
                                        <th>Kelas</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = getAllSiswaFromKelas();
                                    $no = 0;
                                    while ($row = mysqli_fetch_array($sql)) {
                                        $idsiswa = $row['siswaID'];
                                        $ambildata = mysqli_query($conn, "SELECT * FROM kehadiran WHERE siswaID = '$idsiswa' AND DATE(jamHadir) = CURDATE()");
                                        $s = mysqli_fetch_array($ambildata);

                                        $ambilket = mysqli_query($conn, "SELECT * from keterangan where siswaID = '$idsiswa' and DATE(tanggal) = CURDATE()");
                                        $ket = mysqli_fetch_array($ambilket);

                                        if (isset($s['keterangan']) && !empty($s['keterangan'])) {
                                            $keterangan = $s['keterangan'];
                                        } elseif (isset($ket['keterangan']) && !empty($ket['keterangan'])) {
                                            $keterangan = $ket['keterangan'];
                                        } else {
                                            $keterangan = "Tidak Ada";
                                        }
                                        $no++
                                    ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $row['siswaID']; ?></td>
                                            <td><?= $row['nama']; ?></td>
                                            <td><?= $row['nisn']; ?></td>
                                            <td><?= $row['nipd']; ?></td>
                                            <td><?= $row['uid']; ?></td>
                                            <td><?= $row['jk']; ?></td>
                                            <td><?= $row['kelas']; ?></td>
                                            <td><?= $keterangan ?></td>
                                            <td>
                                                <button class="btn btn-outline-warning" data-id="<?= $row['siswaID']; ?>" data-nama="<?= $row['nama']; ?>">Tambah Ket</button>
                                                <?php if ($_SESSION['level'] == 'Admin') : ?>
                                                    <?php if ($row['uid'] == "Belum di set") : ?>
                                                        <button class="btn btn-outline-info" data-iduid="<?= $row['siswaID']; ?>" data-namauid="<?= $row['nama']; ?>">Set UID</button>
                                                    <?php else : ?>
                                                        <button class="btn btn-info" data-iduidedit="<?= $row['siswaID']; ?>" data-namauidedit="<?= $row['nama']; ?>" data-uidedit="<?= $row['uid']; ?>">Edit UID</button>
                                                    <?php endif; ?>
                                                <?php endif; ?>
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
                </div><!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Edit Modal -->
        <div class="modal fade" id="modalKet" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Tambah Keterangan Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editMapelForm" action="" method="post">
                            <div class="mb-3">
                                <label for="idsiswa" class="form-label">ID Siswa</label>
                                <input type="text" class="form-control" id="idsiswa" name="idsiswa" readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Siswa</label>
                                <input type="text" class="form-control" id="nama" name="nama" readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="status_kehadiran">Status Kehadiran</label>
                                <select class="form-control" id="status_kehadiran" name="status_kehadiran">
                                    <option value="Sakit">Sakit</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Alpha">Alpha</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- UID Modal -->
        <div class="modal fade" id="modalUID" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Tambah UID Kartu Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editMapelForm" action="" method="post">
                            <div class="mb-3">
                                <label for="idsiswa" class="form-label">ID Siswa</label>
                                <input type="text" class="form-control" id="idsiswauid" name="idsiswa" readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Siswa</label>
                                <input type="text" class="form-control" id="namauid" name="nama" readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="uid" class="form-label">Kode UID Kartu</label>
                                <input type="text" id="uid" class="form-control" name="uid" required>
                            </div>

                            <div class="mb-3">
                                <button type="submit" name="tambahuid" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- UID Edit Modal -->
        <div class="modal fade" id="modalEditUID" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit UID Kartu Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editMapelForm" action="" method="post">
                            <div class="mb-3">
                                <label for="idsiswa" class="form-label">ID Siswa</label>
                                <input type="text" class="form-control" id="idsiswauidedit" name="idsiswa" readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Siswa</label>
                                <input type="text" class="form-control" id="namauidedit" name="nama" readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="uid" class="form-label">Kode UID Kartu</label>
                                <input type="text" class="form-control" id="uidedit" name="uid" required>
                            </div>

                            <div class="mb-3">
                                <button type="submit" name="edituid" class="btn btn-primary">Simpan Perubahan</button>
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
        $(document).on('click', '.btn-outline-warning', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');

            // Set form values ke modal
            $('#idsiswa').val(id);
            $('#nama').val(nama);
            $('#modalKet').modal('show');

            // Set ID hidden di form agar nanti dikirim saat submit
        });

        $(document).on('click', '.btn-outline-info', function() {
            var idUID = $(this).data('iduid');
            var namaUID = $(this).data('namauid');

            // Set form values ke modal
            $('#idsiswauid').val(idUID);
            $('#namauid').val(namaUID);
            $('#modalUID').modal('show');

            // Set ID hidden di form agar nanti dikirim saat submit
        });

        $(document).on('click', '.btn-info', function() {
            var idUID = $(this).data('iduidedit');
            var namaUID = $(this).data('namauidedit');
            var UID = $(this).data('uidedit');

            // Set form values ke modal
            $('#idsiswauidedit').val(idUID);
            $('#namauidedit').val(namaUID);
            $('#uidedit').val(UID);
            $('#modalEditUID').modal('show');

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
ob_end_flush();  // Send the output to the browser
?>