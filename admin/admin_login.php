<?php  

// MENGHUBUNGKAN KONEKSI DATABASE
    require "koneksi_admin.php";

// MENGHUBUNGKAN KONEKSI COMPOSER
    require "../data/lib-composer/vendor/autoload.php";


// JIKA SUDAH LOGIN MASUKKAN KEDALAM SHOWDATA
    if ( isset($_SESSION["masuk"]) ) {
        header('location: admin_dashboard.php');
        exit;
    }

?>

<?php
//PHP SIGN-IN

// APABILA BUTTON SIGN IN DI KLIK
if (isset($_POST["masuk"])) {
  if (login($_POST) > 0) {
    header('location: admin_dashboard.php');
    exit;
  }

  $error = true;
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Admin - Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

        <link rel="Icon" href="<?= base_url('data/images/Emon (4).png'); ?>">

        <link rel="stylesheet" type="text/css" href="<?= base_url('data/syntax/reset.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url('data/styles/admin_login.css'); ?>" />

        <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    </head>

    <body>
        <div class="container">
            <div class="icon">
                <i class="fa fa-lock"></i>
            </div>

            <div class="login">
                <?php if ( isset($error) ) : ?>
                    <p style="color: red; font-style: italic; font-size: 14px;">username / password salah</p><br>
                <?php endif; ?>

                <form action=" " method="POST" enctype="multipart/form-data">
                    <input type="username" name="username" id="username" required=" " placeholder="Username" minlength="3" maxlength="50">
                    <br><br>

                    <input type="password" name="password" id="password" required=" " placeholder="Password" minlength="3" minlength="50">
                    <br><br>

                    <button type="submit" name="masuk">Login</button>
                </form>
            </div>
        </div>
    </body>
</html>