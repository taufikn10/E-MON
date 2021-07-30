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
$id_product = $_GET["id_product"];

// PERIZINAN AKSES
if (!isset($_GET['id_product']) || !query("SELECT * FROM tb_products WHERE id_product = '$id_product' ")) {

  header("location: index.php");
  exit;
}
?>

<?php
// CEK APAKAH TOMBOL SUBMIT SUDAH DITEKAN BELUM
if (isset($_POST["button_score"])) {

  // CEK APAKAH BERHASIL DITAMBAHKAN ATAU TIDAK
  if (gift_score($_POST, $tester) > 0) {
    echo "<script>
    alert( 'score berhasil diberikan!' );
    document.location.href = 'tester_detail_product.php?id_product=" . $id_product . "';
    </script>";
  } else {
    echo "<script>
    alert( 'score gagal diupload!' );
    document.location.href = 'tester_detail_product.php?id_product=" . $id_product . "';
    </script>";
  }
}
?>

<?php
// CEK APAKAH TOMBOL SUBMIT SUDAH DITEKAN BELUM
if (isset($_POST["add_comment"])) {

  // CEK APAKAH BERHASIL DITAMBAHKAN ATAU TIDAK
  if (gift_comment($_POST, $tester) > 0) {
    echo "<script>
    alert( 'comment berhasil diberikan!' );
    document.location.href = 'tester_detail_product.php?id_product=" . $id_product . "';
    </script>";
  } else {
    echo "<script>
    alert( 'Product gagal diupload!' );
    document.location.href = 'tester_detail_product.php?id_product=" . $id_product . "';
    </script>";
  }
}
?>

<?php
$product = query("SELECT * FROM tb_products WHERE id_product = '$id_product' ")[0];
?>

<?php
$prod = $product["id_product"]; 


$total_score = total("SELECT sum(score) AS 'total' FROM tb_score WHERE id_product = '$prod' ");
$total_tester = total("SELECT count(id_tester) AS 'total' FROM tb_score WHERE id_product = '$prod' ");

if ($total_tester == NULL || !$total_tester) {
  $score = '0';
}  else {
  $score = $total_score / $total_tester;
}

