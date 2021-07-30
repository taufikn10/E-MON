<?php

// MENGHUBUNGKAN KONEKSI DATABASE
require "koneksi_tester.php";

// MENGHUBUNGKAN KONEKSI COMPOSER
require "../data/lib-composer/vendor/autoload.php";


// CEK COOKIE
checkCookie();

// JIKA SUDAH LOGIN MASUKKAN KEDALAM SHOWDATA
if (isset($_SESSION["sign-in"])) {
  header('location: index.php');
  exit;
}

?>

<?php
//PHP SIGN-IN

// APABILA BUTTON SIGN IN DI KLIK
if (isset($_POST["sign-in"])) {
  if (login($_POST) > 0) {
    header('location: index.php');
    exit;
  }

  $error = true;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login - Tester</title>
  <link rel="Icon" href="<?= base_url('data/images/iconE.png'); ?>">
  <link rel="stylesheet" href="<?= base_url('data/libraries/fonts/css.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('data/styles/testerlogin.css?') . time(); ?>">
</head>

<body>

  <!-- start navbar -->
  <div class="nav">
    <div class="logo">
      <img src="<?= base_url('data/images/Emon.png'); ?>" alt="e-mon">
    </div>
  </div>
  <!-- end navbar -->

  <!-- start login -->
  <div class="form-Bg">
    <div class="form-header">
      <h2>Tester login</h2>
      <p>sign in and start reviewing as well rating our products </p>
    </div>

    <?php if (isset($error)) : ?>
      <p style="color: rgba(255, 210, 0, 1); font-style: italic;"> Email / password salah </p>
      <br>
    <?php endif; ?>

    <form action=" " method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <input type="email" name="email" required=" " placeholder="email" maxlength="100" class="input">
      </div>

      <div class="form-group">
        <input type="password" name="password" required=" " placeholder="password" minlength="3" maxlength="10" class="input">
      </div>

      <div class="form-group">
        <input type="checkbox" id="cbx" name="remember" class="inp-cbx" style="display: none;" />
        <label class="cbx" for="cbx">
          <span>
            <svg width="12px" height="10px" viewbox="0 0 12 10">
              <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
            </svg>
          </span>
          <span>Remember me</span>
        </label>
        <a href="tester_forgot.php" class="form-recovery">Forget password</a>
      </div>

      <div class="form-group">
        <button type="submit" name="sign-in">Log In</button>
      </div>

      <a href="<?= base_url('portal.php'); ?>">back</a>
    </form>
  </div>
  <!-- end login -->

  <!-- start gambar bergerak-->
  <div class="area">
    <ul class="circles">
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
    </ul>
  </div>
  <!-- end gambar bergerak -->

  <script src="<?= base_url('data/scripts/login.js'); ?>"></script>


</body>

</html>