<?php
require 'function.php';

$message = "";
$alertClass = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $cek = mysqli_query($conn, "SELECT * FROM user where username = '$username'");
    $row = mysqli_fetch_array($cek);

    if ($row) {
        $passwordhash = $row['password'];

        if (password_verify($password, $passwordhash)) {
            $_SESSION['iduser'] = $row['userID'];
            $_SESSION['level']  = $row['level'];
            $_SESSION['login']  = true;

            header("Location: index.php");
            exit();
        } else {
            $message = "Username atau password salah";
            $alertClass = "alert-danger";
        }
    } else {
        $message = "Username atau asdas salah";
        $alertClass = "alert-danger";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | AgendaKelas</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href=" plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href=" plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href=" dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1><b>Login</b> </h1>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Selamat Datang di AgendaKelas</p>

                <?php if (isset($message) && !empty($message)) : ?>

                    <div class="alert <?= $alertClass ?> alert-dismissible fade show" role="alert">
                        <?= $message ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                <?php endif; ?>

                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <!-- /.col -->
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                    </div>
                    <!-- /.col -->
                </form>
                <!-- /.social-auth-links -->


            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src=" plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src=" plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src=" dist/js/adminlte.min.js"></script>
</body>

</html>