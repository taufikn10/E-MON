<?php 
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
// Check Cookie
function checkCookie()
{
    global $conn;

    // Cek Cookie
    if (isset($_COOKIE['id_tester']) && isset($_COOKIE['key'])) {
        $id_tester = $_COOKIE['id_tester'];
        $key = $_COOKIE['key'];

        $result = mysqli_query($conn, "SELECT nama_lengkap FROM tb_bio_tester WHERE id_tester = '$id_tester' ");
        $row = mysqli_fetch_assoc($result);

        if ($key === hash('sha256', $row['nama_lengkap'])) {
            $_SESSION['sign-in'] = true;
        }
    }
}





// MEMBUAT FUNCTION LOGIN
function login($data) {
	global $conn;

	$email = $_POST["email"];
	$password = $_POST["password"];

	
	$result = mysqli_query($conn, "SELECT * FROM tb_bio_tester WHERE email_tester = '$email' ") or die (mysqli_error($conn));

	    // CEK USERNAME APAKAH ADA PADA TABEL TB_REGIS_MHS
	if ( mysqli_num_rows($result) === 1 ) {
		
	      	// CEK APAKAH PASSWORD BENAR 
		$row = mysqli_fetch_assoc($result);

		if ( password_verify($password, $row["password"]) ) {
			
		        // SET SESSION LOGIN
			$_SESSION["sign-in"] = true;

		        // SET SESSION USER
			$_SESSION["id_tester"] = $row["id_tester"];

			// Cek Remember
            if (isset($_POST['remember'])) {
                // Buat Cookie
                setcookie('id_tester', $row['id_tester'], time() + 86400, '/');
                setcookie('key', hash('sha256', $row['nama_lengkap']), time() + 86400, '/');
            }
		}
	}
	return mysqli_affected_rows($conn);
}





