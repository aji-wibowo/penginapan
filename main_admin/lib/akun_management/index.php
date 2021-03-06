<?php
$page = "Pengaturan Akun";
session_start();

//Load file config
require '../../../config.php';
require '../../lib/session_main_admin.php';
require '../../layout/header_dashboard.php';

if(isset($_POST['submit'])){
	if($_POST['password'] != '' && $_POST['password_baru'] != ''){

		$kd_main_admin = $_SESSION['main_admin']['kd_main_admin'];
		$dataAdmin = $connect->query("select * from main_admin where kd_main_admin='$kd_main_admin'");

		if($dataAdmin->num_rows > 0){
			$fetchedData = $dataAdmin->fetch_assoc();

			$password = $connect->real_escape_string(trim(filter($_POST['password'])));
			$password_baru = $connect->real_escape_string(trim(filter($_POST['password_baru'])));
			$password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
			$verif_pass = password_verify($password, $fetchedData['password']);

			if($verif_pass == true){
				if($connect->query("UPDATE main_admin SET password ='$password_hash' WHERE kd_main_admin='$kd_main_admin'")){
					$_SESSION['notification'] = array('alert' => 'success', 'title' => 'Success', 'message' => 'Perubahan telah disimpan!');
				}else{
					$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Failur', 'message' => 'Perubahan gagal tersimpan, silahkan coba lagi! Error : '. mysqli_error($connect));
				}
			}else{
				$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Bad Credential', 'message' => 'Password kamu salah');
			}
		}

	}else{
		$_SESSION['notification'] = array('alert' => 'info', 'title' => 'No Changes', 'message' => 'Tidak ada perubahan data');
	}
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark"><i class="nav-icon fas fa-users"></i> <?=$page?></h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active"><?=$page?></li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
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
				</div>
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Data Akun Kamu</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<form class="form" action="" method="post">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Username</label>
													<input type="text" name="username" class="form-control" value="<?= $_SESSION['main_admin']['username'] ?>" readonly="true">
												</div>
												<div class="form-group">
													<label>Password</label>
													<input type="password" name="password" class="form-control mb-2" placeholder="password saat ini">
													<input type="password" name="password_baru" class="form-control" placeholder="password baru">
													<small>isi password baru jika ingin mengganti password</small>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Domain Kantor</label>
													<input type="text" name="domain_kantor" class="form-control" readonly="true" value="<?= $_SESSION['main_admin']['domain_kantor'] ?>">
												</div>
												<div class="form-group float-right">
													<button type="submit" name="submit" class="btn btn-sm btn-success"><i class="fas fa-paper-plane btn-xs"></i> submit</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- /.card -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Informasi</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<li>Tekan tombol <button type="button" class="btn btn-sm btn-success"><i class="fas fa-paper-plane btn-xs"></i> submit</button> untuk menyimpan data.</li>
							<li>Isi password dan password baru untuk merubah password anda.</li>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
			</div>
		</div>
	</section>

</div>

<?php
require '../../layout/footer_dashboard.php';
?>