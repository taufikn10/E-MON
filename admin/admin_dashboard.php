<?php

// MENGHUBUNGKAN KONEKSI DATABASE
require "koneksi_admin.php";

// MENGHUBUNGKAN KONEKSI COMPOSER
require "../data/lib-composer/vendor/autoload.php";


// JIKA SUDAH LOGIN MASUKKAN KEDALAM SHOWDATA
if (!isset($_SESSION["masuk"])) {
  header('location: admin_login.php');
  exit;
}


global $conn;

$total_college = total("SELECT count(id_mhs) AS 'total' FROM tb_bio_mhs");

$total_testers = total("SELECT count(id_tester) AS 'total' FROM tb_bio_tester");

$total_product = total("SELECT count(id_product) AS 'total' FROM tb_products");
?>

<?php
$koneksi    = mysqli_connect("localhost", "root", "", "db_product");
$total  = mysqli_query($koneksi, "SELECT COUNT(status) AS total FROM tb_survey GROUP BY status ORDER BY status DESC");
$status       = mysqli_query($koneksi, "SELECT status FROM tb_survey GROUP BY status ORDER BY status DESC");
?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin - Dashboard</title>

  <link rel="Icon" href="<?= base_url('data/images/iconE.png'); ?>">

  <!-- Custom fonts for this template-->
  <link href="<?= base_url('html/admin/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->

  <link href="<?= base_url('html/admin/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
  <script src="<?= base_url('html/admin/js/Chart.js'); ?>"></script>
  <style type="text/css">
    @media only screen and (min-width: 992px) {
      .pie {
        margin-left: 60px !important;
      }
    }
  </style>


</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" style="cursor: default;">
        <i class="fab fa-themeisle"></i>
        <div class="sidebar-brand-text mx-3">E-MON ADMIN</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="admin_dashboard.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="admin_college_students.php">
          <i class="fas fa-fw fa-user-graduate"></i>
          <span>College Students</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="admin_tester.php">
          <i class="fas fa-fw fa-chalkboard-teacher"></i>
          <span>Tester</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="admin_product.php">
          <i class="fas fa-fw fa-images"></i>
          <span>Products</span></a>
      </li>

      <hr class="sidebar-divider">


      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION["username"]; ?></span>
                <img class="img-profile rounded-circle" src="<?= base_url('html/admin/img/undraw_profile.svg'); ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="admin_logout.php" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- College Students Card Example -->
            <div class="col-xl-3 col-md-6 mb-4 ml-auto">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        College Students</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_college; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tester Card Example -->
            <div class="col-xl-3 col-md-6 mb-4 ml-auto">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Tester</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_testers; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-check  fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Products Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4 ml-auto mr-auto">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Products</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_product; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-images fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Pie Chart -->
          <div class="col-xl-4 col-lg-5 ml-auto pie">
            <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">User Satisfaction Survey</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body" style="background-color: rgba(15, 15, 15, 0.2);">
                  <canvas id="piechart" width="100%" height="100%"></canvas>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->

        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright &copy; E-MON 2021</span>
            </div>
          </div>
        </footer>
        <!-- End of Footer -->

      </div>
      <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="admin_logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('html/admin/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('html/admin/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('html/admin/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('html/admin/js/sb-admin-2.min.js'); ?>"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url('html/admin/vendor/chart.js/Chart.min.js'); ?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('html/admin/js/demo/chart-area-demo.js'); ?>"></script>
    <script src="<?= base_url('html/admin/js/demo/chart-pie-demo.js'); ?>"></script>

    <!-- Pie Chart -->

    <script type="text/javascript">
      var ctx = document.getElementById("piechart").getContext("2d");

      var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: [<?php while ($st = mysqli_fetch_array($status)) {
                      echo '"' . $st['status'] . '",';
                    } ?>],
          datasets: [{
            label: "Kepuasan Pelanggan",
            data: [<?php while ($tot = mysqli_fetch_array($total)) {
                      echo '"' . $tot['total'] . '",';
                    } ?>],
            backgroundColor: [
              '#29B0D0',
              '#2A516E',
              '#3333ff'
            ]
          }]
        },
        options: {
          responsive: true
        }
      });
    </script>

</body>

</html>