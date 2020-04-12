<?php
function get_webSettings()

{
	global $connect;
	$CallData = mysqli_query($connect, "SELECT * FROM web_settings WHERE id = '1'");
	$ThisData = mysqli_fetch_assoc($CallData);
	return $ThisData;
}

function base_url()
{
	$base_url = "http://localhost/hotel/";
	return $base_url;
}

function notification()
{
	$_SESSION['notification'] = array('alert' => 'null', 'title' => 'null', 'message' => 'null');
	return $_SESSION['notification'];
}

function filter($data)
{
	$filter = stripslashes(strip_tags(htmlspecialchars(htmlentities($data,ENT_QUOTES))));
	return $filter;
}

function register($data) {
	global $connect;

	$nik = filter($data['nik']);
	$full_name = filter($data['full_name']);
	$address = filter($data['address']);
	$office_origin = filter($data['office_origin']);
	$phone_number = filter($data['phone_number']);
	$username = filter($data['username']);
	$email = $connect->real_escape_string(filter(trim($data['email'])));
	$password1 = $connect->real_escape_string(trim($data['password1']));
	$password2 = $connect->real_escape_string(trim($data['password2']));

	$check_nik = $connect->query("SELECT * FROM tamu WHERE nik = '$nik'");
	$check_userame = $connect->query("SELECT * FROM tamu WHERE username_t = '$username'");
	$check_email = $connect->query("SELECT * FROM tamu WHERE 	email_t = '$email'");

	if (!$nik || !$full_name || !$address|| !$office_origin|| !$phone_number|| !$username|| !$email|| !$password1|| !$password2) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap mengisi semua form.');
		return array($_SESSION['notification'], $data);
		//return ['hasil_penjumlahan' => $penjumlahan, 'hasil_perkalian' => $perkalian];
	} else if ($check_nik->num_rows > 0) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal', 'massage' => 'NIK <strong>'.$nik.' </strong> Sudah terdaftar'); 
		return false;
	} else if ($cek_email->num_rows > 0) {
		$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Email <strong> '.$email.' </strong> Sudah Terdaftar'); 

		return false;   

	} else if ($cek_nope->num_rows > 0) {

		$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Nomor HP <strong> '.$nope.' </strong> Sudah Terdaftar'); 

		return false;   

	} else if (!is_numeric($nope)) {

		$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Nomor HP harus angka'); 

		return false;   

	}else if (strlen($nope) < 11 || strlen($nope) > 12 ) {

		$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Nomor HP tidak sesuai'); 

		return false;   

	} else if ($cek_nope2 != "08") {

		$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Nomor HP harus valid'); 

		return false;   

	} elseif (strlen($username) < 4) {

		$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Username Minimal 4 Karakter');

		return false;

	} elseif (strlen($password) < 4) {

		$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Password Minimal 4 Karakter');

		return false;

	} else if ($password <> $password2){

		$_SESSION['hasil'] = array('alert' => 'danger', 'judul' => 'Gagal', 'pesan' => 'Konfirmasi Password Baru Tidak Sesuai');

		return false;

	} 



	$hash_pass = password_hash($password, PASSWORD_DEFAULT);

	$api_key =  acak(32);

	$terdaftar = $date.$time;



	$conn->query("INSERT INTO users VALUES ('', '$nama_lengkap', '$email', '$username', '$nope', '$hash_pass', '0', '0', 'Member', 'OTP', '$api_key', 'Pendaftaran Gratis', '$terdaftar', '0','','')");

	return mysqli_affected_rows($conn);

}