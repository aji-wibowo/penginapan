<?php
$page = "Daftar Tamu";
session_start();

//Load file config
require '../../../config.php';
require '../../lib/session_admin.php';
require '../../layout/header_dashboard.php';

if (isset($_POST['delete_data'])) {
	$kd_tamu = $connect->real_escape_string(filter($_POST['kd_tamu']));
	if (!$kd_tamu) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap mengisi semua form.');
	}else{
		if ($connect->query("DELETE FROM tamu WHERE kd_tamu = '$kd_tamu'") == true) {
			$_SESSION['notification'] = array('alert' => 'success', 'title' => 'Sukses', 'message' => 'Data berhasil dihapus.');
		}else{
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Fatal error!');
		}
	}
}
if (isset($_POST['edit_password'])) {
	$guest_password1 = $connect->real_escape_string(trim(filter($_POST['guest_password1'])));
	$guest_password2 = $connect->real_escape_string(trim(filter($_POST['guest_password2'])));
	$kd_tamu = $connect->real_escape_string(filter($_POST['kd_tamu']));

	if (!$guest_password1 || !$guest_password2 || !$kd_tamu ) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap mengisi semua form.');
	}elseif ($guest_password1 <> $guest_password2) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Konfirmasi password tidak cocok, mohon ketik ulang password anda.');
	}else{
		//Hash password1 menggunakan password hash bawaan php
		$password_hash = password_hash($guest_password1, PASSWORD_DEFAULT);
		if ($connect->query("UPDATE tamu SET password_t = '$password_hash' WHERE kd_tamu = '$kd_tamu'") == true) {
			$_SESSION['notification'] = array('alert' => 'success', 'title' => 'Sukses', 'message' => 'Berhasil mengubah password akun.');
		}else{
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Fatal error!');
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
							<h3 class="card-title"><?=$page?> terdaftar</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>No.</th>
										<th>NIK</th>
										<th>Nama</th>
										<th>Asal Kantor</th>
										<th>No. Telepon</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									$check_guests = $connect->query("SELECT * FROM tamu ORDER BY kd_tamu ASC");
									while ($data_guests = $check_guests->fetch_assoc()) {
										?>  
										<tr>
											<td><?=$no?></td>
											<td><?=$data_guests['nik']?></td>
											<td><?=$data_guests['nama_t']?></td>
											<td><?=$data_guests['asal_kantor']?></td>
											<td><?=$data_guests['no_tlp']?></td>
											<td>
												<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-ubah-password<?=$no?>"><i class="fas fa-lock"></i></button>
												<div class="modal fade" id="modal-ubah-password<?=$no?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Ubah Password Tamu #<?=$no?></h4>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<form method="POST">
																	<div class="input-group mb-3">
																		<input type="password" name="guest_password1" class="form-control" placeholder="Password">
																		<div class="input-group-append">
																			<div class="input-group-text">
																				<span class="fas fa-lock"></span>
																			</div>
																		</div>
																	</div>
																	<div class="input-group mb-3">
																		<input type="password" name="guest_password2" class="form-control" placeholder="Ketik ulang password">
																		<div class="input-group-append">
																			<div class="input-group-text">
																				<span class="fas fa-lock"></span>
																			</div>
																		</div>
																	</div>
																	<input type="text" name="kd_tamu" value="<?=$data_guests['kd_tamu']?>" hidden>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times btn-xs"></i> Batal</button>
																	<button type="submit" name="edit_password" class="btn btn-success"><i class="fas fa-paper-plane btn-xs"></i> Simpan</button>
																</form>
															</div>
														</div>
														<!-- /.modal-content -->
													</div>
													<!-- /.modal-dialog -->
												</div>
												<!-- /.modal -->
												<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete-data<?=$no?>"><i class="fas fa-trash"></i></button>
												<div class="modal fade" id="modal-delete-data<?=$no?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Hapus Data Tamu #<?=$no?></h4>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<form method="POST">
																	<p>Apakah anda yakin akan menghapus data tamu <i><?=$data_guests['nik']?> / <?=$data_guests['nama_t']?></i>?</p>
																	<input type="text" name="kd_tamu" value="<?=$data_guests['kd_tamu']?>" hidden>
																</div>
																<div class="modal-footer">
																	<button type="submit" name="delete_data" class="btn btn-danger"><i class="fas fa-paper-plane btn-xs"></i> Yakin, Hapus</button>
																	<button type="button" class="btn btn-success" data-dismiss="modal"><i class="fas fa-times btn-xs"></i> Batal</button>
																</form>
															</div>
														</div>
														<!-- /.modal-content -->
													</div>
													<!-- /.modal-dialog -->
												</div>
												<!-- /.modal -->
											</td>
										</tr>
										<?php 
										$no++;
									} ?>        
								</tbody>
								<tfoot>
									<tr>
										<th>No.</th>
										<th>NIK</th>
										<th>Nama</th>
										<th>Asal Kantor</th>
										<th>No. Telepon</th>
										<th>Aksi</th>
									</tr>
								</tfoot>
							</table>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Informasi</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<li>Tekan tombol <button type="button" class="btn btn-xs btn-primary"><i class="fas fa-plus btn-xs"></i> Tambah Data</button> untuk menambahkan data baru.</li>
							<li>Tekan tombol <button type="button" class="btn btn-xs btn-success"><i class="fas fa-paper-plane btn-xs"></i> Simpan</button> untuk menyimpan data.</li>
							<li>Tekan tombol <button type="button" class="btn btn-xs btn-danger"><i class="fas fa-times btn-xs"></i> Batal</button> untuk membatalkan aksi.</li>
							<li>Tekan tombol <button type="button" class="btn btn-warning btn-xs"><i class="fas fa-pen"></i></button> untuk merubah data yang sudah ada.</li>
							<li>Tekan tombol <button type="button" class="btn btn-primary btn-xs"><i class="fas fa-lock"></i></button> untuk merubah password akun tamu.</li>
							<li>Tekan tombol <button type="button" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button> untuk menghapus data yang sudah ada.</li>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
require '../../layout/footer_dashboard.php';
?>