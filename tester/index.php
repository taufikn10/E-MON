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

// QUERY COUNT DATA  
global $conn;

$total_college = total("SELECT count(id_mhs) AS 'total' FROM tb_bio_mhs");
$total_product = total("SELECT count(id_product) AS 'total' FROM tb_products");
$total_testers = total("SELECT count(id_tester) AS 'total' FROM tb_bio_tester");
?>

<?php
// KONFIGURASI PAGINATION
$jumlahDataPerHalaman = 3;
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


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
  <!-- Main CSS -->
  <link rel="stylesheet" href="<?= base_url('data/styles/tester.css?') . time(); ?>">
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

  <!-- start jumbotron -->
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h2 class="display-4" style="color: rgba(230, 184, 0, 1); font-weight: bold;"><?= $tester['nama_lengkap']; ?></h2>
      <h1 class="display-4">Welcome to Monitoring the products and works of D4 Informatics Management</h1>
      <a href="index.php#content" class="btn btn-judul px-4 mt-5">Website Monitoring</a>
    </div>
  </div>
  <!-- end jumbutron -->

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
    <!-- end statistic -->

    <section class="section-produk" id="produk">

      <!-- start gambar e-monitoring -->
      <div class="container">
        <div class="row">
          <div class="col text-center section-produk-heading">
            <h2>E - Monitoring</h2>
            <p>Upload your product and <br> you will get a rating</p>
          </div>
        </div>
      </div>
      <!-- end gambar e-monitoring-->

      <div class="card">

        <!-- start container -->
        <div class="container card" id="content">

          <!-- start search -->
          <form class="form-inline" action="index.php#content" method="POST">
            <input type="search" name="keyword" class="form-control mr-sm-2 mt-3 ml-auto" placeholder="Search" aria-label="Search">
            <button type="submit" name="button_search" class="btn btn-search mt-3">Search</button>
          </form>
          <!-- end search-->

          <div class="row justify-content-center">

            <?php if (isset($error)) : ?>
              <p style="color:black; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" class="card-text">product yang anda cari tidak terdaftar, silahkan coba lagi.</p>
            <?php else : ?>
              <!-- start content -->
              <?php foreach ($products as $product) : ?>
                <div class="col-sm-6 col-md-6 col-lg-4">
                  <div class="card shadow">
                    <div class="inner">
                      <?php
                      $prod = $product["id_product"];
                      $product_thumbnails = query("SELECT * FROM tb_product_thumbnails WHERE id_product = '$prod' ORDER BY id_product_thumbnails ASC LIMIT 1 ;");
                      ?>
                      <?php foreach ($product_thumbnails as $thumb) : ?>
                        <img class="card-img-top" src="<?= base_url('data/profile_product/') . $thumb['thumb_prod']; ?>" alt="Card image cap">
                      <?php endforeach; ?>
                    </div>

                    <div class="card-body text-center">
                      <hr>

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
                          <h5 style="color: black; font-weight: bold;" class="mb-0 line-height-1"><?= strtoupper($product["judul_prod"]); ?></h5>
                          <p class="h7 mb-0 text-gray-500"><?= strtoupper($product["nama_depan"] . " " . $product["nama_belakang"]); ?></p>
                          <p style="color: #b12f27;" class="fas fa-heart"></p>
                          <h6 style="color: black">Skor : <?= round($score, 2); ?></h6>
                        </div>
                      </div>

                      <hr>

                      <h5 style="color: black;" class="card-title">DESCRIPTION</h5>
                      <p style="color:black; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" class="card-text"><?= strtolower($product["deskripsi_prod"]); ?></p>
                      <a href="tester_detail_product.php?id_product=<?= $product['id_product']; ?>" class="btn btn-go">View Profile</a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
              <!-- end content-->

            <?php endif; ?>

          </div>

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
                <!-- end tanda panah tambah-->

              </ul>
            </nav>
          </div>
          <!-- end pagination -->
        </div>
        <!-- end container -->

    </section>

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
    <div class="clas-row-footer">
      <div class="class-col text-center">
        <p>2021 All Rights Reversed by E-Mon Team</p>
      </div>
    </div>
    <!-- end copyright -->

    </div>


    <!-- jquery first, then popper, then bootsrap  -->
    <script src="<?= base_url('data/libraries/jquery/jquery-3.5.1.min.js'); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="<?= base_url('data/libraries/bootsrap/js/bootstrap.js'); ?>"></script>
    <script src="<?= base_url('data/libraries/retina/retina.min.js'); ?>"></script>


</body>

</html>