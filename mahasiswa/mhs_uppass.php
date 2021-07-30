<?php
// MENGHUBUNGKAN KE DATABASE
require 'koneksi_mhs.php';

if (!isset($_GET["code"])) {
  echo "<script>
  alert( 'The link has expired' );
  document.location.href = 'mhs_login.php';
  </script>";
}

$code = $_GET["code"];

$getEmailQuery = mysqli_query($conn, "SELECT * FROM tb_reset_mhs WHERE code='$code'");

if (mysqli_num_rows($getEmailQuery) === 0) {
  echo "<script>
  alert( 'The link has expired' );
  document.location.href = 'mhs_login.php';
  </script>";
}
?>

<?php
if (isset($_POST["forgot"])) {
  // CEK APAKAH BERHASIL DIUBAH ATAU TIDAK
  if (forgot_pwd($_POST) > 0) {
    echo "<script>
    alert( 'recovery password success !' );
    document.location.href = 'mhs_login.php';
    </script>";
  } else {
    echo "<script>
    alert( 'recovery password failed !' );
    document.location.href = 'mhs_uppass.php?code=".$code." ';
    </script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Password</title>
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
        <form class="card mt-4" method="POST" enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group"> 
              <label for="otp">Code OTP</label> 
              <input class="form-control" type="text" id="otp" name="otp" required="" autocomplete="off" placeholder="code-otp">
            </div>
            <div class="form-group"> 
              <label for="new_pass">Enter your new password</label> 
              <input class="form-control" type="password" id="new_pass" name="new_pass" required="" autocomplete="off" placeholder="New password">
            </div>
            <div class="form-group"> 
              <label for="new_pass2">Confirm new password</label> 
              <input class="form-control" type="password" id="new_pass2" name="new_pass2" required="" autocomplete="off" placeholder="confirm new password">
            </div>
          </div>
          <div class="card-footer text-center">
            <input class="btn btn-primary" type="submit" name="forgot" value="Update Password">
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