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
$id_member = $_GET["id_mhs"];

// QUERY SHOW DATA
$myProduct = query("SELECT * FROM tb_products WHERE id_product = '$id_product' ")[0];

if (hapus_member($id_product, $id_member) > 0) {
	echo "<script>
	alert ('member berhasil dihapus !');
	document.location.href = 'mhs_update.php?id_product=".$myProduct['id_product']."';
	</script>";
} else {
	echo "<script>
	alert ('member gagal dihapus !');
	document.location.href = 'mhs_update.php?id_product=".$myProduct['id_product']."';
	</script>";
}
?>