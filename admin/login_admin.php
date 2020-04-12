<?php
$page = "Login";

//Start session
session_start();

//Ambil template header auth
require 'layout/header_auth.php';

//Jika sudah ada user login terdeteksi arahkan ke halaman utama
if (isset($_SESSION['admin'])) {
	header("Location: ".base_url()."admin/");
} else {
	if (isset($_POST['login'])) {
		$email = $connect->real_escape_string(trim(filter($_POST['email'])));
		$password = $connect->real_escape_string(trim(filter($_POST['password'])));

		$check_user = $connect->query("SELECT * FROM admin WHERE email = '$email'");
		$check_user_rows = mysqli_num_rows($check_user);
		$data_admin = mysqli_fetch_assoc($check_user);

		$verif_pass = password_verify($password, $data_admin['password']);

		if (!$email || !$password) {
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Mohon isi semua form.');
		}else if ($check_user_rows == 0) {
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Akun tidak ditemukan.');
		}else{
			if ($check_user_rows == 1) {
				if ($verif_pass == true) {
					$_SESSION['admin'] = $data_admin;
					exit(header("Location: ".base_url()."admin/"));
				}else{
					$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Password salah.');
				}
			}
		}
	}
}
?>
<div class="login-box">
	<div class="login-logo">
		<p>Login</p>
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

			<div class="social-auth-links text-center mb-3">
				<p class="mb-1">
					<a href="forgot-password.html">Lupa Password?</a>
				</p>
				<p class="mb-0">
					Belum punya akun? <a href="<?=base_url()?>register/">Klik Disini</a>
				</p>
			</div>
			<!-- /.social-auth-links -->
		</div>
		<!-- /.login-card-body -->
	</div>
</div>
<!-- /.login-box -->
<?php
require 'layout/footer_auth.php';
?>