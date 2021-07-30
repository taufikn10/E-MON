<?php  

// MENGHUBUNGKAN KONEKSI DATABASE
require "koneksi_tester.php";

// MENGHUBUNGKAN KONEKSI COMPOSER
require "../data/lib-composer/vendor/autoload.php";


// SESSION LOGOUT
$_SESSION = [];
session_unset();
session_destroy();
session_write_close();
setcookie('id_tester', '', time() - 3600, '/');
setcookie('key', '', time() - 3600, '/');
session_regenerate_id(true);

header('location: tester_login.php');
exit

?>