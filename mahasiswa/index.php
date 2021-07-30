<?php

// MENGHUBUNGKAN KONEKSI DATABASE
require "koneksi_mhs.php";

// MENGHUBUNGKAN KONEKSI COMPOSER
require "../data/lib-composer/vendor/autoload.php";


// CEK COOKIE
checkCookie();

// JIKA SUDAH LOGIN MASUKKAN KEDALAM SHOWDATA
if (!isset($_SESSION["login"])) {
  header('location: mhs_login.php');
  exit;
} else {
  if (isset($_SESSION['id_mhs'])) {
    // var_dump($_SESSION['id_mhs']); die;
    $my_id = $_SESSION['id_mhs'];
  } else {
    $my_id = $_COOKIE['id_mhs'];
  }

  // QUERY MAHASISWA
  $mhs = query("SELECT * FROM tb_bio_mhs WHERE id_mhs = '$my_id' ")[0];
}

?>

<?php
// QUERY COUNT DATA  
global $conn;

$total_college = total("SELECT count(id_mhs) AS 'total' FROM tb_bio_mhs");
$total_product = total("SELECT count(id_product) AS 'total' FROM tb_products");
$total_testers = total("SELECT count(id_tester) AS 'total' FROM tb_bio_tester");
?>

<?php
// KONFIGURASI PAGINATION
$jumlahDataPerHalaman = 6;
$jumlahData = count(query("SELECT * FROM tb_products"));
$jumlahHalaman =  ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
?>

<?php
// FUNCTION SEARCH
if (isset($_POST["button_search"])) {
  $products = search($_POST["keyword"]);

  // CHECK DATA
  if (mysqli_affected_rows($conn) == true) {
    $product = "SELECT tb_products.*, tb_bio_mhs.* FROM tb_products INNER JOIN tb_bio_mhs ON tb_products.id_mhs = tb_bio_mhs.id_mhs ORDER BY tgl_upload DESC LIMIT $awalData, $jumlahDataPerHalaman";
  } else {
    $error = true;
  }
} else {
  //QUERY :
  $products = query("SELECT tb_products.*, tb_bio_mhs.* FROM tb_products INNER JOIN tb_bio_mhs ON tb_products.id_mhs = tb_bio_mhs.id_mhs ORDER BY tgl_upload DESC LIMIT $awalData, $jumlahDataPerHalaman");
}
?>

<?php
// CEK APAKAH TOMBOL SUBMIT SUDAH DITEKAN BELUM
if (isset($_POST["puas"])) {

  rate_puas($mhs);
  
  echo "<script>
  alert( 'Terimakasih telah mengisi survey !' );
    document.location.href = 'index.php';
  </script>
  ";
}
?>

<?php
// CEK APAKAH TOMBOL SUBMIT SUDAH DITEKAN BELUM
if (isset($_POST["cukup"])) {
  
  rate_cukup($mhs);
  
  echo "<script>
  alert( 'Terimakasih telah mengisi survey !' );
    document.location.href = 'index.php';
  </script>
  ";
}
?>