// echo "total score :";var_dump($total_score); echo "<br>";
// echo "total tester :";var_dump($total_tester); echo "<br>";
// var_dump($score); echo "<br>";
// die;
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= strtolower($product["judul_prod"]); ?></title>
  <link rel="Icon" href="<?= base_url('data/images/iconE.png'); ?>">
  <!-- Bootsrap CSS -->
  <link rel="stylesheet" href="<?= base_url('data/libraries/bootsrap/css/bootstrap.css'); ?>">
  <!-- xzom css -->
  <link rel="stylesheet" href="<?= base_url('data/libraries/xzoom/xzoom.css'); ?>">
  <!-- font -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <!-- font Awesome -->
  <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <!-- font gfonts -->
  <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&  display=swap" rel="stylesheet">
  <!-- Main CSS -->
  <link rel="stylesheet" href="<?= base_url('data/styles/detail.css?') . time(); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

    <section class="section-detail-header"></section>
    <section class="section-detail-content">
      <div class="container">

        <!-- start navbar myproduct/detail -->
        <div class="col p-0">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item" style="word-spacing: 10px; font-size: 20px;">Score : <?= round($score, 2); ?></li>
            </ol>
          </nav>
          <?php 
            $person_score = query("SELECT * FROM tb_score WHERE id_product = '$id_product' ");
          ?>
          <?php  foreach ($person_score as $ps) : ?>       
            <?php  if ($ps["id_tester"] == $tester["id_tester"]) : ?>
              <?php if ($ps) : ?>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item" style="font-size: 17px; color: rgb(51, 133, 255);">Score yang anda berikan : <?= $ps["score"]; ?></li>
                  </ol>
                </nav>
              <?php endif; ?>  
            <?php endif; ?>
          <?php endforeach; ?>

          ?>
        </div>
        <!-- end navbar myproduct/detail -->

        <div class="row">

          <!-- START MENAMPILKAN DATA PRODUCT -->
          <?php
          $products = query("SELECT tb_products.*, tb_bio_mhs.* FROM tb_products INNER JOIN tb_bio_mhs ON tb_products.id_mhs = tb_bio_mhs.id_mhs WHERE id_product='$id_product';");
          ?>
          <?php foreach ($products as $product) : ?>
            <div class="col-lg-8 pl-lg-0">
              <div class="card card-detail">

                <!-- start keterangan profile -->
                <div class="row align-items-center no-glutters">
                  <div class="col-auto">
                    <div class="mr-2 embed-responsive embed-responsive-1by1 d-inline-block" style="width: 60px;">
                      <div class="embed-responsive-item">
                        <img src="<?= base_url('data/profile_mhs/') . $product["foto"]; ?>" alt="" style="width: 100%;" class="rounded-circle">
                      </div>
                    </div>
                  </div>

                  <div class="col pl-0">
                    <h2 class="mb-0 line-height-1"><?= strtoupper($product["nama_depan"] . " " . $product["nama_belakang"]); ?></h2>
                    <p class="h7 mb-0 text-gray-500"><?= $product["nim"]; ?></p>
                  </div>
                </div>
                <!-- end keterangan profile -->

                <!-- start judul product -->
                <h1 class="align-items-center d-flex justify-content-center" style="font-size: 35px; font-weight: bold;"><?= $product["judul_prod"]; ?></h1>
                <hr>
                <p>tanggal upload : <?= $product["tgl_upload"]; ?></p>
                <!-- end judul product -->

                <!-- start menampilkan thumbnail produk -->
                <div class="gallery">
                  <?php
                  $prod = $product["id_product"];
                  $header_thumbnails = query("SELECT * FROM tb_product_thumbnails WHERE id_product = '$prod' ORDER BY id_product_thumbnails ASC LIMIT 1;");
                  ?>
                  <div class="xzoom-container">
                    <?php foreach ($header_thumbnails as $ht) : ?>
                      <img src="<?= base_url('data/profile_product/') . $ht['thumb_prod']; ?>" class="xzoom" id="xzoom-default" xoriginal="<?= base_url('data/profile_product/') . $ht['thumb_prod']; ?>">
                    <?php endforeach; ?>
                  </div>

                  <?php
                  $prod = $product["id_product"];
                  $product_thumbnails = query("SELECT * FROM tb_product_thumbnails WHERE id_product = '$prod' ;");
                  ?>
                  <div class="xzoom-thumbs">
                    <?php foreach ($product_thumbnails as $tb) : ?>
                      <a href="<?= base_url('data/profile_product/') . $tb['thumb_prod']; ?>">
                        <img src="<?= base_url('data/profile_product/') . $tb['thumb_prod']; ?>" class="xzoom-gallery" width="128" xpreview="<?= base_url('data/profile_product/') . $tb['thumb_prod']; ?>">
                      </a>
                    <?php endforeach; ?>
                  </div>
                </div>
                <!-- start menampilkan thumbnail produk -->

                <!-- start keterangan produk -->
                <h2>About Website </h2>
                <p style="text-align: justify; text-indent: 50px;"><?= strtolower($product["deskripsi_prod"]); ?></p>
                <!-- end keterangan produk -->

              </div>
            </div>
            <!-- END MENAMPILKAN DATA PRODUK -->

            <!-- START GROUP INFORMASI -->
            <div class="col-lg-4">
              <div class="card card-detail card-right">
                <h2 class="card-tittle align-items-center d-flex justify-content-center">Grup Information</h2>
                <hr>
                <tr>
                  <h6 style="color: black; font-family: 'Quicksand', sans-serif;" class="card-tittle align-items-center d-flex justify-content-center"><?= strtoupper($product["nama_tim"]); ?><br></h6>
                </tr>
                <hr>
                <h2 class="card-tittle align-items-center d-flex justify-content-center">Grup Member</h2>

                <table class=" group-information">
                  <hr>

                  <!-- start profile members -->
                  <div class="grup embed-responsive-item my-2">

                    <a href="tester_check_product_mhs.php?id_mhs=<?= $product['id_mhs']; ?> &id_product=<?= $product['id_product']; ?>">
                      <div class="row align-items-center no-glutters">
                        <div class="col-auto">
                          <div class="mr-2 embed-responsive embed-responsive-1by1 d-inline-block" style="width: 60px;">
                            <div class="embed-responsive-item">
                              <img src="<?= base_url('data/profile_mhs/') . $product['foto']; ?>" class="mb-4 rounded-circle" alt="">
                            </div>
                          </div>
                        </div>
                        <div class="col pl-0">
                          <h6 style="color: black; font-weight:bold;" ><?= strtoupper($product["nama_depan"] . " " . $product["nama_belakang"]); ?><br></h6>
                        </div>
                      </div>
                    </a>

                    <?php
                    $prod = $product["id_product"];
                    $members = query("SELECT tb_product_members.*, tb_bio_mhs.* FROM tb_product_members INNER JOIN tb_bio_mhs ON tb_product_members.id_mhs = tb_bio_mhs.id_mhs WHERE id_product = '$prod' ");
                    ?>
                    <?php foreach ($members as $member) : ?>
                      <div class="row align-items-center no-glutters">
                        <div class="col-auto">
                          <div class="mr-2 embed-responsive embed-responsive-1by1 d-inline-block" style="width: 60px;">
                            <div class="embed-responsive-item">
                              <img src="<?= base_url('data/profile_mhs/') . $member['foto']; ?>" class="mb-4 rounded-circle" alt="">
                            </div>
                          </div>
                        </div>
                        <div class="col pl-0">
                          <h6 style="color: black;"><?= strtoupper($member["nama_depan"] . " " . $member["nama_belakang"]); ?><br></h6>
                        </div>
                      </div>
                    <?php endforeach ?>
                    <!-- end profile members -->


                    <table class="group-information">

                      <hr>  

                      <!-- start score tester -->
                      <form action=" " method="POST" enctype="multipart/form-data">

                        <input type="hidden" name="id_product" value="<?= $product["id_product"]; ?>">
                        <h2 class="card-tittle align-items-center d-flex justify-content-center">
                          <label for="score">Score</label>
                        </h2>

                        <div class="score-area  align-items-center d-flex justify-content-center">
                          <div class="slideContainer">
                            <input type="range" min="0" max="100" value="0" id="myRange" class="slider" id="score" name="score" placeholder="score">
                            <p style=" font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">Score : <span id=value></span></p>
                          </div>
                          <button type="submit" class="btn btn-submit btn-md ml-2" name="button_score">Submit</button>
                        </div>

                      </form>
                      <!-- end score tester-->

                      <hr>

                      <!-- start add comment tester -->
                      <form action=" " method="POST" enctype="multipart/form-data">

                        <input type="hidden" name="id_product" value="<?= $product["id_product"]; ?>">

                        <h2 class="card-tittle align-items-center d-flex justify-content-center">
                          <label for="comment">Add Comment</label>
                        </h2>
                        <div class="coment-area">
                          <textarea class="form-control" id="comment" name="comment" placeholder="what is your view?" rows="4" required=""></textarea>
                        </div>

                        <div class="coment-btns mt-2">
                          <div class="col align-items-center d-flex justify-content-center">
                            <div class="pull-right">
                              <button type="submit" class="btn btn-success send btn-sm" name="add_comment">Send<i class="fa fa-long-arrow-right ml-1"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                      <!-- end add comment tester-->

                    </table>
                  </div>
                </div>
              <?php endforeach; ?>
              <!-- END GROUP INFORMASI -->

            </div>
          </div>
        </section>

      </main>

      <!-- start comment -->
      <section>
        <div class="container">
          <h1 style="margin-top: 50px;">Comments</h1>
          <hr>

          <!-- tester content --> 
          <div class="section section-tester-content" id="testercontent">
            <div class="container">
              <div class="section-popular-travel row justify-content-center">
                <?php
                $products = query("SELECT tb_products.*, tb_bio_mhs.* FROM tb_products INNER JOIN tb_bio_mhs ON tb_products.id_mhs = tb_bio_mhs.id_mhs WHERE id_product='$id_product';");
                ?>
                <?php foreach ($products as $product) : ?>
                  <?php
                  $prod = $product["id_product"];

                  $comments = query("SELECT tb_comments.*, tb_bio_tester.* FROM tb_comments INNER JOIN tb_bio_tester ON tb_comments.id_tester = tb_bio_tester.id_tester WHERE id_product = '$prod' ORDER BY id_comments DESC;");

                  $check = $comments;
                  ?>
                  <?php if (!$check) : ?>
                    <p class="tester">belum ada komentar yang diberikan.</p>
                    <?php else : ?>
                      <?php foreach ($comments as $comment) : ?>
                        <div class="col-sm-6 col-md-6 col-lg-4">

                          <?php if ($comment["id_tester"] == $my_id) : ?>
                            <a href="tester_delete_comment.php?id_comments=<?= $comment['id_comments']; ?> &id_product=<?= $comment['id_product']; ?> &id_tester=<?= $comment['id_tester']; ?>" class="btn btn-danger btn-flat btn-xs float-right mt-2" onClick=" return confirm('Apakah anda ingin menghapus komentar ini ?');" style="font-size: 15px; margin-right: 5px; padding: 2px 7px; background-color: #071C4D; border:none;">
                              <i class="fas fa-times"></i>
                            </a>
                          <?php endif; ?>

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
                    <?php endif; ?>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </section>
          <!-- end comment -->

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


          <!-- jquery first, then popper, then bootsrap  -->
          <script src="<?= base_url('data/libraries/jquery/jquery-3.5.1.min.js'); ?>"></script>
          <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
          <script src="<?= base_url('data/libraries/bootsrap/js/bootstrap.js'); ?>"></script>
          <script src="<?= base_url('data/libraries/retina/retina.min.js'); ?>"></script>
          <script src="<?= base_url('data/libraries/xzoom/xzoom.min.js'); ?>"></script>
          <!-- js slider-->
          <script src="<?= base_url('data/scripts/rangeslider.js'); ?>"></script>

          <script>
            $(document).ready(function() {
              $(".xzoom, .xzoom-gallery").xzoom({
                zoomWidth: 400,
                tittle: false,
                tint: '#333',
                Xoffset: 15
              });
            });
          </script>


        </body>

        </html>