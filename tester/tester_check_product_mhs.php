<?php

// MENGHUBUNGKAN KONEKSI DATABASE
require "koneksi_tester.php";

// MENGHUBUNGKAN KONEKSI COMPOSER
require "../data/lib-composer/vendor/autoload.php";


// CEK COOKIE
checkCookie();

// JIKA SUDAH LOGIN MASUKKAN KEDALAM SHOWDATA
if (!isset($_SESSION["sign-in"])) {
  header('location: tester_login.php');
  exit;
} else {
  if (isset($_SESSION['id_tester'])) {
    $my_id = $_SESSION['id_tester'];
  } else {
    $my_id = $_COOKIE['id_tester'];
  }

  // QUERY TESTER
  $tester = query("SELECT * FROM tb_bio_tester WHERE id_tester = '$my_id' ")[0];
}

?>

<?php
// AMBIL DATA DARI URL
$myUser = $_GET["id_mhs"];

// PERIZINAN AKSES
if (!isset($_GET['id_mhs']) || !query("SELECT * FROM tb_bio_mhs WHERE id_mhs = '$myUser' ")) {

  header("location: index.php");
  exit;
}
?>

<?php
// QUERY COUNT DATA  
global $conn;

// AMBIL DATA DARI URL
$myUser = $_GET["id_mhs"];
$id_product = $_GET["id_product"];

$member = query("SELECT tb_products.*, tb_bio_mhs.* FROM tb_products INNER JOIN tb_bio_mhs ON tb_products.id_mhs = tb_bio_mhs.id_mhs WHERE id_product = '$id_product' ")[0];

$total_product = total("SELECT count(id_product) AS 'total' FROM tb_products WHERE id_mhs = '$myUser' ");
?>

<?php
// KONFIGURASI PAGINATION
$user = $_GET["id_mhs"];

//QUERY :
$products = query("SELECT * FROM tb_products WHERE id_mhs = '$user' ORDER BY tgl_upload DESC");
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product of <?= strtolower($member['nama_depan'] . " " . $member['nama_belakang']); ?></title>
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

      <img src="<?= base_url('data/images/Yoamn.png'); ?>" alt="logo emon">

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ml-auto">
          <a class="nav-item nav-link active" href="index.php">Home<span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="tester_profile.php?id_tester=<?= $tester['id_tester']; ?>">Profil</a>
          <a class="nav-item nav-link" href="tester_logout.php">Logout</a>
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
          <div class="col text-center section-produk-heading judul">
            <img src="<?= base_url('data/profile_mhs/').$member['foto']; ?>" width="100px";>
            <h2><?= strtolower($member['nama_depan'] . " " . $member['nama_belakang']); ?>'s product</h2>
            <p>
              Total Products : <?= $total_product; ?>
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
                      <a class="hover" href="tester_detail_product.php?id_product=<?= $product['id_product']; ?>">View Project</a>
                    </div>
                  </div>
                </div>

                <div class="card-content">
                  <a href="tester_detail_product.php?id_product=<?= $product['id_product']; ?>">
                    <h2><?= $product['judul_prod'] ?></h2>
                    <hr>
                    <!-- profil -->

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
                    <div class="row align-items-center no-glutters">
                      <div class="col-auto">
                      </div>
                      <div class="col pl-0">
                        <h7 class="fas fa-heart" style="color: #b12f27;"></h7>
                        <h6 style="margin-bottom: -10px; margin-top: -20px; margin-left: 27px; ">Score : <?= round($score, 2); ?></h6>
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