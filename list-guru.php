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

$halaman = 'guru';


if (isset($_POST['edit'])) {
    // Ambil data yang dikirim dari form
    $guruID = $_POST['guruID'];
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $nuptk = $_POST['nuptk'];
    $jk = $_POST['jk'];

    // Update data di database
    $sql = "UPDATE guru SET nama = '$nama', nip = '$nip', nuptk = '$nuptk' jk = '$jk' WHERE guruID = '$guruID'";

    if (mysqli_query($conn, $sql)) {
        $message = "Data guru berhasil diupdate!";
        $alertClass = 'alert-success';
        header("Location: list-guru.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    } else {
        $message = "Gagal mengupdate data guru.";
        $alertClass = 'alert-danger';
        header("Location: list-guru.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    }
}

if (isset($_POST['tambah'])) {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $nuptk = $_POST['nuptk'];
    $jk = $_POST['jk'];

    // Insert data ke database
    $sql = "INSERT INTO guru (nama, nip, nuptk, jk) VALUES ('$nama', '$nip', '$nuptk', '$jk')";

    if (mysqli_query($conn, $sql)) {
        $message = "Data guru berhasil ditambahkan!";
        $alertClass = 'alert-success';
        header("Location: list-guru.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    } else {
        $message = "Gagal menambahkan data guru.";
        $alertClass = 'alert-danger';
        header("Location: list-guru.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    }
}

if (isset($_POST['hapusdata'])) {
    $guruID = $_POST['idguru'];

    if (hapusguru($guruID)) {
        $message = "Data guru berhasil dihapus!";
        $alertClass = 'alert-success';
        header("Location: list-guru.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    } else {
        $message = "Gagal menghapus data guru.";
        $alertClass = 'alert-danger';
        header("Location: list-guru.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    }
}

if (isset($_POST['tambahakun'])) {
    $idguru = $_POST['idguru'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $cekusername = mysqli_query($conn, "SELECT * FROM user where username = '$username'");

    if (mysqli_num_rows($cekusername) == 0) {
        $cek = mysqli_fetch_array($cekusername);
        $enkripsi = password_hash($password, PASSWORD_BCRYPT);

        $query = mysqli_query($conn, "INSERT INTO user (username, password, level) VALUES ('$username', '$enkripsi', 'Guru')");

        if ($query) {

            $iduser = mysqli_insert_id($conn);

            $queryupdate = mysqli_query($conn, "UPDATE guru SET userID = '$iduser' where guruID = '$idguru'");

            if ($queryupdate) {
                $message = "Tambah akun guru berhasil!";
                $alertClass = "alert-success";
                header("Location: list-guru.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
                exit;
            } else {
                $message = "Gagal mengupdate data guru.";
                $alertClass = "alert-danger";
                header("Location: list-guru.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
                exit;
            }
        } else {
            $message = "Gagal menambahkan akun guru.";
            $alertClass = "alert-danger";
            header("Location: list-guru.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
            exit;
        }
    } else {
        $message = "Username sudah terpakai.";
        $alertClass = "alert-danger";
        header("Location: list-guru.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
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
    <title>Data Guru | AgendaKelas</title>

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
                            <h1 class="m-0">Data guru</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Data guru</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
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
                    <!-- tabel kehadiran -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Guru</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#tambahModal"><button class="btn btn-outline-success mb-2">+ Tambah Guru</button></a>
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Guru</th>
                                            <th>Nama Guru</th>
                                            <th>NIP</th>
                                            <th>NUPTK</th>
                                            <th>Jenis Kelamin</th>
                                            <th>ID User</th>
                                            <th>Username</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = getAllGuru();
                                        $no = 0;
                                        while ($row = mysqli_fetch_array($sql)) {
                                            $iduser = $row['userID'];
                                            $query = mysqli_query($conn, "SELECT * from user where userID =  '$iduser'");
                                            $ambilusername = mysqli_fetch_array($query);
                                            $no++
                                        ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $row['guruID']; ?></td>
                                                <td><?= $row['nama']; ?></td>
                                                <td><?= $row['nip'] ?></td>
                                                <td><?= $row['nuptk'] ?></td>
                                                <td><?= $row['jk'] ?></td>
                                                <td><?= (empty($row['userID'])) ? "Tidak ada akun" : $row['userID'] ?></td>
                                                <td><?= (empty($ambilusername['username'])) ? "Tidak ada akun" : $ambilusername['username'] ?></td>
                                                <td>
                                                    <div class="grid gap-3" style="display: grid;">
                                                        <form action="" method="post">
                                                            <input type="hidden" name="idguru" value="<?= $row['guruID'] ?>">
                                                            <button type="submit" onclick="return confirm('Ingin menghapus data guru <?= $row['nama'] ?>')" name="hapusdata" class="btn btn-outline-danger mb-2">Hapus Data</button>
                                                        </form>
                                                        <button
                                                            class="btn btn-outline-warning mb-2"
                                                            data-guru-id="<?= $row['guruID']; ?>"
                                                            data-nama="<?= $row['nama']; ?>"
                                                            data-nip="<?= $row['nip']; ?>"
                                                            data-nuptk="<?= $row['nuptk']; ?>"
                                                            data-jk="<?= $row['jk']; ?>"
                                                            onclick="editGuru(this)">
                                                            Edit
                                                        </button>

                                                        <?php if (empty($row['userID'])) : ?>
                                                            <button class="btn btn-outline-info mb-2" data-idguru="<?= $row['guruID'] ?>" data-namaguru="<?= $row['nama'] ?>">Tambah Akun</button>
                                                        <?php endif; ?>
                                                    </div>
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
                </div><!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Modal untuk Edit Guru -->
        <div class="modal fade" id="editModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Guru</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editGuruForm" action="" method="post">
                            <input type="hidden" name="guruID" id="guruID">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Guru</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" required>
                            </div>
                            <div class="mb-3">
                                <label for="nuptk" class="form-label">NUPTK</label>
                                <input type="text" class="form-control" id="nuptk" name="nuptk" required>
                            </div>
                            <div class="form-group">
                                <label for="jk">Jenis Kelamin</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="laki" name="jk" value="L">
                                    <label for="laki" class="form-check-label">Laki-laki</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="perempuan" name="jk" value="P">
                                    <label for="perempuan" class="form-check-label">Perempuan</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk Tambah Akun Guru -->
        <div class="modal fade" id="modalAkun">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Akun Guru</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="card card-primary">


                            <!-- form start -->
                            <form action="" method="post">
                                <div class="card-body">
                                    <input type="hidden" name="idguru" id="idguru">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Guru</label>
                                        <input type="text" class="form-control" id="namaguru" readonly name="namaguru">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Username</label>
                                        <input type="text" class="form-control" name="username">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">password</label>
                                        <input type="text" class="form-control" name="password">
                                    </div>
                                </div>
                                <!-- /.card-body -->



                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="tambahakun">Tambah</button>
                                </div>
                        </div>
                        </form>
                    </div>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- Modal untuk Tambah Guru -->
        <div class="modal fade" id="tambahModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Mata Pelajaran</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="tambahMapelForm" action="" method="post">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Guru</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" required>
                            </div>
                            <div class="mb-3">
                                <label for="nuptk" class="form-label">NUPTK</label>
                                <input type="text" class="form-control" id="nuptk" name="nuptk" required>
                            </div>
                            <div class="form-group">
                                <label for="jk">Jenis Kelamin</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="laki" name="jk" value="L">
                                    <label for="laki" class="form-check-label">Laki-laki</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="perempuan" name="jk" value="P">
                                    <label for="perempuan" class="form-check-label">Perempuan</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="tambah" class="btn btn-primary">Tambah Guru</button>
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
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
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

    <!-- jQuery -->
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
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

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard2.js"></script>
    <script>
        $(document).ready(function() {
            $('#example1').DataTable();
        });

        function editGuru(button) {
            var guruID = $(button).data('guru-id');
            var nama = $(button).data('nama');
            var nip = $(button).data('nip');
            var nuptk = $(button).data('nuptk')
            var jk = $(button).data('jk');

            // Isi form di modal dengan data yang sudah diambil
            $('#guruID').val(guruID);
            $('#nama').val(nama);
            $('#nuptk').val(nuptk);
            $('#nip').val(nip);

            // Set radio button berdasarkan nilai jk
            if (jk == 'P') {
                $('#perempuan').prop('checked', true);
            } else {
                $('#laki').prop('checked', true);
            }

            // Tampilkan modal edit
            $('#editModal').modal('show');
        }

        $(document).on('click', '.btn-outline-info', function() {
            var id = $(this).data('idguru');
            var nama = $(this).data('namaguru');

            // Set form values ke modal
            $('#idguru').val(id);
            $('#namaguru').val(nama);
            $('#modalAkun').modal('show');

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

<?php
ob_end_flush();

?>