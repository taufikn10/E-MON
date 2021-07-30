<?php 
// MENGHUBUNGKAN KONEKSI COMPOSER
    require "../data/lib-composer/vendor/autoload.php";

// UUID COMPOSER/RAMSEY
	use Ramsey\Uuid\Uuid;
	use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;



//setting default timezone
	date_default_timezone_set('Asia/Jakarta');

//start session
	session_start();



//membuat koneksi ke database
	$conn = mysqli_connect("localhost", "root", "", "db_product");
	
	if(mysqli_connect_errno()) {
		echo mysqli_connect_error();
	}



//membuat function base_url
	function base_url($url = null) {
		$base_url = "http://localhost/E-mon"; 
		
		if($url != null) {
			return $base_url."/".$url;
		} 
		else {
			return $base_url;
		}
	}
?>

<?php 
// MEMBUAT FUNCTION LOGIN
function login($data) {
	global $conn;

	$username = $_POST["username"];
	$password = $_POST["password"];

	
	$result = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '$username' ") or die (mysqli_error($conn));

    // CEK USERNAME APAKAH ADA PADA TABEL TB_REGIS_MHS
	if ( mysqli_num_rows($result) === 1 ) {
		
      	// CEK APAKAH PASSWORD BENAR 
		$row = mysqli_fetch_assoc($result);

		if ( password_verify($password, $row["password"]) ) {
			
	        // SET SESSION LOGIN
			$_SESSION["masuk"] = true;

	        // SET SESSION ADMIN
			$_SESSION["admin"] = $row["id_admin"];
			$_SESSION["username"] = strtoupper( $row["username"] );
		}
	}
	return mysqli_affected_rows($conn);
}





// MEMBUAT FUNCTION SHOW DATA (READ)
	function query($query) {
		global $conn;
		
		$result = mysqli_query($conn, $query) or die (mysqli_error($conn));
		$boxs = [];

		// AMBIL DATA (FETCH) DARI VARIABEL RESULT DAN MASUKKAN KE ARRAY
		while ( $box = mysqli_fetch_assoc($result) ) {
			$boxs[] = $box;
		}
		return $boxs;
	}





// MEMBUAT FUNCTION COUNT DATA (READ)
	function total($query) {
		global $conn;
		
		$result = mysqli_query($conn, $query) or die (mysqli_error($conn));
		$values = mysqli_fetch_assoc($result);
		$total = $values["total"];

		return $total;
	}





// MMEBUAT FUNCTION TAMBAH DATA TESTER
	function tambah($data) {
		global $conn;

		//Gererator version 4
	    $uuid = Uuid::uuid4()->toString();

		$nama = strtoupper( stripcslashes($data["nama_lengkap"]) );
		$email = strtolower( stripcslashes($data["email_tester"]) );
		$password = mysqli_real_escape_string($conn, $data["password"]);
		$password2 = mysqli_real_escape_string($conn, $data["password2"]);
		
		// CEK EMAIL SUDAH ADA ATAU BELUM
		$result = mysqli_query($conn, "SELECT email_tester FROM tb_bio_tester WHERE email_tester = '$email' ") or die (mysqli_error($conn));

		// CHECK EMAIL
		if ( mysqli_fetch_assoc($result) ) {
			echo "<script>
					alert('Email yang dibuat sudah ada !');
				 </script>";
			
			return false;
		}		

		// CEK KONFIRMASI PASSWORD 
		if ( $password !== $password2 ) {
			echo "<script>
					alert('Konfirmasi password salah');
				 </script>";
			
			return false;
		}

		// ENSKRIPSI PASSWORD
		$passwordValid =  password_hash($password2, PASSWORD_DEFAULT);

		// TAMBAHKAN USER BARU KEDATABASE
		$query = "INSERT INTO tb_bio_tester(id_tester, nama_lengkap, email_tester, password) VALUES('$uuid', '$nama', '$email', '$passwordValid')";

		mysqli_query($conn, $query) or die (mysqli_error($conn));	

		return mysqli_affected_rows($conn);
	}





// MMEBUAT DELETE TESTER
	function delete_tester($id) {
		global $conn;

		// QUERY DELETE DATA
		$query = "DELETE FROM tb_bio_tester WHERE id_tester = '$id' ";

		mysqli_query($conn, $query) or die (mysqli_error($conn));

		// MENGEMBALIKAN NILAI BERUPA "-1"(false) atau "1"(true)
		return mysqli_affected_rows($conn);
	}





// MMEBUAT DELETE MAHASISWA
	function delete_college($id) {
		global $conn;

		// QUERY DELETE DATA
		$query = "DELETE FROM tb_bio_mhs WHERE id_mhs = '$id' ";

		mysqli_query($conn, $query) or die (mysqli_error($conn));

		// MENGEMBALIKAN NILAI BERUPA "-1"(false) atau "1"(true)
		return mysqli_affected_rows($conn);
	}





// MMEBUAT DELETE MAHASISWA
	function delete_product($id) {
		global $conn;

		// QUERY DELETE DATA
		$query = "DELETE FROM tb_products WHERE id_product = '$id' ";

		mysqli_query($conn, $query) or die (mysqli_error($conn));

		// MENGEMBALIKAN NILAI BERUPA "-1"(false) atau "1"(true)
		return mysqli_affected_rows($conn);
	}
?>