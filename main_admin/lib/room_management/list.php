<?php
$page = "Daftar Kamar";
session_start();

//Load file config
require '../../../config.php';
require '../../lib/session_main_admin.php';
require '../../layout/header_dashboard.php';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark"><i class="nav-icon fas fa-bed"></i> <?=$page?></h1>
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
											<form method="POST" enctype="multipart/form-data">
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
													<textarea name="room_description" class="form-control" rows="2" placeholder="Deskripsi Kamar ..."></textarea>
													<div class="input-group-append">
														<div class="input-group-text">
															<span class="fas fa-file-alt"></span>
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
												<div class="input-group mb-3">
													<input type="file" name="room_photo" class="form-control">
													<div class="input-group-append">
														<div class="input-group-text">
															<span class="fa fa-upload"></span>
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
										<th>Foto</th>
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
												<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-lihat-foto<?=$no?>"><i class="fas fa-images"></i></button>
												<div class="modal fade" id="modal-lihat-foto<?=$no?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Foto Kamar <b><?=$data_rooms['nama_kamar']?></b></h4>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<div class="col-md-10">
																	<div class="img-responsive">
																		<div class="card" style="padding: 5px;">
																			<div class="card-body">
																				<img src="<?= base_url() ?>assets/img/kamar/<?= $data_rooms['foto_kamar'] ?>" style="width: 100%;">
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-success" data-dismiss="modal"><i class="fas fa-check btn-xs"></i> Ok</button>
															</div>
														</div>
														<!-- /.modal-content -->
													</div>
													<!-- /.modal-dialog -->
												</div>
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
										<th>Foto</th>
									</tr>
								</tfoot>
							</table>
						</div>
						<!-- /.card-body -->
					</div>
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