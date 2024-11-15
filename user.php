<?php

include 'function.php';

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard | AgendaKelas</title>

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
                <li class="breadcrumb-item active">Dashboard v2</li>
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
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">CPU Traffic</span>
                  <span class="info-box-number">
                    10
                    <small>%</small>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Likes</span>
                  <span class="info-box-number">41,410</span>
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
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Sales</span>
                  <span class="info-box-number">760</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">New Members</span>
                  <span class="info-box-number">2,000</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

          <!-- tabel kehadiran -->
          <button type="button"
            class="btn btn-outline-success"
            data-toggle="modal"
            data-target="#modal-tambah"> tambah user</button>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Kehadiran Siswa</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>ID User</th>
                    <th>Username</th>
                    <th>Level</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = getAlluser();
                  $no = 0;
                  while ($row = mysqli_fetch_array($sql)) {
                    $no++
                  ?>
                    <tr>
                      <td><?= $no; ?></td>
                      <td><?= $row['userID'] ?></td>
                      <td><?= $row['username']; ?></td>
                      <td><?= $row['level']; ?></td>
                      <td>
                        <button
                          class="btn btn-outline-warning"
                          data-toggle="modal"
                          data-target="#modal-default"
                          data-username="<?= $row['username'] ?>"
                          data-level="<?= $row['level'] ?>"
                          data-userid="<?= $row['userID'] ?>">
                          Edit
                        </button>

                        <!-- modal -->

                        <a href="user.php?hapus=<?= $row['userID'] ?>" class="btn btn-outline-danger">
                          Hapus
                        </a>
                      </td>
                    </tr>
                  <?php
                  }

                  if (isset($_POST['edit'])) {
                    if (edituser($_POST)) {
                      echo "
                      <script>
                      alert('Data berhasil di edit!');
                      document.location.href = 'user.php';
                      </script>";
                    }
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

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    <div class="modal fade" id="modal-tambah">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah User</h4>
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
                      <option value="Guru" id="guru">Guru</option>
                    </select>
                  </div>

                </div>
                <!-- /.card-body -->



                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="tambah">Save</button>
                </div>
            </div>
            </form>
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

  <!-- AdminLTE for demo purposes -->
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard2.js"></script>
  <script>
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

    $(document).on('click', '.btn-outline-warning', function() {
      var username = $(this).data('username');
      var iduser = $(this).data('userid');
      var level = $(this).data('level');

      if (level == 'Kepala Sekolah') {
        $('#kepalasekolah').prop('selected', true);
      } else if (level == 'Admin') {
        $('#admin').prop('selected', true);
      } else if (level == 'Guru') {
        $('#guru').prop('selected', true);
      } else {
        $('#sek').prop('selected', true);
      }
      // Set form values ke modal
      $('#username').val(username);
      $('#iduser').val(iduser);
      $('#modal-default').modal('show');

      // Set ID hidden di form agar nanti dikirim saat submit

    });
  </script>
</body>

</html>