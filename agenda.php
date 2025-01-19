<?php

ob_start(); // Start output buffering


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

if (isset($_POST['tambahagenda'])) {
    if (tambahagenda($_POST)) {
        $message = "Tambah agenda berhasil!";
        $alertClass = 'alert-success';
        header("Location: agenda.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    } else {
        $message = "Gagal menambahkan agenda.";
        $alertClass = 'alert-danger';
        header("Location: agenda.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    }
}

if (isset($_POST['editagenda'])) {
    if (editagenda($_POST)) {
        $message = "Agenda berhasil diubah!";
        $alertClass = 'alert-success';
        header("Location: agenda.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    } else {
        $message = "Gagal mengubah agenda.";
        $alertClass = 'alert-danger';
        header("Location: agenda.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    }
}

if (isset($_POST['hapusagenda'])) {
    $idagenda = $_POST['idagenda'];
    if (hapusagenda($idagenda)) {
        $message = "Agenda berhasil dihapus.";
        $alertClass = 'alert-success';
        header("Location: agenda.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    } else {
        $message = "Gagal menghapus agenda.";
        $alertClass = 'alert-danger';
        header("Location: agenda.php?message=" . urlencode($message) . "&alertClass=" . urlencode($alertClass));
        exit;
    }
}

if (isset($_GET['message']) && isset($_GET['alertClass'])) {
    $message = urldecode($_GET['message']);
    $alertClass = urldecode($_GET['alertClass']);
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
                                            $idkelas = $_SESSION['kelas'];
                                            $getnamakelas = mysqli_query(
                                                $conn,
                                                "SELECT kelasmaster.nama_kelas from kelasmaster inner join siswa on kelasmaster.kelasID = '$idkelas'"
                                            );
                                            $namaKelas = mysqli_fetch_array($getnamakelas)['nama_kelas'];
                                            $no = 0;
                                            while ($row = mysqli_fetch_array($sql)) {
                                                $idguru = $row['guruID'];
                                                $kodeMapel = $row['KodeMapel'];
                                                $guru = mysqli_query($conn, "select * from guru where guruID = '$idguru'");
                                                $mapel = mysqli_query($conn, "select * from mapel where KodeMapel = '$kodeMapel'");
                                                $idkelas = $row['kelasID'];
                                                $getNamaKelas = mysqli_query($conn, "SELECT * from kelasmaster where kelasID = '$idkelas'");
                                                $namaKelas = mysqli_fetch_array($getNamaKelas)['nama_kelas'];
                                                $g = mysqli_fetch_array($guru);
                                                $m = mysqli_fetch_array($mapel);
                                                $no++
                                            ?>
                                                <tr>
                                                    <td><?= $no; ?></td>

                                                    <td>ID <?= $row["agendaID"] ?></td>
                                                    <td><?= $g['nama']; ?></td>
                                                    <td><?= $namaKelas ?></td>
                                                    <td><?= $m["namaMapel"] ?></td>
                                                    <td><?= $row["materi"] ?></td>
                                                    <td><?= $row["keterangan"] ?></td>
                                                    <td><?= $row["jamPelajaran"] ?></td>
                                                    <td><?= date("d M Y H:i:s", strtotime($row['tanggal'])) ?></td>
                                                    <td>
                                                        <div class="grid gap-3" style="display: grid;">
                                                            <button
                                                                class="btn btn-outline-warning mb-2 edit-agenda"
                                                                data-toggle="modal"
                                                                data-target="#modal-edit"
                                                                data-idagenda="<?= $row['agendaID'] ?>"
                                                                data-idguru="<?= $row['guruID'] ?>"
                                                                data-namakelas="<?= $namaKelas ?>"
                                                                data-kodemapel="<?= $row['KodeMapel'] ?>"
                                                                data-materi="<?= $row['materi'] ?>"
                                                                data-keterangan="<?= $row['keterangan'] ?>"
                                                                data-jampelajaran="<?= $row['jamPelajaran'] ?>">
                                                                Edit Agenda
                                                            </button>
                                                            <form action="" method="post">
                                                                <div class="grid gap-3" style="display: grid;">
                                                                    <input type="hidden" name="idagenda" value="<?= $row['agendaID'] ?>">
                                                                    <button type="submit" onclick="return confirm('Ingin menghapus data agenda jam ke - <?= $row['jamPelajaran'] ?>')" name="hapusagenda" class="btn btn-outline-danger">Hapus Data</button>
                                                                </div>
                                                            </form>
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
                    <h4 class="modal-title">Tambah Agenda</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-primary">
                        <!-- form start -->
                        <form action="" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <?php
                                    $idkelas = $_SESSION['kelas'];
                                    $getnamakelas = mysqli_query(
                                        $conn,
                                        "SELECT kelasmaster.nama_kelas from kelasmaster inner join siswa on kelasmaster.kelasID = '$idkelas'"
                                    );
                                    $namaKelas = mysqli_fetch_array($getnamakelas)['nama_kelas'];
                                    ?>
                                    <label for="input-kelas">Kelas : <?= $namaKelas ?></label>
                                    <input type="hidden" id="input-kelas" value="<?= $_SESSION['kelas'] ?>" class="form-control" required name="kelas">
                                </div>
                                <div class="mb-3">
                                    <label for="guru" class="form-label">Guru</label>
                                    <select name="guru" required id="guru" class="form-control">
                                        <option value="" disabled selected>Pilih Guru</option>
                                        <?php
                                        $ambilguru = mysqli_query($conn, "SELECT * FROM guru");
                                        while ($row = mysqli_fetch_array($ambilguru)) { ?>
                                            <option value="<?php echo $row['guruID']; ?>"> <?php echo htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8'); ?> </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="mapel" class="form-label">Mapel</label>
                                    <select name="mapel" required id="mapel" class="form-control">
                                        <option value="" disabled selected>Pilih Mapel</option>
                                        <?php
                                        $ambilmapel = mysqli_query($conn, "SELECT * FROM mapel");
                                        while ($row = mysqli_fetch_array($ambilmapel)) { ?>
                                            <option value="<?php echo $row['KodeMapel']; ?>"> <?php echo htmlspecialchars($row['namaMapel'], ENT_QUOTES, 'UTF-8'); ?> </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="jam" class="form-label">Jam Pelajaran</label>
                                    <select name="jam" required id="jam" class="form-control">
                                        <option value="" disabled selected>Pilih jam pelajaran</option>
                                        <?php
                                        for ($i = 1; $i <= 10; $i++) { ?>
                                            <option value="<?php echo $i ?>"><?php echo "Jam ke - " . $i ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label for="materi" class="form-label">Materi</label>
                                    <textarea id="materi" required class="form-control" rows="3" name="materi"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Keterangan</label>
                                    <div class="form-check">
                                        <input type="radio" value="Hadir" required name="keterangan" class="form-check-input" id="hadir">
                                        <label for="hadir" class="form-check-label">Hadir</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" value="Tidak Hadir" required name="keterangan" class="form-check-input" id="tidak">
                                        <label for="tidak" class="form-check-label">Tidak Hadir</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" value="Tugas" required name="keterangan" class="form-check-input" id="tugas">
                                        <label for="tugas" class="form-check-label">Tugas</label>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="tambahagenda">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data Agenda</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-primary">
                        <form action="" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="input-kelas">Kelas : <span id="spanKelas">-</span></label>
                                    <input type="hidden" id="input-kelas" class="form-control" required name="kelas">
                                    <input type="hidden" id="input-id" class="form-control" required name="id">
                                </div>
                                <div class="mb-3">
                                    <label for="guru" class="form-label">Guru</label>
                                    <select name="guru" required id="edit-guru" class="form-control">
                                        <option value="" disabled selected>Pilih Guru</option>
                                        <?php
                                        $ambilguru = mysqli_query($conn, "SELECT * FROM guru");
                                        while ($row = mysqli_fetch_array($ambilguru)) { ?>
                                            <option value="<?php echo $row['guruID']; ?>"> <?php echo htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8'); ?> </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="mapel" class="form-label">Mapel</label>
                                    <select name="mapel" required id="edit-mapel" class="form-control">
                                        <option value="" disabled selected>Pilih Mapel</option>
                                        <?php
                                        $ambilmapel = mysqli_query($conn, "SELECT * FROM mapel");
                                        while ($row = mysqli_fetch_array($ambilmapel)) { ?>
                                            <option value="<?php echo $row['KodeMapel']; ?>"> <?php echo htmlspecialchars($row['namaMapel'], ENT_QUOTES, 'UTF-8'); ?> </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="jam" class="form-label">Jam Pelajaran</label>
                                    <select name="jam" required id="edit-jam" class="form-control">
                                        <option value="" disabled selected>Pilih jam pelajaran</option>
                                        <?php
                                        for ($i = 1; $i <= 10; $i++) { ?>
                                            <option value="<?php echo $i ?>"><?php echo "Jam ke - " . $i ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label for="materi" class="form-label">Materi</label>
                                    <textarea id="edit-materi" required class="form-control" rows="3" name="materi"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Keterangan</label>
                                    <div class="form-check">
                                        <input type="radio" value="Hadir" required name="keterangan" class="form-check-input" id="edit-hadir">
                                        <label for="hadir" class="form-check-label">Hadir</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" value="Tidak Hadir" required name="keterangan" class="form-check-input" id="edit-tidak">
                                        <label for="tidak" class="form-check-label">Tidak Hadir</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" value="Tugas" required name="keterangan" class="form-check-input" id="edit-tugas">
                                        <label for="tugas" class="form-check-label">Tugas</label>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="editagenda">Save</button>
                            </div>
                        </form>
                    </div>
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

        $(document).on('click', '.edit-agenda', function() {
            var idAgenda = $(this).data('idagenda'); // huruf kecil
            var idGuru = $(this).data('idguru'); // huruf kecil
            var namaKelas = $(this).data('namakelas'); // huruf kecil
            var kodeMapel = $(this).data('kodemapel'); // huruf kecil
            var materi = $(this).data('materi'); // huruf kecil
            var keterangan = $(this).data('keterangan'); // huruf kecil
            var jamPelajaran = $(this).data('jampelajaran'); // huruf kecil

            var spankelas = document.getElementById('spanKelas');
            spankelas.textContent = namaKelas;


            $('#edit-materi').val(materi);
            $('#input-id').val(idAgenda);
            $('#edit-guru').val(idGuru).trigger('change');
            $('#edit-mapel').val(kodeMapel).trigger('change');
            $('#edit-jam').val(jamPelajaran).trigger('change');

            $('input[name="keterangan"][value="' + keterangan + '"]').prop('checked', true);
        });

        $(document).ready(function() {
            $('#example1').DataTable();

            $("#kelas").select2({
                placeholder: "Pilih Kelas", // Placeholder untuk dropdown
                allowClear: true, // Tambahkan opsi clear
            });
            $("#guru").select2({
                placeholder: "Pilih guru", // Placeholder untuk dropdown
                allowClear: true, // Tambahkan opsi clear
            });
            $("#edit-guru").select2({
                placeholder: "Pilih guru", // Placeholder untuk dropdown
                allowClear: true, // Tambahkan opsi clear
            });
            $("#mapel").select2({
                placeholder: "Pilih Mapel", // Placeholder untuk dropdown
                allowClear: true, // Tambahkan opsi clear
            });
            $("#edit-mapel").select2({
                placeholder: "Pilih Mapel", // Placeholder untuk dropdown
                allowClear: true, // Tambahkan opsi clear
            });
            $("#jam").select2({
                placeholder: "Pilih jam", // Placeholder untuk dropdown
                allowClear: true, // Tambahkan opsi clear
            });
            $("#edit-jam").select2({
                placeholder: "Pilih jam", // Placeholder untuk dropdown
                allowClear: true, // Tambahkan opsi clear
            });
        });
    </script>

</body>

</html>

<?php
ob_end_flush();  // Send the output to the browser
?>