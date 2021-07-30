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

$products = query("SELECT tb_products.*, tb_bio_mhs.* FROM tb_products INNER JOIN tb_bio_mhs ON tb_products.id_mhs = tb_bio_mhs.id_mhs;");

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin - Products</title>
  <link rel="Icon" href="<?= base_url('data/images/iconE.png'); ?>">
  <!-- Custom fonts for this template-->
  <link href="<?= base_url('html/admin/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <!-- Custom styles for this template-->
  <link href="<?= base_url('html/admin/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

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
      <li class="nav-item">
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

      <li class="nav-item active">
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
          <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h1 class="h3 mb-0 text-gray-800">Products</h1>
          </div>

          <!-- button tambah Data -->
          <a onClick="return confirm('Apakah anda ingin mencetak data ini ?');"  href="cetak_product.php" target="_blank" class="btn btn-success mb-4"><i class="fas fa-plus-square mr-2"></i>Cetak Data </a>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables Products</h6>
            </div>

            <div class="container mt-5 mb-5">
              <div class="table-responsive">
                <table id="example" class="display nowrap table table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Tim</th>
                      <th>Ketua</th>
                      <th>Anggota</th>
                      <th>Judul Products</th>
                      <th>Foto Products</th>
                      <th>Deskripsi Produk</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1 ?>
                    <?php foreach ($products as $product) : ?>
                      <tr>
                        <th><?= $no; ?></th>
                        <td><?= $product["nama_tim"]; ?></td>
                        <td><?= $product["nama_depan"] . " " . $product["nama_belakang"]; ?></td>

                        <?php
                        $prod = $product["id_product"];
                        $product_members = query("SELECT tb_product_members.*, tb_bio_mhs.* FROM tb_product_members INNER JOIN tb_bio_mhs ON tb_product_members.id_mhs = tb_bio_mhs.id_mhs WHERE id_product = '$prod';");
                        ?>
                        <td>
                          <?php foreach ($product_members as $member) : ?>
                            <?= $member["nama_depan"] . " " . $member["nama_belakang"]; ?>
                            ,<br>
                          <?php endforeach; ?>
                        </td>

                        <td><?= $product["judul_prod"]; ?></td>

                        <?php
                        $prod = $product["id_product"];
                        $product_thumbnails = query("SELECT * FROM tb_product_thumbnails WHERE id_product = '$prod' ;");
                        ?>
                        <td class="w-100">
                          <?php foreach ($product_thumbnails as $tb) : ?>
                            <img src="<?= base_url('data/profile_product/') . $tb['thumb_prod']; ?>" width="100%">
                            <br><br>
                          <?php endforeach; ?>
                        </td>
                        <td style="white-space: wrap;"><?= $product["deskripsi_prod"]; ?></td>
                        <td><a href="admin_delProduct.php?id_product=<?= $product["id_product"]; ?>" onClick="return confirm('Apakah anda ingin menghapus data ini ?');" class="btn btn-danger" type="submit" name="delete">Delete</a></td>
                      </tr>
                      <?php $no++ ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>

              </div>
            </div>
          </div>
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

      <!-- ss -->

      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <script>
        $(document).ready(function() {
          $('#example').DataTable({
            "scrollX": true
          });
        });
      </script>
</body>

</html>