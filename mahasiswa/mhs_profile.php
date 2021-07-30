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
// AMBIL DATA DARI URL
$id_mhs = $_GET["id_mhs"];

// PERIZINAN AKSES
if (!isset($_GET['id_mhs']) || !query("SELECT * FROM tb_bio_mhs WHERE id_mhs = '$id_mhs' ")) {

  header("location: index.php");
  exit;
}
?>

<?php
// QUERY SHOW DATA
$profile = query("SELECT * FROM tb_bio_mhs WHERE id_mhs = '$id_mhs' ")[0];

// CEK APAKAH TOMBOL UPDATE SUDAH DITEKAN BELUM
if (isset($_POST["update"])) {

  // CEK APAKAH BERHASIL DIUBAH ATAU TIDAK
  if (update($_POST) > 0) {
    echo "<script>
    alert( 'data berhasil diupdate !' );
    document.location.href = 'mhs_profile.php?id_mhs=" . $profile['id_mhs'] . " ';
    </script>";
  } else {
    echo "<script>
    alert( 'tidak ada data yang diupdate !' );
    document.location.href = 'mhs_profile.php?id_mhs=" . $profile['id_mhs'] . " ';
    </script>";
  }
}

// CEK APAKAH TOMBOL CHANGE_PASSWORD SUDAH DITEKAN BELUM 
if (isset($_POST["change_password"])) {

  // CEK APAKAH BERHASIL DIUBAH ATAU TIDAK
  if (change_pwd($_POST) > 0) {
    echo "<script>
    alert( 'password berhasil diupdate !' );
    document.location.href = 'mhs_profile.php?id_mhs=" . $profile['id_mhs'] . " ';
    </script>";
  } else {
    echo "<script>
    alert( 'password gagal diupdate !' );
    document.location.href = 'mhs_profile.php?id_mhs=" . $profile['id_mhs'] . " ';
    </script>";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= strtolower($mhs['nama_depan'] . " " . $mhs['nama_belakang']); ?>'s profile</title>
  <link rel="Icon" href="<?= base_url('data/images/iconE.png'); ?>">
  <!-- Bootsrap CSS -->
  <link rel="stylesheet" href="<?= base_url('data/libraries/bootsrap/css/bootstrap.css');  ?>">
  <!-- font -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <!-- font Awesome -->
  <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <!-- font gfonts -->
  <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
  <!-- Main CSS -->
  <link rel="stylesheet" href="<?= base_url('data/styles/profil.css?') . time(); ?>">
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

<!-- Main -->
  <section class="profil">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="card card-kiri">
            <!-- start menampilkan foto, nama, email pada kiri form -->
            <div class="col-md-12 embed-responsive">
              <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                <div class="kotak mt-5">
                  <?php if (isset($profile['foto'])) : ?>
                    <img src="<?= base_url('data/profile_mhs/') . $profile['foto']; ?>">
                  <?php endif; ?>
                </div>

                <span class="font-weight-bold"><?= $mhs['nama_depan'] . " " . $mhs['nama_belakang']; ?></span>
                <span class="text-black-50"><?= strtolower($profile['email_mhs']); ?></span>
                <span></span>

              </div>
              <hr>
            </div>
            <!-- end menampilkan foto, nama, email pada kiri form -->

            <!-- start profile-form -->
            <div class="col-md-12">
              <div class="p-3 py-5">

                <form action=" " method="POST" enctype="multipart/form-data">

                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-center">
                      <h4>Profile Settings</h4>
                    </div>
                  </div>

                  <div class="row mt-2">

                    <input type="hidden" name="id_mhs" value="<?= $profile["id_mhs"]; ?>">
                    <input type="hidden" name="oldFoto" value="<?= $profile["foto"]; ?>">

                    <div class="col-md-6">
                      <label class="labels" for="nama_depan">First Name</label>
                      <input type="name" class="form-control" id="nama_depan" name="nama_depan" placeholder="first name" value="<?= strtoupper($profile['nama_depan']); ?>" required="" autofocus>
                    </div>

                    <div class="col-md-6">
                      <label class="labels" for="last_name">last name</label>
                      <input type="name" class="form-control" id="last_name" name="nama_belakang" placeholder="last name" value="<?= strtoupper($profile['nama_belakang']); ?>" required="">
                    </div>

                    <div class="col-md-12">
                      <label class="labels" for="date">Date of birth</label>
                      <input type="date" class="form-control" id="date" name="date" value="<?= $profile['ttl']; ?>" required="">
                    </div>

                    <div class="col-md-12">
                      <label class="labels" for="jkl">Gender</label>
                      <div class="row mt-1">
                        <div class="col-sm-3 gender">
                          <input type="radio" name="jenisKelamin" id="jkl" value="L" required="">
                          <?php if ($profile['jenis_kelamin'] == 'L') {
                            echo "<script>
                      const male = document.getElementById('jkl');
                      male.setAttribute('checked', '');
                      </script>";
                          } ?>
                          <label class="label">Male</label>
                        </div>

                        <div class="col-sm-3">
                          <input type="radio" name="jenisKelamin" id="jkf" value="P">
                          <?php if ($profile['jenis_kelamin'] == 'P') {
                            echo "<script>
                      const female = document.getElementById('jkf');
                      female.setAttribute('checked', '');
                      </script>";
                          } ?>
                          <label class="label">Female</label>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row mt-1">
                    <div class="col-md-12">
                      <label class="labels" for="nim">NIM</label>
                      <input type="number" class="form-control" id="nim" name="nim" placeholder="nim" pattern="[0-9]+" value="<?= $profile['nim']; ?>" required="">
                    </div>

                    <div class="col-md-12">
                      <label class="labels" for="email">Email</label>
                      <input type="email" class="form-control" id="email" name="email" placeholder="email" value="<?= strtolower($profile['email_mhs']); ?>" required="">
                    </div>

                    <div class="col-md-12">
                      <label class="labels" for="study_program">Study Program</label>
                      <input type="text" class="form-control" id="study_program" name="prodi" placeholder="prodi" value="<?= strtoupper($profile['prodi']); ?>" required="">
                    </div>

                    <div class="col-md-12">
                      <label class="labels" for="majors">majors</label>
                      <input type="text" class="form-control" id="majors" name="jurusan" placeholder="jurusan" value="<?= strtoupper($profile['jurusan']); ?>" required="">
                    </div>

                    <div class="col-md-12">
                      <label class="labels" for="address">Address</label>
                      <input type="text" class="form-control" id="address" name="alamat" placeholder="address" value="<?= strtoupper($profile['alamat']); ?>" required="">
                    </div>

                    <div class="col-md-6">
                      <label class="labels" for="kab_kota">district/city</label>
                      <input type="text" class="form-control" id="kab_kota" name="kab_kota" placeholder="district/city" value="<?= strtoupper($profile['kab_kota']); ?>" required="">
                    </div>

                    <div class="col-md-6">
                      <label class="labels" for="provinsi">province</label>
                      <input type="text" class="form-control" id="provinsi" name="provinsi" placeholder="province" value="<?= strtoupper($profile['provinsi']); ?>" required="">
                    </div>

                    <div class="col-md-12">
                      <label class="labels" for="telp">telephone</label>
                      <input type="text" class="form-control" id="telp" name="telp" placeholder="phone number" pattern="[0-9]+" value="<?= $profile['telepon']; ?>" required="">
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="custom-file col-md-12">
                      <label class="labels" for="foto">Choose your photo profile</label>
                      <input type="file" class="form-control" id="foto" name="foto">
                    </div>
                  </div>

                  <div class="mt-5 text-center">
                    <button type="submit" class="btn btn-primary profile-button" name="update">Save Profile</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- end profile-form -->

          </div>
        </div>



        <div class="col-lg-4">
          <div class="card card-kanan">
            <!-- start change password -->
            <form action=" " method="POST" enctype="multipart/form-data">
              <div class="col-lg-12">
                <div class="p-3 py-5">
                  <div class="d-flex justify-content-between align-items-center mb-3 ml-2">
                    <h4 class="text-center">Change Password</h4>
                  </div>

                  <input type="hidden" name="id_mhs" value="<?= $profile["id_mhs"]; ?>">

                  <div class="col-md-12">
                    <label class="labels" for="old_pass">Old Password</label>
                    <input type="password" class="form-control" id="old_pass" name="old_pass" placeholder="Input old password">
                  </div><br>

                  <div class="col-md-12">
                    <label class="labels" for="new_pass">New Password</label>
                    <input type="password" class="form-control" id="new_pass" name="new_pass" placeholder="Input new password">
                  </div><br>

                  <div class="col-md-12">
                    <label class="labels" for="new_pass2">Confirm New Password</label>
                    <input type="password" class="form-control" id="new_pass2" name="new_pass2" placeholder="Input confirm new password">
                  </div>

                  <div class="mt-5 text-center">
                    <button type="submit" class="btn btn-primary profile-button" name="change_password">Change Password</button>
                  </div>
                </div>
              </div>
            </form>
            <!-- end change password -->
          </div>
        </div>
      </div>

    </div>

  </section>
<!-- end Main -->



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
          <p><b>Instagram : </b>@E-Mon</p>
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
  <script src="<?= base_url('data/libraries/bootsrap/js/bootstrap.js'); ?> "></script>
  <script src="<?= base_url('data/libraries/retina/retina.min.js'); ?>"></script>


</body>

</html>