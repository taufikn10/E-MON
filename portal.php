<?php
// MENGHUBUNGKAN KONEKSI DATABASE
require "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal</title>
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
  <link rel="stylesheet" href="<?= base_url('data/styles/portal.css?') . time(); ?>">
</head>

<body>
  <!-- Start Navbar -->
  <section id="nav">
    <div class="nav">
      <div class="logo">
        <img src="<?= base_url('data/images/Emon.png'); ?>" alt="">
      </div>
    </div>
  </section>
  <!-- end Navbar -->

  <!-- Jumbotron -->
  <section id="banner">
    <div class="banner">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="<?= base_url('data/images/Emon.png'); ?>" alt="" class="text-center log-title">
            <h1 class="text">Collect your assignment products here! get your score, get your rating
              with us your products are organized. show your skills show your productcs</h1>
          </div>
          <div class="col-md-6">
            <img src="<?= base_url('data/images/icon.png'); ?>" alt="" class="ban-img img-fluid text-center">
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end Jumbotron -->

  <!-- fitur -->
  <section id="fitur">
    <div class="container text-center yee">
      <h1 class="fitur-desc container">E-Mon is a website that is a collection point for products from D4 Information Management,Every product created by students will be accommodated here</h1>
      <h3 class="fitur-link">To Login to E-Mon please use the following link:</h3>
      <div class="col-md-6 container">
        <!-- BUTTON MENU -->
        <a href="mahasiswa/mhs_login.php" class="btn btn-login animasi yore">Students</a>
        <a href="tester/tester_login.php" class="btn btn-yow animasi yore">Tester</a>
      </div>
    </div>
  </section>

  <!-- history -->
  <section id="history">
    <div class="container yoi">
      <div class="row">
        <div class="col-md-6">
          <img src="<?= base_url('data/images/ilus.png'); ?>" alt="" class="his-img img-fluid text-center">
        </div>
        <div class="col-md-6">
          <h4 class="his-judul text-center">Website History</h4>
          <h5 class="his-text">This E-mon is a website created by a group of 4 from D4 Informatics Management consisting of 4 people with the names
            taufik nurahman, hafid ahmad fauzan, ade neviyani and fachreza n. This website was created in 2021 to fulfill further
            web programming tasks. The purpose of this website was to make it easier for D4 students to collect their products. the
            product referred to here is a web or application that has been made in several courses.</h5>
        </div>
      </div>
    </div>
  </section>

  <!-- Our Product -->
  <section id="product">
    <div class="container prod">
      <div class="text-center">
        <h1 class="yosa"> Our Product </h1>
        <input type="radio" class="produk" name="position" style="cursor: pointer;" />
        <input type="radio" class="produk1" name="position" style="cursor: pointer;" />
        <input type="radio" class="produk2" name="position" style="cursor: pointer;" checked />
        <input type="radio" class="produk3" name="position" style="cursor: pointer;" />
        <input type="radio" class="produk4" name="position" style="cursor: pointer;" />
        <main id="carousel">

          <!-- GAMBAR OUR PRODUCT -->
          <?php
          $products = query("SELECT * FROM tb_products ORDER BY tgl_upload DESC LIMIT 5");
          ?>
          <?php foreach ($products as $product) : ?>
            <?php
            $prod = $product["id_product"];
            $product_thumbnails = query("SELECT * FROM tb_product_thumbnails WHERE id_product = '$prod' ORDER BY id_product_thumbnails ASC LIMIT 1 ;");
            ?>
            <?php foreach ($product_thumbnails as $thumb) : ?>

              <div class="item">
                <img src="<?= base_url('data/profile_product/') . $thumb['thumb_prod']; ?>" alt="" width="100%" height="100%">
              </div>

            <?php endforeach; ?>

          <?php endforeach; ?>
      </div>
      </main>
    </div>
    </div>
  </section>
  <!-- end Our Product -->

  <!-- tester -->
  <div class="review" id="testimonialheading">
    <div class="container">
      <div class="row">
        <div class="col text-center">
          <img src="<?= base_url('data/images/Group 7 (1).png'); ?>" alt="rating">
        </div>
      </div>
    </div>
  </div>
  <!--bts tester -->


  <!-- tester content -->
  <div class="section-testimonial-content" id="testimonialcontent">
    <div class="container">
      <div class="section-popular-testi row justify-content-center">
        <!-- KOMENTARRR -->
        <?php
        $comments = query("SELECT tb_comments.*, tb_bio_tester.* FROM tb_comments INNER JOIN tb_bio_tester ON tb_comments.id_tester = tb_bio_tester.id_tester ORDER BY tgl_comment DESC LIMIT 3");
        ?>
        <?php foreach ($comments as $comment) : ?>
          <div class="col-sm-6 col-md-6 col-lg-4">
            <div class="card card-testimonial text-center">
              <div class="testimonial-content">
                <img src="<?= base_url('data/profile_tester/') . $comment['foto']; ?>" class="mb-4 rounded-circle">
                <h3 class="mb-4"><?= strtoupper($comment["nama_lengkap"]); ?></h3>
                <p class="testimonial">
                  <?= strtolower($comment["comment"]); ?>
                </p>
              </div>
              <hr>
              <p class="jabatan mt-2">
                <?= strtoupper($comment["jabatan"]); ?>
              </p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>



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
            <p><b>Instagram : </b>E-Mon</p>
            <p><b>Email : </b>emon.productkarya@gmail.com</p>
          </div>
        </div>
      </div>
    </div>


    <!-- Copyright -->

    <div class="class-row-footer">
      <div class="class-col text-center">
        <p>2021 All Rights Reversed by E-Mon Team</p>
      </div>
    </div>
    <!-- last -->

    <!-- jquery first, then popper, then bootsrap  -->
    <script src="<?= base_url('data/libraries/jquery/jquery-3.5.1.min.js'); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="<?= base_url('data/libraries/bootsrap/js/bootstrap.js'); ?>"></script>
    <script src="<?= base_url('data/libraries/retina/retina.min.js'); ?>"></script>
</body>

</html>