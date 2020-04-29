<?php
//Nama page/halaman
$page = "Login Main Admin";

//Start session
session_start();

//Ambil template header auth
require 'layout/header_auth.php';

//Jika sudah ada user login terdeteksi arahkan ke halaman utama
if (isset($_SESSION['main_admin'])) {
	header("Location: ".base_url()."main-admin/");
} else {
	//Jika tombol login ditekan
	if (isset($_POST['login'])) {
		//Tangkap dan filter data post dari from login
		$email = $connect->real_escape_string(trim(filter($_POST['email'])));
		$password = $connect->real_escape_string(trim(filter($_POST['password'])));

		//Cek apakah email ada?
		$check_main_admin = $connect->query("SELECT * FROM main_admin WHERE email = '$email'");
		$check_main_admin_rows = mysqli_num_rows($check_main_admin);
		$data_main_admin = mysqli_fetch_assoc($check_main_admin);

		//Cocokan password, menggunkan password verifiy php
		$verif_pass = password_verify($password, $data_main_admin['password']);

		//Jika from email, dan password kosong maka proses login gagal
		if (!$email || !$password) {
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Mohon isi semua form.');
		}
		//Jika email admin ditemukan
		else if ($check_main_admin_rows == 1) {
			//Jika hasil dari $verif_pass true/benar maka dibuat session admin, dan arahkan ke dashboard
			if ($verif_pass == true) {
				$_SESSION['main_admin'] = $data_main_admin;
				exit(header("Location: ".base_url()."main-admin/"));
			}else{
				//Jika easil dari $verif_pass false/salah maka proses login gagal
				$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Password salah.');
			}
		}else{
			//Jika email admin tidak ditemukan
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Akun tidak ditemukan.');
		}
	}
}
?>
<div class="login-box">
	<div class="login-logo">
		<p><?=$page?></p>
	</div>
	<?php
	if (isset($_SESSION['notification']['alert'])) {
		?>
		<div class="alert alert-<?=$_SESSION['notification']['alert']?>">
			<h5><?=$_SESSION['notification']['title']?>!</h5>
			<?=$_SESSION['notification']['message']?>
		</div>
		<?php
		unset($_SESSION['notification']);
	}
	?>
	<!-- /.login-logo -->
	<div class="card">
		<div class="card-body login-card-body">
			<form method="POST">
				<div class="input-group mb-3">
					<input type="email" name="email" class="form-control" placeholder="Email">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fa fa-envelope"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input type="password" name="password" class="form-control" placeholder="Password">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-4">
						<button type="submit" name="login" class="btn btn-primary btn-block">Sign In</button>
					</div>
					<!-- /.col -->
				</div>
			</form>
			<!-- /.social-auth-links -->
		</div>
		<!-- /.login-card-body -->
	</div>
</div>
<!-- /.login-box -->
<?php
require 'layout/footer_auth.php';
?>