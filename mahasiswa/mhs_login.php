<?php

// MENGHUBUNGKAN KONEKSI DATABASE
require "koneksi_mhs.php";

// MENGHUBUNGKAN KONEKSI COMPOSER
require "../data/lib-composer/vendor/autoload.php";

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../data/lib-composer/vendor/PHPMailer/src/Exception.php';
require '../data/lib-composer/vendor/PHPMailer/src/PHPMailer.php';
require '../data/lib-composer/vendor/PHPMailer/src/SMTP.php';


// CEK COOKIE
checkCookie();

// JIKA SUDAH LOGIN MASUKKAN KEDALAM SHOWDATA
if (isset($_SESSION["login"])) {
  header('location: index.php');
  exit;
}

?>

<?php
// PHP SIGN-IN
// APABILA BUTTON SIGN IN DI KLIK
if (isset($_POST["login"])) {
  if (login($_POST) > 0) {
    header('location: index.php');
    exit;
  }

  $error = true;
}
?>

<?php
//PHP SIGN_UP
// APABILA TOMBOL CONFIRM DITEKAN
if (isset($_POST["register"])) {

  if (registrasi($_POST) > 0) {
    echo "<script>
    alert ('User baru berhasil ditambahkan');
    document.location.href = 'mhs_login.php';
    </script>";

    if (isset($_POST["email"]) && isset($_POST["nama-depan"]) && isset($_POST["nama-belakang"])) {
      $emailTo = strtolower(stripcslashes($_POST["email"]));
      $namaDepan = strtolower(stripcslashes($_POST["nama-depan"]));
      $namaBelakang = strtolower(stripcslashes($_POST["nama-belakang"]));
      
      $user = $namaDepan . " " . $namaBelakang;

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
        <h3>Thank you for registering your email on this monitoring website.</h3>";
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


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <title>Login - College</title>
  <link rel="Icon" href="<?= base_url('data/images/iconE.png'); ?>">
  <!-- Bootsrap CSS -->
  <link rel="stylesheet" href="<?= base_url('data/libraries/bootsrap/css/bootstrap.css'); ?>">
  <!-- font gfonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:600">
  <!-- Main CSS -->
  <link rel="stylesheet" type="text/css" href="<?= base_url('data/styles/login.css?') . time(); ?>">
</head>

<body>

  <!-- start navbar -->
  <div class="nav">
    <div class="logo">
      <img src="<?= base_url('data/images/Emon.png'); ?>" alt="e-mon">
    </div>
  </div>
  <!-- end navbar-->

  <div class="login-wrap">
    <div class="login-html">

      <!-- start choose sign-in / sign-up -->
      <input id="tab-1" type="radio" name="tab" class="sign-in" checked>
      <label for="tab-1" class="tab">Sign In</label>

      <input id="tab-2" type="radio" name="tab" class="sign-up">
      <label for="tab-2" class="tab">Sign Up</label>
      <!-- end choose sign-in / sign-up -->

      <div class="login-form">

        <!-- start sign-in -->
        <form action=" " method="POST" enctype="multipart/form-data">
          <div class="sign-in-htm">

            <?php if (isset($error)) : ?>
              <br>
              <p style="color: rgba(255, 210, 0, 1); font-style: italic;"> Email / password salah </p>
            <?php endif; ?>

            <div class="group">
              <label for="email-log" class="label">Email Address</label>
              <input type="email" name="email-log" id="email-log" required=" " placeholder="example@example.com" maxlength="100" class="input">
            </div>

            <div class="group">
              <label for="password-log" class="label">Password</label>
              <input type="password" name="password-log" id="password-log" required=" " minlength="3" maxlength="10" class="input">
            </div>

            <div class="group">
              <input type="checkbox" id="check" name="remember" class="check">
              <label for="check"><span class="icon"></span> Keep me Signed in</label>
            </div>

            <div class="group">
              <input type="submit" name="login" value="Sign In" class="button">
            </div>

            <div class="hr"></div>

            <div class="foot-lnk">
              <a href="mhs_forgot.php">Forgot Password?</a>
            </div>

            <div class="foot-back">
              <a href="<?= base_url('portal.php'); ?> ">Back Portal</a>
            </div>

          </div>
        </form>
        <!-- end sign-in-->

        <!-- start sign-up -->
        <form action=" " method="POST" enctype="multipart/form-data">
          <div class="sign-up-htm">

            <div class="group">
              <label for="nama-depan" class="label">Nama Depan</label>
              <input type="name" name="nama-depan" id="nama-depan" required=" " minlength="1" maxlength="20" class="input">
            </div>

            <div class="group">
              <label for="nama-belakang" class="label">Nama Belakang</label>
              <input type="name" name="nama-belakang" id="nama-belakang" required=" " minlength="1" maxlength="20" class="input">
            </div>

            <div class="group">
              <label for="password" class="label">Password</label>
              <input type="password" name="password" id="password" required=" " minlength="3" maxlength="10" class="input">
            </div>

            <div class="group">
              <label for="confirm-password" class="label">Repeat Password</label>
              <input type="password" name="password2" id="confirm-password" required=" " minlength="3" maxlength="10" class="input">
            </div>

            <div class="group">
              <label for="email" class="label">Email Address</label>
              <input type="email" name="email" id="email" required=" " placeholder="example@example.com" maxlength="50" class="input">
            </div>

            <div class="group">
              <input type="submit" name="register" value="Sign Up" class="button">
            </div>

            <div class="hr"></div>

            <div class="foot-up">
              <label for="tab-1">Already Member?</label>
            </div>

          </div>
        </form>
        <!-- end sign-up -->


      </div>
    </div>
  </div>


  <!-- jquery first, then popper, then bootsrap  -->
  <script src="<?= base_url('data/libraries/jquery/jquery-3.5.1.min.js'); ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="<?= base_url('data/libraries/bootsrap/js/bootstrap.js'); ?>"></script>
  <script src="<?= base_url('data/libraries/retina/retina.min.js'); ?>"></script>


</body>

</html>