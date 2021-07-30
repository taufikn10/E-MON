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
$id_product = $_GET["id_product"];
$id_mhs = $_GET["id_mhs"];

if (hapus_product($id_product, $id_mhs) > 0) {
  echo "<script>
  alert ('product berhasil dihapus !');
  document.location.href = 'mhs_myproduct.php';
  </script>";
} else {
  echo "<script>
  alert ('product gagal dihapus !');
  document.location.href = 'mhs_myproduct.php';
  </script>";
}
?>