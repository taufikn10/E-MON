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
$id_comments = $_GET["id_comments"];
$id_product = $_GET["id_product"];
$id_tester = $_GET["id_tester"];

// QUERY SHOW DATA
$myProduct = query("SELECT * FROM tb_products WHERE id_product = '$id_product' ")[0];

if (hapus_comment($id_comments, $id_product, $id_tester) > 0) {
	echo "<script>
	alert ('comment berhasil dihapus !');
	document.location.href = 'tester_detail_product.php?id_product=".$myProduct['id_product']."';
	</script>";
} else {
	echo "<script>
	alert ('comment gagal dihapus !');
	document.location.href = 'tester_detail_product.php?id_product=".$myProduct['id_product']."';
	</script>";
}
?>