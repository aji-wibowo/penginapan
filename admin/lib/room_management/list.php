<?php
$page = "Daftar Kamar";
session_start();

//Load file config
require '../../../config.php';
require '../../lib/session_admin.php';
require '../../layout/header_dashboard.php';
if (isset($_POST['add_data'])) {
	$room_name = $connect->real_escape_string(filter($_POST['room_name']));
	$room_type = $connect->real_escape_string(filter($_POST['room_type']));
	$room_address = $connect->real_escape_string(filter($_POST['room_address']));
	$room_price = $connect->real_escape_string(filter($_POST['room_price']));
	$kd_lokasi = $_SESSION['admin']['kd_lokasi'];

	if (!$room_name || !$room_type || !$room_address|| !$room_price) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap mengisi semua form.');
	}else{
		if ($connect->query("INSERT INTO kamar VALUES ('','$room_name','$room_type','$room_address','$room_price','$kd_lokasi')") == true) {
			$_SESSION['notification'] = array('alert' => 'success', 'title' => 'Sukses', 'message' => 'Data berhasil ditambahkan.');
		}else{
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Fatal error!'.mysqli_error($connect));
		}
	}
}
if (isset($_POST['edit_data'])) {
	$room_name = $connect->real_escape_string(filter($_POST['room_name']));
	$room_type = $connect->real_escape_string(filter($_POST['room_type']));
	$room_address = $connect->real_escape_string(filter($_POST['room_address']));
	$room_price = $connect->real_escape_string(filter($_POST['room_price']));
	$kd_kamar = $connect->real_escape_string(filter($_POST['kd_kamar']));

	if (!$room_name || !$room_type || !$room_address|| !$room_price|| !$kd_kamar) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap mengisi semua form.');
	}else{
		if ($connect->query("UPDATE kamar SET nama_kamar = '$room_name', tipe_kamar = '$room_type', alamat_kamar = '$room_address', harga_kamar = '$room_price' WHERE kd_kamar = '$kd_kamar'") == true) {
			$_SESSION['notification'] = array('alert' => 'success', 'title' => 'Sukses', 'message' => 'Data berhasil diubah.');
		}else{
			$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Fatal error!'.mysqli_error($connect));
		}
	}
}
if (isset($_POST['delete_data'])) {
	$kd_kamar = $connect->real_escape_string(filter($_POST['kd_kamar']));
	if (!$kd_kamar) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap mengisi semua form.');
	}else{
		if ($connect->query("DELETE FROM kamar WHERE kd_kamar = '$kd_kamar'") == true) {
			$_SESSION['notification'] = array('alert' => 'success', 'title' => 'Sukses', 'message' => 'Data berhasil dihapus.');
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
											<h4 class="modal-title">Tambah Data Kamar</h4>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<form method="POST">
												<div class="input-group mb-3">
													<input type="text" name="room_name" class="form-control" placeholder="Nama Kamar">
													<div class="input-group-append">
														<div class="input-group-text">
															<span class="fa fa-door-open"></span>
														</div>
													</div>
												</div>
												<div class="input-group mb-3">
													<input type="text" name="room_type" class="form-control" placeholder="Tipe Kamar">
													<div class="input-group-append">
														<div class="input-group-text">
															<span class="fa fa-bed"></span>
														</div>
													</div>
												</div>
												<div class="input-group mb-3">
													<textarea name="room_address" class="form-control" rows="2" placeholder="Alamat Kamar ..."></textarea>
													<div class="input-group-append">
														<div class="input-group-text">
															<span class="fas fa-map-marker-alt"></span>
														</div>
													</div>
												</div>
												<div class="input-group mb-3">
													<input type="number" name="room_price" class="form-control" placeholder="Harga Kamar">
													<div class="input-group-append">
														<div class="input-group-text">
															<span class="fa fa-money-bill-wave"></span>
														</div>
													</div>
												</div>
												<p>*<small>Pada <i>harga kamar</i> input nomor saja tanpa tanda baca.</small></p>
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
							<h3 class="card-title"><?=$page?> di lokasi anda</h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>No.</th>
										<th>Nama Kamar</th>
										<th>Tipe Kamar</th>
										<th>Harga Kamar</th>
										<th>Kode Lokasi</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									$check_rooms = $connect->query("SELECT * FROM kamar a JOIN lokasi b ON a.kd_lokasi=b.kd_lokasi JOIN admin c ON c.kd_lokasi=b.kd_lokasi");
									while ($data_rooms = $check_rooms->fetch_assoc()) {
										?>  
										<tr>
											<td><?=$no?></td>
											<td><?=$data_rooms['nama_kamar']?></td>
											<td><?=$data_rooms['tipe_kamar']?></td>
											<td><?=$data_rooms['harga_kamar']?></td>
											<td><?=$data_rooms['kd_lokasi']." / ".$data_rooms['kota']?></td>
											<td>
												<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-edit-data<?=$no?>"><i class="fas fa-pen"></i></button>
												<div class="modal fade" id="modal-edit-data<?=$no?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Ubah Data Kamar #<?=$no?></h4>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<form method="POST">
																	<div class="input-group mb-3">
																		<input type="text" name="room_name" class="form-control" placeholder="Nama Kamar" value="<?=$data_rooms['nama_kamar']?>">
																		<div class="input-group-append">
																			<div class="input-group-text">
																				<span class="fa fa-door-open"></span>
																			</div>
																		</div>
																	</div>
																	<div class="input-group mb-3">
																		<input type="text" name="room_type" class="form-control" placeholder="Tipe Kamar" value="<?=$data_rooms['tipe_kamar']?>">
																		<div class="input-group-append">
																			<div class="input-group-text">
																				<span class="fa fa-bed"></span>
																			</div>
																		</div>
																	</div>
																	<div class="input-group mb-3">
																		<textarea name="room_address" class="form-control" rows="2" placeholder="Alamat Kamar ..."><?=$data_rooms['alamat_kamar']?></textarea>
																		<div class="input-group-append">
																			<div class="input-group-text">
																				<span class="fas fa-map-marker-alt"></span>
																			</div>
																		</div>
																	</div>
																	<div class="input-group mb-3">
																		<input type="number" name="room_price" class="form-control" placeholder="Harga Kamar" value="<?=$data_rooms['harga_kamar']?>">
																		<div class="input-group-append">
																			<div class="input-group-text">
																				<span class="fa fa-money-bill-wave"></span>
																			</div>
																		</div>
																	</div>
																	<input type="text" name="kd_kamar" value="<?=$data_rooms['kd_kamar']?>" hidden>
																	<p>*<small>Pada <i>harga kamar</i> input nomor saja tanpa tanda baca.</small></p>
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
												<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete-data<?=$no?>"><i class="fas fa-trash"></i></button>
												<div class="modal fade" id="modal-delete-data<?=$no?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Hapus Data Kamar #<?=$no?></h4>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<form method="POST">
																	<p>Apakah anda yakin akan menghapus data kamar no.<?=$no?>?</p>
																	<input type="text" name="kd_kamar" value="<?=$data_rooms['kd_kamar']?>" hidden>
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
										<th>Nama Kamar</th>
										<th>Tipe Kamar</th>
										<th>Harga Kamar</th>
										<th>Kode Lokasi</th>
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