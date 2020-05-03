<?php
//Nama page/halaman
$page = "Menu Akun";

//Start session
session_start();

//Load file config
require '../../../config.php';

require '../../lib/session_user.php';

//Ambil template header dashboard
require '../../layout/header_dashboard.php';

function getDataUser($connect){
	$data = $connect->query("SELECT * FROM tamu WHERE username_t = '".$_SESSION['user']['username_t']."'");

	return $data;
}

$data = getDataUser($connect);

if($data->num_rows == 0){
	header("Location: ".base_url()."user");
	die();
}else{
	$row = $data->fetch_assoc();
}

if(isset($_POST['submit'])){
	$nama = $connect->real_escape_string(filter($_POST['nama']));
	$alamat = $connect->real_escape_string(filter($_POST['alamat']));
	$asal_kantor = $connect->real_escape_string(filter($_POST['asal_kantor']));
	$no_telp = $connect->real_escape_string(filter($_POST['no_telp']));
	$current_password = $connect->real_escape_string(filter($_POST['password']));
	$password_baru = $connect->real_escape_string(filter($_POST['password_baru']));

	if(!empty($current_password)){
		if(password_verify($current_password, $row['password_t'])){
			$update = $connect->query("UPDATE tamu SET nama_t='$nama', alamat='$alamat', asal_kantor='$asal_kantor', no_tlp='$no_telp', password_t='".password_hash($password_baru, PASSWORD_DEFAULT)."' WHERE kd_tamu='".$_SESSION['user']['kd_tamu']."'");
		}else{
			set_flashdata_array('notif', array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Password anda salah!'));
		}
	}else{
		$update = $connect->query("UPDATE tamu SET nama_t='$nama', alamat='$alamat', asal_kantor='$asal_kantor', no_tlp='$no_telp' WHERE kd_tamu='".$_SESSION['user']['kd_tamu']."'");
	}

	if($update){
		set_flashdata_array('notif', array('alert' => 'success', 'title' => 'Berhasil', 'message' => 'Data telah diperbarui!'));
	}else{
		set_flashdata_array('notif', array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Data telah gagal diperbarui!'. mysqli_error($connect)));
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
					<h1 class="m-0 text-dark"><?=$page?></h1>
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
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12">
						<?php
						if (!empty(check_flashdata('notif'))) {
							$notif = get_flashdata('notif');
							?>
							<div class="alert alert-<?=$notif['alert']?>">
								<h5><?=$notif['title']?>!</h5>
								<?=$notif['message']?>
							</div>
							<?php
						}
						?>
					</div>
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Info Akun Anda</h3>
						</div>
						<div class="card-body">
							<form class="form" method="post">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>NIK</label>
											<input disabled type="number" name="nik" class="form-control" value="<?= $row['nik'] ?>">
										</div>
										<div class="form-group">
											<label>Nama</label>
											<input type="text" name="nama" class="form-control" value="<?= $row['nama_t'] ?>">
										</div>
										<div class="form-group">
											<label>Alamat</label>
											<textarea class="form-control" name="alamat"><?= $row['alamat'] ?></textarea>
										</div>
										<div class="form-group">
											<label>Asal Kantor</label>
											<input type="text" name="asal_kantor" class="form-control" value="<?= $row['asal_kantor'] ?>">
										</div>
										<div class="form-group">
											<label>No. Telp</label>
											<input type="number" name="no_telp" class="form-control" value="<?= $row['no_tlp'] ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Email</label>
											<input type="email" name="email" class="form-control" value="<?= $row['email_t'] ?>" disabled>
										</div>
										<div class="form-group">
											<label>Username</label>
											<input type="text" name="username" class="form-control" value="<?= $row['username_t'] ?>" disabled>
										</div>
										<div class="form-group">
											<label>Password lama</label>
											<input type="password" name="password" class="form-control">
										</div>
										<div class="form-group">
											<label>Password baru</label>
											<input type="password" name="password_baru" class="form-control">
										</div>
										<div class="form-group text-right">
											<input type="submit" name="submit" class="btn btn-sm btn-success">
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<?php
require '../../layout/footer_dashboard.php';
?>