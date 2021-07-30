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

$myUser = $mhs["id_mhs"];

$total_product = total("SELECT count(id_product) AS 'total' FROM tb_products WHERE id_mhs = '$myUser' ");
?>

<?php
// KONFIGURASI PAGINATION
$user = $mhs["id_mhs"];

$jumlahDataPerHalaman = 6;
$jumlahData = count(query("SELECT * FROM tb_products WHERE id_mhs = '$user' "));
$jumlahHalaman =  ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

//QUERY :
$products = query("SELECT * FROM tb_products WHERE id_mhs = '$user' ORDER BY tgl_upload DESC LIMIT $awalData, $jumlahDataPerHalaman");
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product of <?= strtolower($mhs['nama_depan'] . " " . $mhs['nama_belakang']); ?></title>
  <link rel="Icon" href="<?= base_url('data/images/iconE.png'); ?>">
  <!-- Bootsrap CSS -->
  <link rel="stylesheet" href="<?= base_url('data/libraries/bootsrap/css/bootstrap.css'); ?>">
  <!-- font -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <!-- font Awesome -->
  <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <!-- font gfonts -->
  <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
  <!-- Main CSS -->
  <link rel="stylesheet" href="<?= base_url('data/styles/myproduct.css?') . time(); ?>">
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

  <main>

    <!-- start my total produk -->
    <section class="section-produk" id="produk">
      <div class="container">
        <div class="row">
          <div class="col text-center section-produk-heading">
            <h2>My Product</h2>
            <p>
              <span style="color: rgba(230, 184, 0, 1); font-weight: bold;"><?= $mhs['nama_depan'] . " " . $mhs['nama_belakang']; ?></span>
              <br>
              My Total Product : <?= $total_product; ?>
            </p>
          </div>
        </div>
      </div>
    </section>
    <!-- end my total produk-->

    <!-- start container -->
    <div class="container" id="content">
      <section class="row justify-content-center">

        <div class="col-lg-12 info-panel justify-content-center ">
          <div class="row mt-5 mb-4">

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
                      </div>

                      <?php 
                      $prod = $product["id_product"];

                      $total_score = total("SELECT sum(score) AS 'total' FROM tb_score WHERE id_product = '$prod' ");
                      $total_tester = total("SELECT count(id_tester) AS 'total' FROM tb_score WHERE id_product = '$prod' ");

                      if ($total_tester == NULL || !$total_tester) {
                        $score = '0';
                      }  else {
                        $score = $total_score / $total_tester;
                      }
                      ?>
                      <div class="col pl-0">
                        <h7 class="fas fa-heart" style="color: #b12f27;"></h7>
                        <h6 style="margin-bottom: -10px; margin-top: -21px; margin-left: 27px; ">Score : <?= round($score, 2); ?></h6>
                        <div class="btn-khusus .col-md-3 .ml-md-auto">
                          <a class="btn btn-primary btn-flat btn-xs" href="mhs_update.php?id_product=<?= $product['id_product']; ?>">
                            <i class="fas fa-edit"></i>
                          </a>

                          <a class="btn btn-danger btn-flat btn-xs" href="mhs_delete_product.php?id_product=<?= $product["id_product"]; ?> &id_mhs=<?= $product["id_mhs"]; ?> " onClick="return confirm('Apakah anda ingin menghapus product ini ?');">
                            <i class="fa fa-trash"></i>
                          </a>
                        </div>

                      </div>


                    </div>

                    <hr>
                    <p><?= strtolower($product["deskripsi_prod"]); ?></p>
                  </a>

                </div>
              </div>
            <?php endforeach; ?>
            <!-- end menampilkan product -->

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
                <a class="page-link" href="mhs_myproduct.php?halaman=<?= $halamanAktif - 1; ?>#content" aria-label="Previous">
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
                    <a class="page-link" href="mhs_myproduct.php?halaman=<?= $i; ?>#content">
                      <span><?= $i; ?></span>
                    </a>
                  </li>
                  <?php else : ?>
                    <li class="page-item">
                      <a class="page-link" href="mhs_myproduct.php?halaman=<?= $i; ?>#content">
                        <span><?= $i; ?></span>
                      </a>
                    </li>
                  <?php endif; ?>
                <?php endfor; ?>
                <!-- end pagination menampilkan halaman -->

                <!-- start tanda panah tambah -->
                <li class="page-item" style="cursor: pointer;">
                  <?php if ($halamanAktif < $jumlahHalaman) : ?>
                    <a class="page-link" href="mhs_myproduct.php?halaman=<?= $halamanAktif + 1; ?>#content" aria-label="Next">
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
                  <p><b>Instagram :</b>@E-Mon</p>
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