<?php
// CEK APAKAH TOMBOL SUBMIT SUDAH DITEKAN BELUM
if (isset($_POST["kurang"])) {

  rate_kurang($mhs);
  
  echo "<script>
  alert( 'Terimakasih telah mengisi survey !' );
    document.location.href = 'index.php';
  </script>
  ";}
?>

<?php 
  $total_puas = total("SELECT count(status) AS 'total' FROM tb_survey WHERE status='SATISFYING' ");
  $total_cukup = total("SELECT count(status) AS 'total' FROM tb_survey WHERE status='ENOUGH' ");
  $total_kurang = total("SELECT count(status) AS 'total' FROM tb_survey WHERE status='LESS' ");
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-mon's Homepage</title>
  <link rel="Icon" href="<?= base_url('data/images/iconE.png'); ?>">
  <!-- Bootsrap CSS -->
  <link rel="stylesheet" href="<?= base_url('data/libraries/bootsrap/css/bootstrap.css'); ?>">
  <!-- font -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <!-- font Awesome -->
  <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <!-- font gfonts -->
  <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,900&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">
  <!-- Main CSS -->
  <link rel="stylesheet" href="<?= base_url('data/styles/main.css?') . time(); ?>">
</head>

<body>

  <!-- start navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">

      <img src="<?= base_url('data/images/Yoamn.png" alt="logo emon'); ?>">

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ml-auto">
          <a class="nav-item nav-link active" href="index.php">Home<span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="mhs_myproduct.php">My-Product</a>
          <a class="nav-item nav-link" href="mhs_profile.php?id_mhs=<?= $mhs['id_mhs']; ?>">profile</a>
          <a class="nav-item nav-link" href="mhs_upload.php">Upload</a>
          <a class="nav-item nav-link" href="mhs_logout.php">Logout</a>
        </div>
      </div>

    </div>
  </nav>
  <!-- end navbar -->

  <!-- start jumbotron -->
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h2 class="display-4" style="color: rgba(230, 184, 0, 1); font-weight: bold;"><?= $mhs['nama_depan'] . " " . $mhs['nama_belakang']; ?></h2>
      <h1 class="display-4">Welcome to Monitoring the products and works of D4 Informatics Management</h1>
      <a href="index.php#content" class="btn btn-judul px-4 mt-5">Website Monitoring</a>
    </div>
  </div>
  <!-- end jumbotron -->

  <!-- Button trigger modal -->
  <div class="text-center">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
      Rate US
    </button>
  </div>

  <!-- Start Modal Rate Us -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md  modal-dialog-centered" role="document">
      <div class="modal-content rounded-0">
        <div class="modal-body py-0">


          <div class="d-block main-content">
            <img src="../data/images/up (2).png" alt="Image" class="img-fluid" style="background-color: #b2fcff;">
            <div class="content-text p-4">

              <h3 class="mb-4 text-center">User Satisfaction Survey</h3>
              
              <div class="alert alert-warning text-center" role="alert">
                To give an assessment please click Emoji
              </div>

              <div class="row">

                <!-- Start Satisfying -->
                <div class="col-md-4 ">
                  <div class="bg-primary box text-white">
                    <div class="row text-center">
                      
                      <div class="col-md-5 survey mt-2">
                        <h5 style="cursor: default;">Satisfying</h5>
                        <h2 style="cursor: default;"><?= $total_puas; ?></h2>
                      </div>
                      
                      <div class="col-md-2 imaggge">
                        <form action="" method="POST">
                          <button type="submit" name="puas" class="btn btn-yoi">
                            <img src="../data/images/puas.png">
                          </button>
                        </form>
                      </div>

                    </div>
                  </div>
                </div>
                <!-- End Satisfying -->

                <!-- Start Enough-->
                <div class="col-md-4">
                  <div class="bg-success box text-white">
                    <div class="row text-center">
                      
                      <div class="col-md-5 survey mt-2">
                        <h5 style="cursor: default;">Enough</h5>
                        <h2 style="cursor: default;"><?= $total_cukup; ?></h2>
                      </div>
                      
                      <div class="col-md-2 imaggge">
                        <form action="" method="POST">
                          <button type="submit" name="cukup" class="btn btn-yoi">
                            <img src="../data/images/cukup.png">
                          </button>
                        </form>
                      </div>

                    </div>
                  </div>
                </div>
                <!-- End Enough-->

                <!-- Start Less -->
                <div class="col-md-4">
                  <div class="bg-danger box text-white">
                    <div class="row text-center">
                      
                      <div class="col-md-5 survey mt-2">
                        <h5 style="cursor: default;">Less</h5>
                        <h2 style="cursor: default;"><?= $total_kurang; ?></h2>
                      </div>

                      <div class="col-md-2 imaggge">
                        <form action="" method="POST">
                          <button type="submit" name="kurang" class="btn btn-yoi">
                            <img src="../data/images/kurang.png">
                          </button>
                        </form>
                      </div>

                    </div>
                  </div>
                </div>
                <!-- End Less -->
              </div>

              <div class="d-flex">
                <div class="ml-auto mt-2">
                  <a href="#" class="btn btn-link" data-dismiss="modal">No thanks</a>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!-- End Modal Rate Us-->

  <main>

    <!-- start statistic -->
    <div class="container">
      <section class="section-stats row justify-content-center" id="stats">
        <div class="col-4 col-md-3 stats-detail">
          <h2><?= $total_college; ?></h2>
          <p>College Students</p>
        </div>

        <div class="col-4 col-md-2 stats-detail">
          <h2><?= $total_product; ?></h2>
          <p>Products</p>
        </div>

        <div class="col-4 col-md-2 stats-detail">
          <h2><?= $total_testers; ?></h2>
          <p>Tester</p>
        </div>
      </section>
    </div>
    <!-- end statistic-->

    <!-- start gambar e-monitoring -->
    <section class="section-produk" id="produk">
      <div class="container">
        <div class="row">
          <div class="col text-center section-produk-heading">
            <h2>E - Monitoring</h2>
            <p>Upload your product and <br> you will get a rating</p>
          </div>
        </div>
      </div>
    </section>
    <!-- end gambar e-monitoring-->

    <!-- start container -->
    <div class="container" id="content">
      <section class="row justify-content-center">

        <!-- START OF SEARCH -->
        <form class="form-inline" action="index.php#content" method="POST">
          <input type="search" name="keyword" placeholder="Search" aria-label="Search" class="form-control mr-sm-2">
          <button type="submit" name="button_search" class="btn btn-search">
            <i class="fas fa-search"></i>
          </button>
        </form>
        <!-- THE END OF SEARCH -->

        <div class="col-lg-12 info-panel justify-content-center ">
          <div class="row mt-5 mb-4">
            <?php if (isset($error)) : ?>
              <p style="color:black; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" class="card-text">product yang anda cari tidak terdaftar, silahkan coba lagi.</p>
              <?php else : ?>
                <!-- start menampilkan product -->
                <?php foreach ($products as $product) : ?>
                  <?php
                  $prod = $product["id_product"];
                  $product_thumbnails = query("SELECT * FROM tb_product_thumbnails WHERE id_product = '$prod' ORDER BY id_product_thumbnails ASC LIMIT 1 ;");
                  ?>
                  <div class="card hover mt-2">
                    <div class="card-img">
                      <?php foreach ($product_thumbnails as $thumb) : ?>
                        <img src="<?= base_url('data/profile_product/') . $thumb['thumb_prod']; ?>" alt="Icon Berita" class="card-img">
                      <?php endforeach; ?>
                      <div class="overlay">
                        <div class="overlay-content">
                          <a class="hover" href="mhs_detail_product.php?id_product=<?= $product['id_product']; ?>">View Project</a>
                        </div>
                      </div>
                    </div>

                    <div class="card-content">
                      <a href="mhs_detail_product.php?id_product=<?= $product['id_product']; ?>">
                        <h2><?= $product['judul_prod'] ?></h2>
                        <hr>
                        <!-- profil -->
                        <div class="row align-items-center no-glutters">
                          <div class="col-auto">
                            <div class="mr-2 embed-responsive embed-responsive-1by1 d-inline-block" style="width: 50px;">
                              <div class="embed-responsive-item">
                                <img src="<?= base_url('data/profile_mhs/') . $product['foto']; ?>" class="mb-4 rounded-circle" alt="">
                              </div>
                            </div>
                          </div>
                          <?php
                          $prod = $product["id_product"];

                          $total_score = total("SELECT sum(score) AS 'total' FROM tb_score WHERE id_product = '$prod' ");
                          $total_tester = total("SELECT count(id_tester) AS 'total' FROM tb_score WHERE id_product = '$prod' ");

                          if ($total_tester == NULL || !$total_tester) {
                            $score = '0';
                          } else {
                            $score = $total_score / $total_tester;
                          }
                          ?>
                          <div class="col pl-0">
                            <p style="color: black; font-weight: bold;" class="mb-0 line-height-1"><?= strtoupper($product["nama_depan"] . " " . $product["nama_belakang"]); ?></p>
                            <h7 class="fas fa-heart" style="color: #b12f27; margin-top: -35px;"></h7>
                            <h6 style="margin-top: -23px;margin-left: 27px; ">Skor : <?= round($score, 2); ?></h6>
                          </div>

                        </div>
                        <div class="lope col pl-0">

                        </div>
                        <hr>
                        <p><?= strtolower($product["deskripsi_prod"]); ?></p>
                      </a>

                    </div>
                  </div>
                <?php endforeach; ?>
                <!-- end menampilkan product -->
              <?php endif; ?>
            </div>
          </div>
        </section>

        <!-- start pagination -->
        <div class="justify-content-center">
          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">

              <!-- satrt tanda panah menurun -->
              <li class="page-item" style="cursor: pointer;">
                <?php if ($halamanAktif > 1) : ?>
                  <a class="page-link" href="index.php?halaman=<?= $halamanAktif - 1; ?>#content" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <?php else : ?>
                    <a class="page-link" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                      <span class="sr-only">Previous</span>
                    </a>
                  <?php endif; ?>
                </li>
                <!-- end tanda panah menurun-->

                <!-- start pagination menampilkan halaman -->
                <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                  <?php if ($i == $halamanAktif) : ?>
                    <li class="page-item active">
                      <a class="page-link" href="index.php?halaman=<?= $i; ?>#content">
                        <span><?= $i; ?></span>
                      </a>
                    </li>
                    <?php else : ?>
                      <li class="page-item">
                        <a class="page-link" href="index.php?halaman=<?= $i; ?>#content">
                          <span><?= $i; ?></span>
                        </a>
                      </li>
                    <?php endif; ?>
                  <?php endfor; ?>
                  <!-- end pagination menampilkan halaman -->

                  <!-- start tanda panah tambah -->
                  <li class="page-item" style="cursor: pointer;">
                    <?php if ($halamanAktif < $jumlahHalaman) : ?>
                      <a class="page-link" href="index.php?halaman=<?= $halamanAktif + 1; ?>#content" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                      </a>
                      <?php else : ?>
                        <a class="page-link" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                          <span class="sr-only">Next</span>
                        </a>
                      <?php endif; ?>
                    </li>

                  </ul>
                </nav>
              </div>
              <!-- end pagination -->

            </div>
            <!-- end container -->

            <!-- start gambar tester-reviews -->
            <section class="section-tester-heading" id="testerheading">
              <div class="container">
                <div class="row">
                  <div class="col text-center">
                    <img src="<?= base_url('data/images/Group 7.png'); ?>" alt="rating">
                  </div>
                </div>
              </div>
            </section>
            <!-- end gambar tester-reviews -->

            <!-- start tester comment -->
            <div class="section section-tester-content col-lg" id="testercontent">
              <div class="container">
                <div class="section-popular-content row justify-content-center">

                  <?php
                  $comments = query("SELECT tb_comments.*, tb_bio_tester.* FROM tb_comments INNER JOIN tb_bio_tester ON tb_comments.id_tester = tb_bio_tester.id_tester ORDER BY tgl_comment DESC LIMIT 3");
                  ?>
                  <?php foreach ($comments as $comment) : ?>
                    <div class="col-sm row container mb-4 justify-content-center">
                      <div class="card card-tester text-center">
                        <div class="tester-content">
                          <img src="<?= base_url('data/profile_tester/') . $comment['foto']; ?>" alt="fotot" class="mb-4 rounded-circle">
                          <h3 class="mb-4"><?= strtoupper($comment["nama_lengkap"]); ?></h3>
                          <p class="tester"><?= strtolower($comment["comment"]); ?></p>
                        </div>
                        <hr>
                        <p class="jabatan mt-2"><?= strtoupper($comment["jabatan"]); ?></p>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
            <!-- end tester comment -->

            <!-- start footer -->
            <div id="contact">
              <div class="wrapper">
                <div class="footer">

                  <div class="footer-section">
                    <h3>E-Mon</h3>
                    <p>E-Mon is a website that is a collection point for products from D4 Informatics Management</p>
                  </div>

                  <div class="footer-section">
                    <h3>Contact</h3>
                    <p>Universitas Negeri Surabaya Kampus Ketintang,Surabaya</p>
                    <p>Kode Pos: 60231</p>
                  </div>

                  <div class="footer-section">
                    <h3>Social</h3>
                    <p><b>Instagram : </b>@E-Mon</p>
                    <p><b>Email : </b>emon.productkarya@gmail.com</p>
                  </div>

                </div>
              </div>
            </div>
            <!-- end footer -->

            <!-- start copyright -->
            <div class="class-row-footer">
              <div class="class-col text-center">
                <p>2021 All Rights Reversed by E-Mon Team</p>
              </div>
            </div>
            <!-- end copyright -->

          </main>


          <!-- jquery first, then popper, then bootsrap  -->
          <script src="<?= base_url('data/libraries/jquery/jquery-3.5.1.min.js'); ?>"></script>
          <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
          <script src="<?= base_url('data/libraries/bootsrap/js/bootstrap.js'); ?>"></script>
          <script src="<?= base_url('data/libraries/retina/retina.min.js'); ?>"></script>

          <script>
            $(document).ready(function() {
              $('.card').delay(1800).queue(function(next) {
                $(this).removeClass('hover');
                $('a.hover').removeClass('hover');
                next();
              });
            });
          </script>

        </body>

        </html>