// MEMBUAT FUNCTION CHANGE PASSWORD
function forgot_pwd($data)
{
	global $conn;

	$otp = mysqli_real_escape_string($conn, $data["otp"]);
	$new_pwd = mysqli_real_escape_string($conn, $data["new_pass"]);
	$new_pwd2 = mysqli_real_escape_string($conn, $data["new_pass2"]);

	$result = mysqli_query($conn, "SELECT * FROM tb_reset_tester WHERE otp = '$otp' ");

	if (mysqli_num_rows($result) === 0) {
		echo "<script>
		alert('Incorrect OTP code');
		</script>";

		return false;
	}

	// CEK APAKAH PASSWORD BENAR 
	$row = mysqli_fetch_assoc($result);

	// CEK KONFIRMASI PASSWORD 
		if ($new_pwd !== $new_pwd2) {
			echo "<script>
				alert('Konfirmasi password salah');
				</script>";

			return false;
		}
	
	// ENSKRIPSI PASSWORD
	$passwordValid = password_hash($new_pwd2, PASSWORD_DEFAULT);

	// QUERY
	$query_delete = "DELETE FROM tb_reset_tester WHERE otp = '$otp' ";
	mysqli_query($conn, $query_delete) or die(mysqli_error($conn));	

	$query_reset = "UPDATE tb_bio_tester SET password = '$passwordValid' WHERE id_tester = '".$row["id_tester"]."' ";
	mysqli_query($conn, $query_reset) or die(mysqli_error($conn));

	// MENGEMBALIKAN NILAI BERUPA "-1"(false) atau "1"(true)
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





// *************** FUNCTION UPLOAD THUMBNAIL *************** //
function uploadFoto() {
	$namaGambar = $_FILES['foto']['name'];
	$ukuranGambar = $_FILES['foto']['size'];
	$tmpGambar = $_FILES['foto']['tmp_name'];
	$error = $_FILES['foto']['error'];

		// CEK APAKAH TIDAK ADA GAMBAR YANG DIUPLOAD (ERROR_VALUE = "4" -> TIDAK ADA )
	if ( $error === 4 ) {
		echo "<script>
		alert('pilih gambar terlebih dahulu');
		</script>";

		return false;
	}

		// CEK APAKAH YANG DIUPLOAD ADALAH GAMBAR
	$formatGambarValid = ['jpg', 'jpeg', 'png', 'jfif'];
	$formatGambar = explode('.', $namaGambar);
	$formatGambar = strtolower( end($formatGambar) );

			// CEK APAKAH EKSTENSI GAMBAR YANG DI UPLOAD [$formatGambar] == EKSTENSI GAMBAR YANG DIPERBOLEHKAN [$formatGambarValid]
	if ( !in_array($formatGambar, $formatGambarValid) ) {
		echo "<script>
		alert('yang anda upload bukan gambar');
		</script>";

		return false;	
	}

		// CEK UKURAN FILE YANG DI UPLOAD [max : 2MB]
	if ( $ukuranGambar > 2000000) {
		echo "<script>
		alert('ukuran gambar terlalu besar');
		</script>";

		return false;
	}

		// APABILA LOLOS PERSYARATAN, COPY GAMBAR DARI FOLDER LAMA [$tmpGambar] KE FOLDER BARU[destionation]
		// GENERATE NAMA BARU -> Agar nama file tidak sama (UNIQUE)
	$namaGambarBaru = uniqid();
	$namaGambarBaru .= '.';
	$namaGambarBaru .= $formatGambar; 

		$folder = '../data/profile_tester/'; // nama folder tempat penyimpanan baru

		move_uploaded_file($tmpGambar, $folder . $namaGambarBaru);

		return $namaGambarBaru;
	}





// MEMBUAT FUNCTION UPDATE DATA
	function update($data) {
		global $conn;

	// AMBIL DATA DARI TIAP ELEMEN KEY DALAM FORM
		$id_tester = $data["id_tester"];

		$fullname = strtoupper( htmlspecialchars( $data["nama_lengkap"] ) );
		$nip = htmlspecialchars( $data["nip"] );		
		$job = strtoupper( htmlspecialchars( $data["job"]) );
		$alamat = strtoupper( htmlspecialchars( $data["alamat"] ) );
		$kab_kota = strtoupper( htmlspecialchars( $data["kab_kota"] ) );
		$provinsi = strtoupper( htmlspecialchars( $data["provinsi"] ) );
		$email = strtolower( htmlspecialchars( $data["email"] ) );
		$ttl = $data["date"];
		$jk = htmlspecialchars( $data["jenisKelamin"] );
		$telp = htmlspecialchars( $data["telp"] );

		$oldFoto = htmlspecialchars($data["oldFoto"]);
		
	// CEK APAKAH USER MENGUBAH GAMBAR BARU ATAU TIDAK
		if ( $_FILES['foto']['error'] === 4 ) {
			$foto = $oldFoto;
		} else {
			$foto = uploadFoto();
		}

	// QUERY INSERT DATA
		$query = "UPDATE tb_bio_tester SET 
		nama_lengkap = '$fullname', 
		nip = '$nip', 
		jabatan = '$job',
		ttl = '$ttl', 
		jenis_kelamin = '$jk',
		alamat = '$alamat',
		kab_kota = '$kab_kota',
		provinsi = '$provinsi',
		telepon = '$telp',
		foto = '$foto',
		email_tester = '$email'
		WHERE id_tester = '$id_tester' ";

		mysqli_query($conn, $query) or die (mysqli_error($conn));	
		
		// MENGEMBALIKAN NILAI BERUPA "-1"(false) atau "1"(true)
		return mysqli_affected_rows($conn);
	}





// MEMBUAT FUNCTION CHANGE PASSWORD
	function change_pwd($data) {
		global $conn;

	// AMBIL DATA DARI TIAP ELEMEN KEY DALAM FORM
		$id_tester = $data["id_tester"];
		
		$old_pwd = $_POST["old_pass"];
		$new_pwd = mysqli_real_escape_string($conn, $data["new_pass"]);
		$new_pwd2 = mysqli_real_escape_string($conn, $data["new_pass2"]);

		$result = mysqli_query($conn, "SELECT * FROM tb_bio_tester WHERE id_tester = '$id_tester' ") or die (mysqli_error($conn));
		
	    // CEK APAKAH PASSWORD BENAR 
		$row = mysqli_fetch_assoc($result);

		if ( password_verify($old_pwd, $row["password"]) ) {
			
	    	// CEK APAKAH USER MEMASUKKAN PASSWORD BARU 
			if ( $new_pwd !== $old_pwd ) {
				
				// CEK KONFIRMASI PASSWORD 
				if ( $new_pwd !== $new_pwd2 ) {
					echo "<script>
					alert('Konfirmasi password salah');
					</script>";
					
					return false;
				}

			} else {
				echo "<script>
				alert('anda tidak memasukkan password baru');
				</script>";
				
				return false;
			}
		} else {
			echo "<script>
			alert('Password yang anda masukkan salah');
			</script>";

			return false;
		}

		// ENSKRIPSI PASSWORD
		$passwordValid = password_hash($new_pwd2, PASSWORD_DEFAULT);
		
		// QUERY UPDATE DATA
		$query = "UPDATE tb_bio_tester SET password = '$passwordValid' WHERE id_tester = '$id_tester' ";
		
		mysqli_query($conn, $query) or die (mysqli_error($conn));
		
		// MENGEMBALIKAN NILAI BERUPA "-1"(false) atau "1"(true)
		return mysqli_affected_rows($conn);
	}





// MEMBUAT FUNCTION UPLOAD COMMENT PRODUCT
	function gift_score($data, $tester)
	{
		global $conn;

		$tester = $tester['id_tester'];
		$product = $data['id_product'];
		$score = $data["score"];

		$result = mysqli_query($conn, "SELECT * FROM tb_score WHERE id_product = '$product' AND id_tester = '$tester' ");

		//check apakah nilai sudah ada pada product atau belum
		if (mysqli_fetch_assoc($result)) {
			// QUERY DELETE DATA
			$query = "DELETE FROM tb_score WHERE id_product = '$product' AND id_tester = '$tester' ";

			mysqli_query($conn, $query);
		}

		//query insert data ke tabel TB_PRODUCT
		$product_score = "INSERT INTO tb_score(id_product, id_tester, score) VALUES('$product', '$tester', '$score')";
		mysqli_query($conn, $product_score) or die(mysqli_error($conn));


		//mengembalikan nilai berupa "-1"(false) atau "1"(true)
		return mysqli_affected_rows($conn);
	}





// MEMBUAT FUNCTION UPLOAD COMMENT PRODUCT
	function gift_comment($data, $tester)
	{
		global $conn;


		$tester = $tester['id_tester'];
		$product = $data['id_product'];
		$comment = strtoupper(stripcslashes($data["comment"]));

		//query insert data ke tabel TB_PRODUCT
		$product_comment = "INSERT INTO tb_comments(id_product, id_tester, comment) VALUES('$product', '$tester', '$comment')";

		mysqli_query($conn, $product_comment) or die(mysqli_error($conn));


		//mengembalikan nilai berupa "-1"(false) atau "1"(true)
		return mysqli_affected_rows($conn);
	}





	// *************** MEMBUAT FUNCTION DELETE PRODUCT  *************** //
	function hapus_comment($id_comments, $id_product, $id_tester)
	{
		global $conn;

	// QUERY DELETE DATA
		$query = "DELETE FROM tb_comments WHERE id_comments = '$id_comments' AND id_product = '$id_product' AND id_tester = '$id_tester' ";

		mysqli_query($conn, $query) or die(mysqli_error($conn));

	// MENGEMBALIKAN NILAI BERUPA "-1"(false) atau "1"(true)
		return mysqli_affected_rows($conn);
	}





	// MEMBUAT FUNCTION SEARCH
	function search($keyword)
	{
		$query = "SELECT tb_products.*, tb_bio_mhs.* FROM tb_products INNER JOIN tb_bio_mhs ON tb_products.id_mhs = tb_bio_mhs.id_mhs WHERE judul_prod LIKE '%$keyword%' ORDER BY tgl_upload DESC";

	// MENGEMBALIKAN NILAI ASSOSIATIF
		return query($query);
	}

	?>