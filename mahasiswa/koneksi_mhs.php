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
?>

<?php
// Check Cookie
function checkCookie()
{
	global $conn;

    // Cek Cookie
	if (isset($_COOKIE['id_mhs']) && isset($_COOKIE['key'])) {
		$id_mhs = $_COOKIE['id_mhs'];
		$key = $_COOKIE['key'];

		$result = mysqli_query($conn, "SELECT nama_depan FROM tb_bio_mhs WHERE id_mhs = '$id_mhs' ");
		$row = mysqli_fetch_assoc($result);

		if ($key === hash('sha256', $row['nama_depan'])) {
			$_SESSION['login'] = true;
		}
	}
}





// MEMBUAT FUNCTION REGISTER COLLEGE-STUDENTS
function registrasi($data)
{
	global $conn;

	//Gererator version 4
	$uuid = Uuid::uuid4()->toString();

	$namaDepan = strtoupper(stripcslashes($data["nama-depan"]));
	$namaBelakang = strtoupper(stripcslashes($data["nama-belakang"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);
	$email = strtolower(stripcslashes($data["email"]));

	// CEK EMAIL SUDAH ADA ATAU BELUM
	$result = mysqli_query($conn, "SELECT email_mhs FROM tb_bio_mhs WHERE email_mhs = '$email' ");

	// CHECK EMAIL
	if (mysqli_fetch_assoc($result)) {
		echo "<script>
		alert('Email yang dibuat sudah ada !');
		</script>";

		return false;
	}

	// CEK KONFIRMASI PASSWORD 
	if ($password !== $password2) {
		echo "<script>
		alert('Konfirmasi password salah');
		</script>";

		return false;
	}

	// ENSKRIPSI PASSWORD
	$passwordValid =  password_hash($password2, PASSWORD_DEFAULT);

	// TAMBAHKAN USER BARU KEDATABASE
	$query = "INSERT INTO tb_bio_mhs(id_mhs, nama_depan, nama_belakang, email_mhs, password) 
	VALUES('$uuid', '$namaDepan', '$namaBelakang', '$email', '$passwordValid')";

	mysqli_query($conn, $query) or die(mysqli_error($conn));

	return mysqli_affected_rows($conn);
}





// MEMBUAT FUNCTION LOGIN
function login($data)
{
	global $conn;

	$emailLog = strtolower($_POST["email-log"]);
	$passwordLog = $_POST["password-log"];

	$result = mysqli_query($conn, "SELECT * FROM tb_bio_mhs WHERE email_mhs = '$emailLog' ");

	// CEK USERNAME APAKAH ADA PADA TABEL TB_REGIS_MHS
	if (mysqli_num_rows($result) === 1) {

		// CEK APAKAH PASSWORD BENAR 
		$row = mysqli_fetch_assoc($result);

		if (password_verify($passwordLog, $row["password"])) {

			// SET SESSION LOGIN
			$_SESSION["login"] = true;

			// SET SESSION USER
			$_SESSION["id_mhs"] = $row["id_mhs"];

			// Cek Remember
			if (isset($_POST['remember'])) {
                // Buat Cookie
				setcookie('id_mhs', $row['id_mhs'], time() + 86400, '/');
				setcookie('key', hash('sha256', $row['nama_depan']), time() + 86400, '/');
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

	$result = mysqli_query($conn, "SELECT * FROM tb_reset_mhs WHERE otp = '$otp' ");

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
	$query_delete = "DELETE FROM tb_reset_mhs WHERE otp = '$otp' ";
	mysqli_query($conn, $query_delete) or die(mysqli_error($conn));	

	$query_reset = "UPDATE tb_bio_mhs SET password = '$passwordValid' WHERE id_mhs = '".$row["id_mhs"]."' ";
	mysqli_query($conn, $query_reset) or die(mysqli_error($conn));

	// MENGEMBALIKAN NILAI BERUPA "-1"(false) atau "1"(true)
	return mysqli_affected_rows($conn);
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





// MEMBUAT FUNCTION COUNT DATA (READ)
function total($query)
{
	global $conn;

	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
	$values = mysqli_fetch_assoc($result);
	$total = $values["total"];

	return $total;
}





// *************** FUNCTION UPLOAD FOTO *************** //
function uploadFoto()
{
	$namaGambar = $_FILES['foto']['name'];
	$ukuranGambar = $_FILES['foto']['size'];
	$tmpGambar = $_FILES['foto']['tmp_name'];
	$error = $_FILES['foto']['error'];

	// CEK APAKAH TIDAK ADA GAMBAR YANG DIUPLOAD (ERROR_VALUE = "4" -> TIDAK ADA )
	if ($error === 4) {
		echo "<script>
		alert('pilih gambar terlebih dahulu');
		</script>";

		return false;
	}

	// CEK APAKAH YANG DIUPLOAD ADALAH GAMBAR
	$formatGambarValid = ['jpg', 'jpeg', 'png', 'jfif'];
	$formatGambar = explode('.', $namaGambar);
	$formatGambar = strtolower(end($formatGambar));

	// CEK APAKAH EKSTENSI GAMBAR YANG DI UPLOAD [$formatGambar] == EKSTENSI GAMBAR YANG DIPERBOLEHKAN [$formatGambarValid]
	if (!in_array($formatGambar, $formatGambarValid)) {
		echo "<script>
		alert('yang anda upload bukan gambar');
		</script>";

		return false;
	}

	// CEK UKURAN FILE YANG DI UPLOAD [max : 5MB]
	if ($ukuranGambar > 5000000) {
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

	$folder = '../data/profile_mhs/'; // nama folder tempat penyimpanan baru

	move_uploaded_file($tmpGambar, $folder . $namaGambarBaru);

	return $namaGambarBaru;
}





// MEMBUAT FUNCTION UPDATE DATA
function update($data)
{
	global $conn;

	// AMBIL DATA DARI TIAP ELEMEN KEY DALAM FORM
	$id_mhs = $data["id_mhs"];

	$fname = strtoupper(htmlspecialchars($data["nama_depan"]));
	$lname = strtoupper(htmlspecialchars($data["nama_belakang"]));
	$nim = htmlspecialchars($data["nim"]);
	$prodi = strtoupper(htmlspecialchars($data["prodi"]));
	$jurusan = strtoupper(htmlspecialchars($data["jurusan"]));
	$alamat = strtoupper(htmlspecialchars($data["alamat"]));
	$kab_kota = strtoupper(htmlspecialchars($data["kab_kota"]));
	$provinsi = strtoupper(htmlspecialchars($data["provinsi"]));
	$email = strtolower(htmlspecialchars($data["email"]));
	$ttl = $data["date"];
	$jk = htmlspecialchars($data["jenisKelamin"]);
	$telp = htmlspecialchars($data["telp"]);

	$oldFoto = htmlspecialchars($data["oldFoto"]);

	// CEK APAKAH USER MENGUBAH GAMBAR BARU ATAU TIDAK
	if ($_FILES['foto']['error'] === 4) {
		$foto = $oldFoto;
	} else {
		$foto = uploadFoto();
	}

	// QUERY INSERT DATA
	$query = "UPDATE tb_bio_mhs SET 
	nama_depan = '$fname', 
	nama_belakang = '$lname', 
	nim = '$nim', 
	ttl = '$ttl', 
	jenis_kelamin = '$jk',
	prodi = '$prodi',
	jurusan = '$jurusan',
	alamat = '$alamat',
	kab_kota = '$kab_kota',
	provinsi = '$provinsi',
	telepon = '$telp',
	foto = '$foto',
	email_mhs = '$email'
	WHERE id_mhs = '$id_mhs' ";

	mysqli_query($conn, $query);

	// MENGEMBALIKAN NILAI BERUPA "-1"(false) atau "1"(true)
	return mysqli_affected_rows($conn);
}





// MEMBUAT FUNCTION CHANGE PASSWORD
function change_pwd($data)
{
	global $conn;

	// AMBIL DATA DARI TIAP ELEMEN KEY DALAM FORM
	$id_mhs = $data["id_mhs"];

	$old_pwd = $_POST["old_pass"];
	$new_pwd = mysqli_real_escape_string($conn, $data["new_pass"]);
	$new_pwd2 = mysqli_real_escape_string($conn, $data["new_pass2"]);

	$result = mysqli_query($conn, "SELECT * FROM tb_bio_mhs WHERE id_mhs = '$id_mhs' ") or die(mysqli_error($conn));

	// CEK APAKAH PASSWORD BENAR 
	$row = mysqli_fetch_assoc($result);

	if (password_verify($old_pwd, $row["password"])) {

		// CEK APAKAH USER MEMASUKKAN PASSWORD BARU 
		if ($new_pwd !== $old_pwd) {

			// CEK KONFIRMASI PASSWORD 
			if ($new_pwd !== $new_pwd2) {
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
	$query = "UPDATE tb_bio_mhs SET password = '$passwordValid' WHERE id_mhs = '$id_mhs' ";

	mysqli_query($conn, $query) or die(mysqli_error($conn));

	// MENGEMBALIKAN NILAI BERUPA "-1"(false) atau "1"(true)
	return mysqli_affected_rows($conn);
}





// MEMBUAT FUNCTION UPLOAD PRODUCT
function upload_product($data, $mhs)
{
	global $conn;

	//Gererator version 4
	$uuid = Uuid::uuid4()->toString();

	$leader = $mhs['id_mhs'];
	$namaTeam = strtoupper(stripcslashes($data["nama_tim"]));
	$title = strtoupper(stripcslashes($data["nama_produk"]));
	$desc = strtoupper(stripcslashes($data["deskripsi_produk"]));

	$result = mysqli_query($conn, "SELECT judul_prod FROM tb_products WHERE judul_prod = '$title' ") or die(mysqli_error($conn));

	// CHECK JUDUL
	if (mysqli_fetch_assoc($result)) {
		echo "<script>
		alert('Judul yang anda buat sudah pernah ada sebelumnya ! cari judul lain');
		</script>";

		return false;
	}

	//query insert data ke tabel TB_PRODUCT
	$query_product = "INSERT INTO tb_products(id_product, nama_tim, id_mhs, judul_prod, deskripsi_prod) VALUES('$uuid', '$namaTeam', '$leader', '$title', '$desc')";

	mysqli_query($conn, $query_product) or die(mysqli_error($conn));


	//query insert data ke tabel TB_PRODUCT_THUMBNAILS
	foreach ($_FILES['thumb_product']['tmp_name'] as $img => $image) {

		$namaGambar = $_FILES['thumb_product']['name'][$img];
		$ukuranGambar = $_FILES['thumb_product']['size'][$img];
		$tmpGambar = $_FILES['thumb_product']['tmp_name'][$img];
		$error = $_FILES['thumb_product']['error'][$img];

		// CEK APAKAH TIDAK ADA GAMBAR YANG DIUPLOAD (ERROR_VALUE = "4" -> TIDAK ADA )
		if ($error === 4) {
			echo "<script>
			alert('pilih gambar terlebih dahulu');
			</script>";

			return false;
		}

		// CEK APAKAH YANG DIUPLOAD ADALAH GAMBAR
		$formatGambarValid = ['jpg', 'jpeg', 'png', 'jfif'];
		$formatGambar = explode('.', $namaGambar);
		$formatGambar = strtolower(end($formatGambar));

		// CEK APAKAH EKSTENSI GAMBAR YANG DI UPLOAD [$formatGambar] == EKSTENSI GAMBAR YANG DIPERBOLEHKAN [$formatGambarValid]
		if (!in_array($formatGambar, $formatGambarValid)) {
			echo "<script>
			alert('yang anda upload bukan gambar');
			</script>";

			return false;
		}

		// CEK UKURAN FILE YANG DI UPLOAD [max : 10MB]
		if ($ukuranGambar > 10000000) {
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

		$folder = '../data/profile_product/'; // nama folder tempat penyimpanan baru

		move_uploaded_file($tmpGambar, $folder . $namaGambarBaru);


		$query_thumbnail = "INSERT INTO tb_product_thumbnails(id_product, thumb_prod) VALUES('$uuid', '$namaGambarBaru')";

		mysqli_query($conn, $query_thumbnail) or die(mysqli_error($conn));
	}


	//query insert data ke tabel TB_PRODUCT_MEMBERS
	$members = $_POST['team_member'];

	foreach ($members as $member) {
		$query_member = "INSERT INTO tb_product_members(id_product, id_mhs) VALUES('$uuid', '$member')";
		mysqli_query($conn, $query_member) or die(mysqli_error($conn));
	}

	//mengembalikan nilai berupa "-1"(false) atau "1"(true)
	return mysqli_affected_rows($conn);
}





// MEMBUAT FUNCTION UPDATE PRODUCT
function update_product($data)
{
	global $conn;

	// AMBIL DATA DARI TIAP ELEMEN KEY DALAM FORM
	$id_product = $data["id_product"];

	$namaTeam = strtoupper(stripcslashes($data["nama_tim"]));
	$title = strtoupper(stripcslashes($data["nama_produk"]));
	$desc = strtoupper(stripcslashes($data["deskripsi_produk"]));

	// $oldProduct = htmlspecialchars($data["oldProduct"]);


	//query update data ke tabel TB_PRODUCT
	$query_product = "UPDATE tb_products SET 
	nama_tim = '$namaTeam', 
	judul_prod = '$title', 
	deskripsi_prod = '$desc'
	WHERE id_product = '$id_product' ";

	mysqli_query($conn, $query_product) or die(mysqli_error($conn));


	//query insert data ke tabel TB_PRODUCT_THUMBNAILS
	foreach ($_FILES['thumb_product']['tmp_name'] as $img => $image) {

		$namaGambar = $_FILES['thumb_product']['name'][$img];
		$ukuranGambar = $_FILES['thumb_product']['size'][$img];
		$tmpGambar = $_FILES['thumb_product']['tmp_name'][$img];
		$error = $_FILES['thumb_product']['error'][$img];

		// CEK APAKAH TIDAK ADA GAMBAR YANG DIUPLOAD (ERROR_VALUE = "4" -> TIDAK ADA )
		if ($error !== 4) {
			// CEK APAKAH YANG DIUPLOAD ADALAH GAMBAR
			$formatGambarValid = ['jpg', 'jpeg', 'png', 'jfif'];
			$formatGambar = explode('.', $namaGambar);
			$formatGambar = strtolower(end($formatGambar));

			// CEK APAKAH EKSTENSI GAMBAR YANG DI UPLOAD [$formatGambar] == EKSTENSI GAMBAR YANG DIPERBOLEHKAN [$formatGambarValid]
			if (!in_array($formatGambar, $formatGambarValid)) {
				echo "<script>
				alert('yang anda upload bukan gambar');
				</script>";

				return false;
			}

			// CEK UKURAN FILE YANG DI UPLOAD [max : 10MB]
			if ($ukuranGambar > 10000000) {
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

			$folder = '../data/profile_product/'; // nama folder tempat penyimpanan baru

			move_uploaded_file($tmpGambar, $folder . $namaGambarBaru);


			$query_thumbnail = "INSERT INTO tb_product_thumbnails(id_product, thumb_prod) VALUES('$id_product', '$namaGambarBaru')";

			mysqli_query($conn, $query_thumbnail) or die(mysqli_error($conn));
		}			
	}

	// MENGEMBALIKAN NILAI BERUPA "-1"(false) atau "1"(true)
	return mysqli_affected_rows($conn);
}





// MEMBUAT FUNCTION UPDATE MEMBERS
function update_member($data)
{
	global $conn;

	// AMBIL DATA DARI TIAP ELEMEN KEY DALAM FORM
	$id_product = $data["id_product"];

	//query insert data ke tabel TB_PRODUCT_MEMBERS
	$members = $_POST['team_member'];

	foreach ($members as $member) {
		$result = mysqli_query($conn, "SELECT * FROM tb_product_members WHERE id_product = '$id_product' AND id_mhs = '$member' ");

		//check apakah member sudah ada pada product atau belum
		if (mysqli_fetch_assoc($result)) {
			// QUERY DELETE DATA
			$query = "DELETE FROM tb_product_members WHERE id_product = '$id_product' AND id_mhs = '$member' ";

			mysqli_query($conn, $query);
		}

		$query_member = "INSERT INTO tb_product_members(id_product, id_mhs) VALUES('$id_product', '$member')";
		mysqli_query($conn, $query_member);
	}

	// MENGEMBALIKAN NILAI BERUPA "-1"(false) atau "1"(true)
	return mysqli_affected_rows($conn);
}





// *************** MEMBUAT FUNCTION DELETE PRODUCT  *************** //
function hapus_product($id_product, $id_mhs)
{
	global $conn;

	// QUERY DELETE DATA
	$query = "DELETE FROM tb_products WHERE id_product = '$id_product' AND id_mhs = '$id_mhs' ";

	mysqli_query($conn, $query) or die(mysqli_error($conn));

	// MENGEMBALIKAN NILAI BERUPA "-1"(false) atau "1"(true)
	return mysqli_affected_rows($conn);
}





// *************** MEMBUAT FUNCTION DELETE PRODUCT  *************** //
function hapus_member($id_product, $id_member)
{
	global $conn;

	// QUERY DELETE DATA
	$query = "DELETE FROM tb_product_members WHERE id_product = '$id_product' AND id_mhs = '$id_member' ";

	mysqli_query($conn, $query) or die(mysqli_error($conn));

	// MENGEMBALIKAN NILAI BERUPA "-1"(false) atau "1"(true)
	return mysqli_affected_rows($conn);
}





// *************** MEMBUAT FUNCTION DELETE PRODUCT  *************** //
function hapus_thumbnail($id_product, $thumb_prod)
{
	global $conn;

	// QUERY DELETE DATA
	$query = "DELETE FROM tb_product_thumbnails WHERE id_product = '$id_product' AND thumb_prod = '$thumb_prod' ";

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





// MEMBUAT FUNCTION RATE_PUAS
function rate_puas($mhs)
{
	global $conn;

	$mhs = $mhs['id_mhs'];
	$status = "SATISFYING";

	$result = mysqli_query($conn, "SELECT * FROM tb_survey WHERE id_mhs = '$mhs' ");

	//check apakah rate sudah ada pada survey atau belum
	if (mysqli_fetch_assoc($result)) {
		// QUERY DELETE DATA
		$query = "DELETE FROM tb_survey WHERE id_mhs = '$mhs' ";

		mysqli_query($conn, $query);
	}

	//query insert rate ke tabel TB_SURVEY
	$rate = "INSERT INTO tb_survey(id_mhs, status) VALUES('$mhs', '$status')";
	mysqli_query($conn, $rate) or die(mysqli_error($conn));

	//mengembalikan nilai berupa "-1"(false) atau "1"(true)
	return mysqli_affected_rows($conn);
}





// MEMBUAT FUNCTION RATE_PUAS
function rate_cukup($mhs)
{
	global $conn;

	$mhs = $mhs['id_mhs'];
	$status = "ENOUGH";

	$result = mysqli_query($conn, "SELECT * FROM tb_survey WHERE id_mhs = '$mhs' ");

	//check apakah rate sudah ada pada survey atau belum
	if (mysqli_fetch_assoc($result)) {
		// QUERY DELETE DATA
		$query = "DELETE FROM tb_survey WHERE id_mhs = '$mhs' ";

		mysqli_query($conn, $query);
	}

	//query insert rate ke tabel TB_SURVEY
	$rate = "INSERT INTO tb_survey(id_mhs, status) VALUES('$mhs', '$status')";
	mysqli_query($conn, $rate) or die(mysqli_error($conn));

	//mengembalikan nilai berupa "-1"(false) atau "1"(true)
	return mysqli_affected_rows($conn);
}





// MEMBUAT FUNCTION RATE_PUAS
function rate_kurang($mhs)
{
	global $conn;

	$mhs = $mhs['id_mhs'];
	$status = "LESS";

	$result = mysqli_query($conn, "SELECT * FROM tb_survey WHERE id_mhs = '$mhs' ");

	//check apakah rate sudah ada pada survey atau belum
	if (mysqli_fetch_assoc($result)) {
		// QUERY DELETE DATA
		$query = "DELETE FROM tb_survey WHERE id_mhs = '$mhs' ";

		mysqli_query($conn, $query);
	}

	//query insert rate ke tabel TB_SURVEY
	$rate = "INSERT INTO tb_survey(id_mhs, status) VALUES('$mhs', '$status')";
	mysqli_query($conn, $rate) or die(mysqli_error($conn));

	//mengembalikan nilai berupa "-1"(false) atau "1"(true)
	return mysqli_affected_rows($conn);
}

?>