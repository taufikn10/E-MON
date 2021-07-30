<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../data/lib-composer/vendor/PHPMailer/src/Exception.php';
require '../data/lib-composer/vendor/PHPMailer/src/PHPMailer.php';
require '../data/lib-composer/vendor/PHPMailer/src/SMTP.php';

// MENGHUBUNGKAN KE DATABASE
require 'koneksi_tester.php';


if (isset($_POST["email"])) {

  global $conn;
  $emailTo = $_POST["email"];

  $result = mysqli_query($conn, "SELECT * FROM tb_bio_tester WHERE email_tester = '$emailTo' ");
  
  if (mysqli_num_rows ($result) === 1) {

    $row = mysqli_fetch_assoc($result);  
    $code = uniqid();
    $otp = mt_rand(100000, 999999);

    // BUAT KODE OTP UNTUK VERIFIKASI
    $query = "INSERT INTO tb_reset_tester(code, id_tester, otp) VALUES('$code', '".$row["id_tester"]."', '$otp')";
    mysqli_query($conn, $query) or die(mysqli_error($conn));


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
    $url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/tester_uppass.php?code=$code";
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Your Password Reset Link';
    $mail->Body    = "<h1>You Requested a password reset</h1><br>
    <h3>Kode OTP : ".$otp."</h3>
    Click <a href='$url'>This Link</a> to do so ";
    $mail->AltBody = 'Thankyou.';

    $mail->send();
    echo "<script>
    alert ('Reset Password link has been sent to your email');
    document.location.href = 'tester_login.php';
    </script>";
  } 
  catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}
else {
    echo "<script>
    alert ('data yang anda masukkan tidak terdaftar !');
    document.location.href = 'tester_forgot.php';
    </script>";
}
exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <!-- bar -->
  <link rel="Icon" href="<?= base_url('data/images/iconE.png'); ?>">
  <!-- Bootsrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
  <!-- font -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <!-- font Awesome -->
  <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <!-- font gfonts -->
  <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
  <!-- Main CSS -->
  <link rel="stylesheet" href="<?= base_url('data/styles/fopass.css?').time(); ?>">
</head>

<body>
  <!-- Start Navbar -->
  <div class="nav">
    <div class="logo">
      <img src="<?= base_url('data/images/Emon.png'); ?>" alt="Logo nav">
    </div>
  </div>
</header>

<!-- forgot -->
<div class="container padding-bottom-3x mb-2 mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <div class="forgot">
        <h2>Forgot your password?</h2>
        <p>Change your password in three easy steps. This will help you to secure your password!</p>
        <ol class="list-unstyled">
          <li><span class="text-primary text-medium">1. </span>Enter your email address below.</li>
          <li><span class="text-primary text-medium">2. </span>Our system will send you a temporary link</li>
          <li><span class="text-primary text-medium">3. </span>Use the link to reset your password</li>
        </ol>
      </div>
      <form class="card mt-4" method="POST" enctype="multipart/form-data">
        <div class="card-body">
          <div class="form-group"> <label for="email-for-pass">Enter your email address</label> <input class="form-control" type="text" id="email-for-pass" required="" autocomplete="off" name="email"><small class="form-text text-muted">Enter
            the email address you used during the registration on Then we'll email a link to this
          address.</small> </div>
        </div>
        <div class="card-footer text-center">
          <input class="btn btn-success" type="submit" name="submit" value="Reset Email">
          <a href="tester_login.php" class="btn btn-back">Back Login</a>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- jquery first, then popper, then bootsrap  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('data/libraries/retina/retina.min.js'); ?>"></script>

</body>

</html>