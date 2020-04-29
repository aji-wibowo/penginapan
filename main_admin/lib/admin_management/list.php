<?php
$page = "Daftar Admin";
session_start();

//Load file config
require '../../../config.php';
require '../../lib/session_main_admin.php';
require '../../layout/header_dashboard.php';
if (isset($_POST['add_data'])) {
	//Tangkap data yang di post form register
	$guest_nik = $connect->real_escape_string(filter($_POST['guest_nik']));
	$guest_name = $connect->real_escape_string(filter($_POST['guest_name']));
	$guest_address = $connect->real_escape_string(filter($_POST['guest_address']));
	$guest_office_origin = $connect->real_escape_string(filter($_POST['guest_office_origin']));
	$guest_phone_number = $connect->real_escape_string(trim(filter($_POST['guest_phone_number'])));
	$guest_username = $connect->real_escape_string(trim(filter($_POST['guest_username'])));
	$guest_email = $connect->real_escape_string(trim(filter($_POST['guest_email'])));
	$guest_password1 = $connect->real_escape_string(trim(filter($_POST['guest_password1'])));
	$guest_password2 = $connect->real_escape_string(trim(filter($_POST['guest_password2'])));

	//Cek data apakah sudah ada dalam database?
	$check_nik = $connect->query("SELECT * FROM tamu WHERE nik = '$guest_nik'");
	$check_userame = $connect->query("SELECT * FROM tamu WHERE username_t = '$guest_username'");
	$check_email = $connect->query("SELECT * FROM tamu WHERE 	email_t = '$guest_email'");

	//Cek apakah from nik, nama lengkap, alamat, asal kantor, nomor handphone, username, email, password1, dan password 2 sudah terisi semua
	if (!$guest_nik || !$guest_name || !$guest_address || !$guest_office_origin || !$guest_phone_number || !$guest_username || !$guest_email || !$guest_password1 || !$guest_password2) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap mengisi semua form.');
	}

	//Jika data nik sudah ada didalam database, jika iya maka proses daftar gagal
	else if ($check_nik->num_rows > 0) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'NIK <strong>('.$guest_nik.')</strong> Sudah terdaftar.'); 
	}

	//Jika data username sudah ada didalam database, jika iya maka proses daftar gagal
	else if ($check_userame->num_rows > 0) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Username <strong>('.$guest_username.')</strong> Sudah terdaftar.'); 
	}

	//Jika data email sudah ada didalam database, jika iya maka proses daftar gagal
	else if ($check_email->num_rows > 0) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Email <strong>('.$guest_email.')</strong> Sudah terdaftar.'); 
	}

	//Jika jumlah karakter username kurang dari 4 maka proses daftar gagal
	elseif (strlen($guest_username) < 4) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Username minimal berjumlah 4 karakter.');
	}

	//Jika jumlah karakter password kurang dari 6 maka proses daftar gagal
	elseif (strlen($guest_password1) < 6) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Password minimal berjumlah 6 karakter.');
	}

	//Apakah password1 dan password2 cocok? jika tidak maka proses daftar gagal
	else if ($guest_password1 <> $guest_password2){
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Konfirmasi password tidak cocok, mohon ketik ulang password anda.');
	}

	//Apabila semua "if" diatas terlewati maka..
	else{
		//Hash password1 menggunakan password hash bawaan php
		$password_hash = password_hash($guest_password1, PASSWORD_DEFAULT);

		if ($connect->query("INSERT INTO tamu (nik, nama_t, alamat, asal_kantor, no_tlp, email_t, username_t, password_t) VALUES ('$guest_nik','$guest_name', '$guest_address', '$guest_office_origin','$guest_phone_number','$guest_email','$guest_username','$password_hash')") == true) {
			$_SESSION['notification'] = array('alert' => 'success', 'title' => 'Sukses', 'message' => 'Data berhasil ditambahkan.');
		}else{
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Fatal error!');
		}
	}
}
if (isset($_POST['edit_data'])) {
	$admin_name = $connect->real_escape_string(filter($_POST['admin_name']));
	$admin_email = $connect->real_escape_string(filter($_POST['admin_email']));
	$admin_email_real = $connect->real_escape_string(filter($_POST['admin_email_real']));
	$kd_lokasi = $connect->real_escape_string(filter($_POST['kd_lokasi']));
	$kd_admin = $connect->real_escape_string(filter($_POST['kd_admin']));

	if (!$admin_name || !$admin_email || !$kd_lokasi || !$kd_admin || !$admin_email_real) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap mengisi semua form.');
	}elseif ($admin_email != $admin_email_real) {
		$check_email = $connect->query("SELECT * FROM admin WHERE email = '$admin_email'");
		if ($check_email->num_rows > 0) {
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Email <strong>('.$admin_email.')</strong> Sudah terdaftar.'); 
		}
	}
	else{
		if ($connect->query("UPDATE admin SET nama = '$admin_name', email = '$admin_email', kd_lokasi = '$kd_lokasi' WHERE kd_admin = '$kd_admin'") == true) {
			$_SESSION['notification'] = array('alert' => 'success', 'title' => 'Sukses', 'message' => 'Data berhasil diubah.');
		}else{
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Fatal error!');
		}
	}
}
if (isset($_POST['delete_data'])) {
	$kd_admin = $connect->real_escape_string(filter($_POST['kd_admin']));
	if (!$kd_admin) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap mengisi semua form.');
	}else{
		if ($connect->query("DELETE FROM admin WHERE kd_admin = '$kd_admin'") == true) {
			$_SESSION['notification'] = array('alert' => 'success', 'title' => 'Sukses', 'message' => 'Data berhasil dihapus.');
		}else{
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Fatal error!');
		}
	}
}
if (isset($_POST['edit_password'])) {
	$admin_password1 = $connect->real_escape_string(trim(filter($_POST['admin_password1'])));
	$admin_password2 = $connect->real_escape_string(trim(filter($_POST['admin_password2'])));
	$kd_admin = $connect->real_escape_string(filter($_POST['kd_admin']));

	if (!$admin_password1 || !$admin_password2 || !$kd_admin ) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap mengisi semua form.');
	}elseif ($admin_password1 <> $admin_password1) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Konfirmasi password tidak cocok, mohon ketik ulang password anda.');
	}else{
		//Hash password1 menggunakan password hash bawaan php
		$password_hash = password_hash($admin_password1, PASSWORD_DEFAULT);
		if ($connect->query("UPDATE admin SET password = '$password_hash' WHERE kd_admin = '$kd_admin'") == true) {
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
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-data"><i class="fas fa-plus btn-xs"></i> Tambah Data</button>
							<div class="modal fade" id="modal-add-data">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="modal-title">Tambah Data Tamu</h4>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<form method="POST">
												<div class="input-group mb-3">
													<input type="text" name="guest_nik" class="form-control" placeholder="NIK (Nomor Induk Kependudukan)">
													<div class="input-group-append">
														<div class="input-group-text">
															<span class="fa fa-id-card"></span>
														</div>
													</div>
												</div>
												<div class="input-group mb-3">
													<input type="text" name="guest_name" class="form-control" placeholder="Nama Tamu">
													<div class="input-group-append">
														<div class="input-group-text">
															<span class="fa fa-user"></span>
														</div>
													</div>
												</div>
												<div class="input-group mb-3">
													<textarea name="guest_address" class="form-control" rows="2" placeholder="Alamat Lengkap ..."></textarea>
													<div class="input-group-append">
														<div class="input-group-text">
															<span class="fas fa-map-marker-alt"></span>
														</div>
													</div>
												</div>
												<div class="input-group mb-3">
													<input type="text" name="guest_office_origin" class="form-control" placeholder="Asal Kantor">
													<div class="input-group-append">
														<div class="input-group-text">
															<span class="fas fa-building"></span>
														</div>
													</div>
												</div>
												<div class="input-group mb-3">
													<input type="number" name="guest_phone_number" class="form-control" placeholder="Nomor Telepon">
													<div class="input-group-append">
														<div class="input-group-text">
															<span class="fas fa-phone"></span>
														</div>
													</div>
												</div>
												<div class="input-group mb-3">
													<input type="text" name="guest_username" class="form-control" placeholder="Username">
													<div class="input-group-append">
														<div class="input-group-text">
															<span class="fas fa-user"></span>
														</div>
													</div>
												</div>
												<div class="input-group mb-3">
													<input type="email" name="guest_email" class="form-control" placeholder="Email">
													<div class="input-group-append">
														<div class="input-group-text">
															<span class="fas fa-envelope"></span>
														</div>
													</div>
												</div>
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
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times btn-xs"></i> Batal</button>
												<button type="submit" name="add_data" class="btn btn-success"><i class="fas fa-paper-plane btn-xs"></i> Simpan</button>
											</form>
										</div>
									</div>
									<!-- /.modal-content -->
								</div>
								<!-- /.modal-dialog -->
							</div>
							<!-- /.modal -->
						</div>
						<div class="card-header">
							<h3 class="card-title"><?=$page?> terdaftar</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>No.</th>
										<th>Username</th>
										<th>Nama</th>
										<th>Email</th>
										<th>Domain Kantor</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									$check_admins = $connect->query("SELECT * FROM admin a JOIN lokasi b ON a.kd_lokasi=b.kd_lokasi");
									while ($data_admins = $check_admins->fetch_assoc()) {
										?>  
										<tr>
											<td><?=$no?></td>
											<td><?=$data_admins['username']?></td>
											<td><?=$data_admins['nama']?></td>
											<td><?=$data_admins['email']?></td>
											<td><?=$data_admins['domain_kantor']?></td>
											<td>
												<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-edit-data<?=$no?>"><i class="fas fa-pen"></i></button>
												<div class="modal fade" id="modal-edit-data<?=$no?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Ubah Data Admin #<?=$no?></h4>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<form method="POST">
																	<div class="input-group mb-3">
																		<input type="text" name="admin_name" class="form-control" placeholder="Nama Admin" value="<?=$data_admins['nama']?>">
																		<div class="input-group-append">
																			<div class="input-group-text">
																				<span class="fa fa-id-card"></span>
																			</div>
																		</div>
																	</div>
																	<div class="input-group mb-3">
																		<input type="email" name="admin_email" class="form-control" placeholder="Email Admin" value="<?=$data_admins['email']?>">
																		<div class="input-group-append">
																			<div class="input-group-text">
																				<span class="fa fa-user"></span>
																			</div>
																		</div>
																	</div>
																	<div class="form-group mb-3">
																		<label>Lokasi Admin</label>
																		<select class="form-control" name="kd_lokasi">
																			<option value="1" <?php if ($data_admins['kd_lokasi'] == 1) {
																				?>selected="true"
																			<?php } ?>>Jakarta</option>
																			<option value="2"<?php if ($data_admins['kd_lokasi'] == 2) {
																				?>selected="true"
																			<?php } ?>>Surabaya</option>
																			<option value="3"<?php if ($data_admins['kd_lokasi'] == 3) {
																				?>selected="true"
																			<?php } ?>>Bali</option>
																		</select>
																	</div>
																	<input type="text" name="admin_email_real" value="<?=$data_admins['email']?>" hidden>
																	<input type="text" name="kd_admin" value="<?=$data_admins['kd_admin']?>" hidden>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times btn-xs"></i> Batal</button>
																	<button type="submit" name="edit_data" class="btn btn-success"><i class="fas fa-paper-plane btn-xs"></i> Simpan</button>
																</form>
															</div>
														</div>
														<!-- /.modal-content -->
													</div>
													<!-- /.modal-dialog -->
												</div>
												<!-- /.modal -->
												<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-ubah-password<?=$no?>"><i class="fas fa-lock"></i></button>
												<div class="modal fade" id="modal-ubah-password<?=$no?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Ubah Password Admin #<?=$no?></h4>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<form method="POST">
																	<div class="input-group mb-3">
																		<input type="password" name="admin_password1" class="form-control" placeholder="Password">
																		<div class="input-group-append">
																			<div class="input-group-text">
																				<span class="fas fa-lock"></span>
																			</div>
																		</div>
																	</div>
																	<div class="input-group mb-3">
																		<input type="password" name="admin_password2" class="form-control" placeholder="Ketik ulang password">
																		<div class="input-group-append">
																			<div class="input-group-text">
																				<span class="fas fa-lock"></span>
																			</div>
																		</div>
																	</div>
																	<input type="text" name="kd_admin" value="<?=$data_admins['kd_admin']?>" hidden>
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
																	<p>Apakah anda yakin akan menghapus data tamu <i><?=$data_admins['username']?> / <?=$data_admins['nama']?></i>?</p>
																	<input type="text" name="kd_admin" value="<?=$data_admins['kd_admin']?>" hidden>
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
										<th>Username</th>
										<th>Nama</th>
										<th>Email</th>
										<th>Domain Kantor</th>
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