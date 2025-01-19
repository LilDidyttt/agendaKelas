<?php

ob_start(); // Start output buffering

include 'function.php';

if (!isset($_SESSION['login']) && $_SESSION['login'] != true) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['level'] == 'Sekretaris') {
    header("Location: siswa.php");
    exit();
}

$halaman = 'kelas';

if (isset($_POST['tambah'])) {
    if (tambahkelas($_POST)) {
        $message = "Kelas berhasil ditambahkan!";
        $alertClass = "alert-success";
        header("Location: kelas.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    } else {
        $message = "Kelas gagal ditambahkan!";
        $alertClass = "alert-danger";
        header("Location: kelas.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    }
}

if (isset($_POST['hapusdata'])) {
    $idkelas = $_POST['idkelas'];

    if (hapuskelas($idkelas)) {
        $message = "Kelas berhasil dihapus.";
        $alertClass = "alert-success";
        header("Location: kelas.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    } else {
        $message = "Kelas gagal dihapus.";
        $alertClass = "alert-danger";
        header("Location: kelas.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    }
}

if (isset($_POST['edit'])) {
    if (editkelas($_POST)) {
        $message = "Kelas berhasil diupdate!";
        $alertClass = "alert-success";
        header("Location: kelas.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    } else {
        $message = "Kelas gagal diupdate!";
        $alertClass = "alert-danger";
        header("Location: kelas.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    }

    if (isset($_GET['message']) && isset($_GET['alertClass'])) {
        $message = urldecode($_GET['message']);
        $alertClass = urldecode($_GET['alertClass']);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Kelas | AgendaKelas</title>

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
                            <h1 class="m-0">Kelas</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Kelas</li>
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
                            <h3 class="card-title">Data Kelas</h3>
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

                                <script>
                                    // Menghilangkan alert setelah 5 detik
                                    setTimeout(function() {
                                        var alertElement = document.getElementById('autoHideAlert');
                                        if (alertElement) {
                                            alertElement.style.display = 'none'; // Sembunyikan elemen
                                        }
                                    }, 5000); // 5000ms = 5 detik

                                    // Menghapus parameter GET dari URL setelah 5 detik
                                    setTimeout(function() {
                                        const url = new URL(window.location.href);
                                        url.searchParams.delete('message');
                                        url.searchParams.delete('alertClass');
                                        window.history.replaceState({}, document.title, url.toString());
                                    }, 5000); // Sesuaikan waktu dengan alert menghilang
                                </script>
                            <?php endif; ?>
                            <a href="#" data-toggle="modal" data-target="#tambahModal"><button
                                    class="btn btn-outline-success mb-2">+ Tambah Kelas</button></a>
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Kelas</th>
                                            <th>Nama Kelas</th>
                                            <th>Nama Jurusan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = getAllKelas();
                                        $no = 0;
                                        while ($row = mysqli_fetch_array($sql)) {
                                            $getNamaJurusan = mysqli_query($conn, "SELECT * from jurusan where jurusanID = {$row['jurusanID']}");
                                            $namaJurusan = mysqli_fetch_assoc($getNamaJurusan)['nama_jurusan'];
                                            $no++
                                        ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td>ID <?= $row['kelasID']; ?></td>
                                                <td><?= $row['nama_kelas']; ?></td>
                                                <td><?= $namaJurusan ?></td>
                                                <td>
                                                    <button class="btn btn-outline-warning mb-2"
                                                        data-target="#modal-edit"
                                                        data-toggle="modal"
                                                        data-id="<?= $row['kelasID']; ?>"
                                                        data-nama="<?= $row['nama_kelas']; ?>"
                                                        data-jurusanid="<?= $row['jurusanID'] ?>">Edit</button>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="idkelas" value="<?= $row['kelasID'] ?>">
                                                        <button type="submit" onclick="return confirm('Ingin menghapus data kelas <?= $row['nama_kelas'] ?>? Data siswa dengan kelas ini akan ikut terhapus.')" name="hapusdata" class="btn btn-outline-danger">Hapus Data</button>
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
                        <h5 class="modal-title" id="editModalLabel">Edit Kelas</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="editkelasid" class="form-label">ID Kelas : <span id="spanID">-</span></label>
                                <input type="hidden" class="form-control" id="editkelasid" name="id_kelas" readonly
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="editnamakelas" class="form-label">Nama Kelas</label>
                                <input type="text" class="form-control" id="editnamakelas" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="jurusan">Jurusan</label>
                                <select name="jurusan" id="editjurusan" class="form-control">
                                    <option value="" disabled selected>Pilih Jurusan</option>
                                    <?php
                                    $ambiljurusan = mysqli_query($conn, "SELECT * FROM jurusan");
                                    while ($row = mysqli_fetch_array($ambiljurusan)) { ?>
                                        <option value="<?php echo $row['jurusanID']; ?>"><?php echo htmlspecialchars($row['nama_jurusan'], ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php
                                    }
                                    ?>
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

        <!-- Modal untuk Tambah Mata Pelajaran -->
        <div class="modal fade" id="tambahModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Kelas</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="namaKelas" class="form-label">Nama Kelas</label>
                                <input type="text" class="form-control" id="namaKelas" name="nama_kelas" required>
                            </div>
                            <div class="form-group">
                                <label for="jurusan">Jurusan</label>
                                <select name="jurusan" id="jurusan" class="form-control">
                                    <option value="" disabled selected>Pilih Jurusan</option>
                                    <?php
                                    $ambiljurusan = mysqli_query($conn, "SELECT * FROM jurusan");
                                    while ($row = mysqli_fetch_array($ambiljurusan)) { ?>
                                        <option value="<?php echo $row['jurusanID']; ?>"><?php echo htmlspecialchars($row['nama_jurusan'], ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="tambah" class="btn btn-primary">Tambah Kelas</button>
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

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

    <!-- AdminLTE for demo purposes -->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard2.js"></script>
    <script>
        $(document).ready(function() {
            $('#example1').DataTable();

            $("#jurusan").select2({
                placeholder: "Pilih Jurusan", // Placeholder untuk dropdown
                allowClear: true, // Tambahkan opsi clear
            });

            $("#editjurusan").select2({
                placeholder: "Pilih Jurusan", // Placeholder untuk dropdown
                allowClear: true, // Tambahkan opsi clear
            });
        });

        $(document).on('click', '.btn-outline-warning', function() {
            var kelasid = $(this).data('id');
            var namakelas = $(this).data('nama');
            var jurusanid = $(this).data('jurusanid');

            var spanID = document.getElementById('spanID');

            // Set form values ke modal
            spanID.textContent = kelasid;
            $('#editnamakelas').val(namakelas);
            $('#editkelasid').val(kelasid);

            $('#editjurusan').val(jurusanid).trigger('change');

            // Set ID hidden di form agar nanti dikirim saat submit
        });
    </script>
</body>

</html>

<?php
ob_end_flush();  // Send the output to the browser
?>