<?php  

// MENGHUBUNGKAN KONEKSI DATABASE
	require "koneksi_admin.php";

// MENGHUBUNGKAN KONEKSI COMPOSER
    require "../data/lib-composer/vendor/autoload.php";


// SESSION LOGOUT
	$_SESSION = [];
	session_unset();
	session_destroy();

	header('location: admin_login.php');
	exit

?>