<?php

// MENGHUBUNGKAN KONEKSI DATABASE
require "koneksi_mhs.php";

// MENGHUBUNGKAN KONEKSI COMPOSER
require "../data/lib-composer/vendor/autoload.php";


// SESSION LOGOUT
$_SESSION = [];
session_unset();
session_destroy();
session_write_close();
setcookie('id_mhs', '', time() - 3600, '/');
setcookie('key', '', time() - 3600, '/');
session_regenerate_id(true);

header('location: mhs_login.php');
exit;
?>
