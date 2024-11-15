 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="index.php" class="brand-link">
         <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
         <span class="brand-text font-weight-light">AgendaKelas</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">




         <!-- Sidebar Menu -->

         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                 <li class="nav-item menu-open"></li>

                 <?php if ($_SESSION['level'] == 'Admin'): ?>

                     <li class="nav-item">
                         <a href="index.php" class="nav-link">
                             <i class="nav-icon fas fa-tachometer-alt"></i>
                             <p>Dashboard</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="siswa-terlambat.php" class="nav-link">
                             <i class="nav-icon fas fa-exclamation-circle"></i>
                             <p>Siswa Terlambat</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="list-guru.php" class="nav-link">
                             <i class="nav-icon fas fa-chalkboard-teacher"></i>
                             <p>Guru</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="mapel.php" class="nav-link">
                             <i class="nav-icon fas fa-th"></i>
                             <p>Mapel</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="agenda.php" class="nav-link">
                             <i class="nav-icon fas fa-book-open"></i>
                             <p>Agenda Kelas</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="siswa.php" class="nav-link">
                             <i class="nav-icon fas fa-graduation-cap"></i>
                             <p>Siswa</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="user.php" class="nav-link">
                             <i class="nav-icon fas fa-user"></i>
                             <p>User</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="logout.php" class="nav-link">
                             <i class="nav-icon fas fa-sign-out-alt"></i>
                             <p>Logout</p>
                         </a>
                     </li>

                 <?php elseif ($_SESSION['level'] == 'Sekretaris'): ?>
                     <li class="nav-item">
                         <a href="agenda.php" class="nav-link">
                             <i class="nav-icon fas fa-book-open"></i>
                             <p>Agenda Kelas</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="siswa.php" class="nav-link">
                             <i class="nav-icon fas fa-graduation-cap"></i>
                             <p>Siswa</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="logout.php" class="nav-link">
                             <i class="nav-icon fas fa-sign-out-alt"></i>
                             <p>Logout</p>
                         </a>
                     </li>

                 <?php elseif ($_SESSION['level'] == 'Kepala Sekolah' || $_SESSION['level'] == 'Wakil Kepala Sekolah'): ?>
                     <li class="nav-item">
                         <a href="siswa-terlambat.php" class="nav-link">
                             <i class="nav-icon fas fa-exclamation-circle"></i>
                             <p>Siswa Terlambat</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="logout.php" class="nav-link">
                             <i class="nav-icon fas fa-sign-out-alt"></i>
                             <p>Logout</p>
                         </a>
                     </li>
                 <?php endif; ?>

             </ul>
         </nav>

         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>