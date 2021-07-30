<?php 
//setting default timezone
date_default_timezone_set('Asia/Jakarta');

//membuat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_product");

if (mysqli_connect_errno()) {
	echo mysqli_connect_error();
}



//membuat function base_url
function base_url($url = null)
{
	$base_url = "http://localhost/E-mon";

	if ($url != null) {
		return $base_url . "/" . $url;
	} else {
		return $base_url;
	}
}

// MEMBUAT FUNCTION SHOW DATA (READ)
function query($query)
{
	global $conn;

	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
	$boxs = [];

	// AMBIL DATA (FETCH) DARI VARIABEL RESULT DAN MASUKKAN KE ARRAY
	while ($box = mysqli_fetch_assoc($result)) {
		$boxs[] = $box;
	}
	return $boxs;
}
?>