<?php

ob_start(); // Start output buffering

$halaman = 'sekretaris';


include 'function.php';

if (!isset($_SESSION['login']) && $_SESSION['login'] != true) {
    header("Location: login.php");

    exit();
}

if ($_SESSION['level'] == 'Sekretaris') {
    header("Location: siswa.php");
}
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $sql = "DELETE FROM user WHERE userID=$id";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        echo "
    <script>
    alert('Data berhasil di hapus!');
    document.location.href = 'user.php';
    </script>";
    }
}
if (isset($_POST['tambahsekretaris'])) {
    if (tambahsekretaris($_POST) == true) {
        $message = "Sekretaris berhasil ditambahkan!";
        $alertClass = "alert-success";
    } else {
        $message = "Sekretaris gagal ditambahkan!";
        $alertClass = "alert-danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sekretaris | AgendaKelas</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- CSS SELECT 2 -->
    <link rel="stylesheet" href="dist/css/select2.css">
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
                            <h1 class="m-0">Data Sekretaris SMK Negeri 1 Gantar</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">admin</a></li>
                                <li class="breadcrumb-item active">user</li>
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
                        <?php if (isset($message) && !empty($message)) : ?>

                            <div class="alert <?= $alertClass ?> alert-dismissible fade show mt-2" role="alert" id="autoHideAlert">
                                <?= $message ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <?php header("refresh:5;url=siswa.php") ?>

                        <?php endif; ?>

                        <div class="card-header">
                            <h3 class="card-title">Data Akun Sekretaris</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <button type="button" class="btn btn-outline-success mb-2" data-toggle="modal"
                                data-target="#modal-tambah">[+] Tambah Akun Sekretaris</button>
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Sekretaris</th>
                                            <th>Username</th>
                                            <th>Nama Lengkap</th>
                                            <th>Kelas</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = getAllSekretaris();
                                        $no = 0;
                                        while ($row = mysqli_fetch_array($sql)) {
                                            $no++;
                                            $idkelas = $row['kelasID'];
                                            $idsiswa = $row['siswaID'];
                                            $getkelas = mysqli_query(
                                                $conn,
                                                "SELECT kelasmaster.nama_kelas from kelasmaster inner join sekretaris on kelasmaster.kelasID = '$idkelas'"
                                            );

                                            $getnama = mysqli_query(
                                                $conn,
                                                "SELECT siswa.nama from siswa inner join sekretaris on siswa.siswaID = '$idsiswa'"
                                            );

                                            $nama = mysqli_fetch_array($getnama)['nama'];

                                            $kelas = mysqli_fetch_array($getkelas)['nama_kelas'];

                                        ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td>ID <?= $row['sekretarisID'] ?></td>
                                                <td><?= $row['username']; ?></td>
                                                <td><?= $nama ?></td>
                                                <td><?= $kelas; ?></td>
                                                <td>
                                                    <button
                                                        class="btn btn-outline-warning"
                                                        data-toggle="modal"
                                                        data-target="#modal-edit"
                                                        data-username="<?= $row['username'] ?>"
                                                        data-level="<?= $row['level'] ?>"
                                                        data-userid="<?= $row['userID'] ?>">
                                                        Edit
                                                    </button>

                                                    <!-- modal -->

                                                    <a href="user.php?hapus=<?= $row['userID'] ?>"
                                                        class="btn btn-outline-danger">
                                                        Hapus
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
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

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
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
                                    <div class="mb-3">
                                        <label for="kelas" class="form-label">Kelas</label>
                                        <select name="kelas" id="inputkelas" class="form-control">
                                            <option value="" disabled selected>Pilih Kelas</option>
                                            <?php
                                            $ambilkelas = mysqli_query($conn, "SELECT * FROM kelasmaster");
                                            while ($row = mysqli_fetch_array($ambilkelas)) { ?>
                                                <option value="<?php echo $row['kelasID']; ?>">
                                                    <?php echo htmlspecialchars($row['nama_kelas'], ENT_QUOTES, 'UTF-8'); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="siswa" class="form-label">Pilih Siswa</label>
                                        <select name="siswa" id="inputsiswa" class="form-control">
                                            <option value="" disabled selected>-- Pilih Siswa</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputusername">Username</label>
                                        <input type="text" id="inputusername" class="form-control" name="username">
                                    </div>

                                    <div class="form-group">
                                        <label for="inputpassword">Password</label>
                                        <input type="password" id="inputpassword" class="form-control" name="password">
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="tambahsekretaris">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit User</h4>
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
                                        <label for="exampleInputEmail1">ID</label>
                                        <input type="text" readonly class="form-control" id="iduser" name="id">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Username</label>
                                        <input type="text" class="form-control" id="username" name="username">
                                    </div>
                                    <div class=" form-group">
                                        <label for="level">Level</label>
                                        <select name="level" id="level" class="form-control">
                                            <option value=""></option>
                                            <option value="Kepala Sekolah" id="kepalasekolah">Kepala Sekolah</option>
                                            <option value="Admin" id="admin">Admin</option>
                                            <option value="Sekretaris" id="sek">Sekretaris</option>
                                            <option value="Wakil Kepala Sekolah" id="waka">Wakil Kepala Sekolah</option>
                                            <option value="Guru" id="guru">Guru</option>
                                        </select>
                                    </div>

                                </div>
                                <!-- /.card-body -->



                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="edit">Save changes</button>
                                </div>
                        </div>
                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
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

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard2.js"></script>
    <script>
        $(document).ready(function() {
            $('#example1').DataTable();

            $("#inputkelas").select2({
                placeholder: "Pilih Kelas", // Placeholder untuk dropdown
                allowClear: true, // Tambahkan opsi clear
            });

            $("#inputsiswa").select2({
                placeholder: "Pilih Siswa", // Placeholder untuk dropdown
                allowClear: true, // Tambahkan opsi clear
            });

            $('#inputkelas').on('change', function() {
                let kelasID = $(this).val(); // Ambil value kelas yang dipilih
                if (kelasID) {
                    $.ajax({
                        url: 'ajax/get_siswa.php', // File PHP untuk mengambil data siswa
                        type: 'GET',
                        data: {
                            kelasID: kelasID
                        }, // Kirim kelasID ke server
                        dataType: 'json',
                        success: function(data) {
                            $('#inputsiswa').empty(); // Kosongkan dropdown siswa
                            $('#inputsiswa').append('<option value="" disabled selected>-- Pilih Siswa</option>');
                            $.each(data, function(key, value) {
                                $('#inputsiswa').append('<option value="' + value.siswaID + '">' + value.nama + '</option>');
                            });
                        },
                        error: function() {
                            alert('Gagal mengambil data siswa.');
                        }
                    });
                } else {
                    $('#inputsiswa').empty();
                    $('#inputsiswa').append('<option value="" disabled selected>-- Pilih Siswa</option>');
                }
            });
        });
    </script>
</body>

</html>

<?php
ob_end_flush();  // Send the output to the browser
?>