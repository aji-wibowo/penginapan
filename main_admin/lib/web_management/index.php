<?php
$page = "Pengaturan Akun";
session_start();

//Load file config
require '../../../config.php';
require '../../lib/session_main_admin.php';
require '../../layout/header_dashboard.php';

if (isset($_POST['edit_data'])) {
	$web_name = $connect->real_escape_string(filter($_POST['web_name']));
	$web_title = $connect->real_escape_string(filter($_POST['web_title']));
	$web_description = $connect->real_escape_string(filter($_POST['web_description']));

	if (!$web_name || !$web_title || !$web_description) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap mengisi semua form.');
	}else{
		if ($connect->query("UPDATE web_settings SET web_name = '$web_name', web_title = '$web_title', web_description = '$web_description' WHERE id = '1'") == true) {
			$_SESSION['notification'] = array('alert' => 'success', 'title' => 'Sukses', 'message' => 'Data berhasil diubah.');
		}else{
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Fatal error!'.mysqli_error($connect));
		}
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
												<div class="input-group mb-3">
													<input type="text" name="web_name" class="form-control" placeholder="Nama Web" value="<?=$web_info['web_name']?>">
													<div class="input-group-append">
														<div class="input-group-text">
															<span class="fa fa-globe"></span>
														</div>
													</div>
												</div>

												<div class="input-group mb-3">
													<input type="text" name="web_title" class="form-control" placeholder="Judul Web" value="<?=$web_info['web_title']?>">
													<div class="input-group-append">
														<div class="input-group-text">
															<span class="fa fa-tag"></span>
														</div>
													</div>
												</div>

												<div class="input-group mb-3">
													<textarea name="web_description" class="form-control" rows="2" placeholder="Deskripsi Website ..."><?=$web_info['web_description']?></textarea>
													<div class="input-group-append">
														<div class="input-group-text">
															<span class="fas fa-pen-alt"></span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<button type="submit" name="edit_data" class="btn btn-success"><i class="fas fa-paper-plane btn-xs"></i> Simpan</button>
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