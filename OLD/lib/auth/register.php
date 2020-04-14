<?php
//Nama halaman
$page = "Register";

//Start session
session_start();

//Ambil template header auth
require '../../view/auth/header_auth.php';

//Set null notifikasi
notification();

//Jika sudah ada user login terdeteksi arahkan ke halaman utama
if (isset($_SESSION['user'])) {
	header("Location: ".base_url());
} else {
	//Jika tombol register di tekan
	if (isset($_POST['register'])) {
		//Tangkap data yang di post form register
		$nik = $connect->real_escape_string(filter($_POST['nik']));
		$full_name = $connect->real_escape_string(filter($_POST['full_name']));
		$address = $connect->real_escape_string(filter($_POST['address']));
		$office_origin = $connect->real_escape_string(filter($_POST['office_origin']));
		$phone_number = $connect->real_escape_string(filter($_POST['phone_number']));
		$username = $connect->real_escape_string(trim(filter($_POST['username'])));
		$email = $connect->real_escape_string(trim(filter($_POST['email'])));
		$password1 = $connect->real_escape_string(trim(filter($_POST['password1'])));
		$password2 = $connect->real_escape_string(trim(filter($_POST['password2'])));

		//Cek data apakah sudah ada dalam database?
		$check_nik = $connect->query("SELECT * FROM tamu WHERE nik = '$nik'");
		$check_userame = $connect->query("SELECT * FROM tamu WHERE username_t = '$username'");
		$check_email = $connect->query("SELECT * FROM tamu WHERE 	email_t = '$email'");

		//Cek apakah from nik, nama lengkap, alamat, asal kantor, nomor handphone, username, email, password1, dan password 2 sudah terisi semua
		if (!$nik || !$full_name || !$address|| !$office_origin|| !$phone_number|| !$username|| !$email|| !$password1|| !$password2) {
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap mengisi semua form.');
		}

		//Jika data nik sudah ada didalam database, jika iya maka proses daftar gagal
		else if ($check_nik->num_rows > 0) {
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'NIK <strong>('.$nik.')</strong> Sudah terdaftar.'); 
		}

		//Jika data username sudah ada didalam database, jika iya maka proses daftar gagal
		else if ($check_userame->num_rows > 0) {
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Username <strong>('.$username.')</strong> Sudah terdaftar.'); 
		}

		//Jika data email sudah ada didalam database, jika iya maka proses daftar gagal
		else if ($check_email->num_rows > 0) {
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Email <strong>('.$email.')</strong> Sudah terdaftar.'); 
		}

		//Jika jumlah karakter username kurang dari 4 maka proses daftar gagal
		elseif (strlen($username) < 4) {
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Username minimal berjumlah 4 karakter.');
		}

		//Jika jumlah karakter password kurang dari 6 maka proses daftar gagal
		elseif (strlen($password1) < 6) {
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Password minimal berjumlah 6 karakter.');
		}

		//Apakah password1 dan password2 cocok? jika tidak maka proses daftar gagal
		else if ($password1 <> $password2){
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Konfirmasi password tidak cocok, mohon ketik ulang password anda.');
		}

		//Apabila semua "if" diatas terlewati maka..
		else{

			//Hash password1 menggunakan password hash bawaan php
			$password_hash = password_hash($password1, PASSWORD_DEFAULT);

			//Jika sukses memasukan data kedalam database, maka proses daftar berhasi;
			if ($conn->query("INSERT INTO tamu VALUES ('','$nik','$full_name','$address','$office_origin','$phone_number','$username','$email','$password_hash')") == true) {
				$_SESSION['notification'] = array('alert' => 'success', 'title' => 'Sukses', 'message' => 'Akun anda berhasil didaftarkan, silakan masuk dihalaman login.');
			}

			//Jika gagal
			else{
				$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Fatal error!'.$username);
			}
		} 
	}
}
?>
<div class="register-box">
	<div class="register-logo">
		<p>Register</p>
	</div>
	<?php
	if ($_SESSION['notification']['alert'] != 'null') {
		?>
		<div class="alert alert-<?=$_SESSION['notification']['alert']?>">
			<h5><?=$_SESSION['notification']['title']?>!</h5>
			<?=$_SESSION['notification']['message']?>
		</div>
		<?php
	}
	?>
	<div class="card">
		<div class="card-body register-card-body">
			<form method="POST">
				<div class="input-group mb-3">
					<input type="text" name="nik" class="form-control" placeholder="Nomor Induk Kependudukan (NIK)">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-address-card"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input type="text" name="full_name" class="form-control" placeholder="Nama Lengkap">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-id-card"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<textarea name="address" class="form-control" rows="2" placeholder="Alamat Lengkap ..."></textarea>
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-map-marker-alt"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input type="text" name="office_origin" class="form-control" placeholder="Asal Kantor">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-building"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input type="number" name="phone_number" class="form-control" placeholder="Nomor Telepon">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-phone"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input type="text" name="username" class="form-control" placeholder="Username">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-user"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input type="email" name="email" class="form-control" placeholder="Email">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-envelope"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input type="password" name="password1" class="form-control" placeholder="Password">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input type="password" name="password2" class="form-control" placeholder="Ketik ulang password">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<!-- /.col -->
					<div class="col-4">
						<button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
					</div>
					<!-- /.col -->
				</div>
			</form>

			<div class="social-auth-links text-center">
				<p>Sudah punya akun? <a href="<?=base_url()?>login/">Klik Disini</a></p>
			</div>

		</div>
		<!-- /.form-box -->
	</div><!-- /.card -->
</div>
<!-- /.register-box -->
<?php
require '../../view/auth/footer_auth.php';
?>