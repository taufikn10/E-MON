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

$testers = query("SELECT * FROM tb_bio_tester ORDER BY nip ASC");
?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin - Tester</title>
  <link rel="Icon" href="<?= base_url('data/images/iconE.png'); ?>">

  <!-- Custom fonts for this template-->
  <link href="<?= base_url('html/admin/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  </style>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  </style>
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

      <li class="nav-item active">
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
          <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h1 class="h3 mb-0 text-gray-800">Tester</h1>
          </div>

          <!-- button tambah Data -->
          <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#tambah"><i class="fas fa-user-plus mr-2"></i>Tambah Akun</button>
          <a href="cetak_tester.php" target="_blank" class="btn btn-success mb-4" onClick="return confirm('Apakah anda ingin mencetak data ini ?');"><i class="fas fa-plus-square mr-2"></i> Cetak Data </a>

          <!-- PHP TAMBAH DATA TESTER-->
          <?php
          //Import PHPMailer classes into the global namespace
          //These must be at the top of your script, not inside a function
          use PHPMailer\PHPMailer\PHPMailer;
          use PHPMailer\PHPMailer\Exception;

          //Load Composer's autoloader
          require '../data/lib-composer/vendor/PHPMailer/src/Exception.php';
          require '../data/lib-composer/vendor/PHPMailer/src/PHPMailer.php';
          require '../data/lib-composer/vendor/PHPMailer/src/SMTP.php';
          
          // APABILA TOMBOL ADD DITEKAN
          if (isset($_POST["add"])) {

            if (tambah($_POST) > 0) {
              echo "<script>
              alert ('User baru berhasil ditambahkan');
              document.location.href = 'admin_tester.php';
              </script>";

              if (isset($_POST["email_tester"]) && isset($_POST["nama_lengkap"])) {
                  $emailTo = strtolower(stripcslashes($_POST["email_tester"]));
                  $user = strtolower(stripcslashes($_POST["nama_lengkap"]));
                 
                  //Instantiation and passing `true` enables exceptions
                  $mail = new PHPMailer(true);

                  try {
                    //Server settings
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'emon.productkarya@gmail.com';                     //SMTP username
                    $mail->Password   = 'emon123karya';                               //SMTP password
                    $mail->SMTPSecure = 'ssl';                                  //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                    $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                    //Recipients
                    $mail->setFrom('emon.productkarya@gmail.com', 'EMON');
                    $mail->addAddress($emailTo);     //Add a recipient
                    $mail->addReplyTo('no-reply@gmail.com', 'No Reply');

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Website Monitoring E-Mon';
                    $mail->Body    = "<h2>Hello, ".$user."</h2><br>
                    <h3>Your email has been registered as a tester on this monitoring website. You can monitor the products that are shipped from now on.</h3>";
                    $mail->AltBody = 'Thankyou.';

                    $mail->send();
                  } 
                  catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                  }  
                }

            } else {
              echo mysqli_error($conn);
            }
          }
          ?>

          <div id="tambah" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 style="color: black;" class="modal-title"><i class="fas fa-user-plus"></i> Registrasi Tester</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="" method="POST" enctype="multipart/form-data">
                  <div class="modal-body">
                    <div class="form-group">
                      <label style="color: black;" for="control-label" for="nama_lengkap">Nama Lengkap</label>
                      <input type="name" name="nama_lengkap" class="form-control" id="nama_lengkap" required>
                    </div>
                    <div class="form-group">
                      <label style="color: black;" for="control-label" for="email_tester">Email</label>
                      <input type="email" name="email_tester" class="form-control" id="email_tester" required>
                    </div>
                    <div class="form-group">
                      <label style="color: black;" for="control-label" for="Password">Password</label>
                      <input type="password" name="password" class="form-control" id="Password" required>
                    </div>
                    <div class="form-group">
                      <label style="color: black;" for="control-label" for="Password2">Verification Password</label>
                      <input type="password" name="password2" class="form-control" id="Password2" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="cancel" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="add" class="btn btn-success">Registrasi</button>
                  </div>
                </form>
              </div>
            </div>
          </div>


          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">DataTables Tester</h6>
            </div>
            <div class="table-responsive">
              <div class="container mt-5 mb-5">
                <table id="example" class="display nowrap" style="width:100% table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Tester</th>
                      <th>Email</th>
                      <th>Nip</th>
                      <th>Tanggal Lahir</th>
                      <th>Jenis Kelamin</th>
                      <th>Jabatan</th>
                      <th>Alamat</th>
                      <th>Kab/Kota</th>
                      <th>Provinsi</th>
                      <th>Telepon</th>
                      <th>Foto</th>
                      <th> Delete</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php $no = 1 ?>
                    <?php foreach ($testers as $tester) : ?>
                      <tr>
                        <th><?= $no; ?></th>
                        <td><?= $tester["nama_lengkap"]; ?></td>
                        <td><?= $tester["email_tester"]; ?></td>
                        <td><?= $tester["nip"]; ?></td>
                        <td><?= $tester["ttl"]; ?></td>
                        <td><?= $tester["jenis_kelamin"]; ?></td>
                        <td><?= $tester["jabatan"]; ?></td>
                        <td><?= $tester["alamat"]; ?></td>
                        <td><?= $tester["kab_kota"]; ?></td>
                        <td><?= $tester["provinsi"]; ?></td>
                        <td><?= $tester["telepon"]; ?></td>
                        <td class="w-25">
                          <img src="<?= base_url('data/profile_tester/') . $tester["foto"]; ?>" width="100%" alt="">
                        </td>
                        <td><a href="admin_delTester.php?id_tester=<?= $tester["id_tester"]; ?>" onClick="return confirm('Apakah anda ingin menghapus data ini ?');" class="btn btn-danger" type="submit" name="delete">Delete</a></td>
                      </tr>
                      <?php $no++ ?>
                    <?php endforeach;  ?>
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



      <!-- scripts -->

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