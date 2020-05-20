<?php
$page = "Daftar Reservasi";
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
					<h1 class="m-0 text-dark"><i class="nav-icon fas fa-book-open"></i> <?=$page?></h1>
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
					<div class="card">
						<div class="card-header">
							<?php
							if (check_flashdata('message') != '') {
								?>
								<div class="alert alert-danger">
									<h5>Error!</h5>
									<?=get_flashdata('message')?>
								</div>
								<?php
							}
							?>
							<form action="<?= base_url() ?>main-admin/manage-reservations/cetak" method="post">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Date from:</label>

											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="date" name="dateFrom" class="form-control float-right">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Date to:</label>

											<div class="input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="far fa-calendar-alt"></i>
													</span>
												</div>
												<input type="date" name="dateTo" class="form-control float-right">
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<button class="btn btn-sm btn-success float-right" type="submit" name="submit"><i class="fas fa-print btn-xs"></i> cetak</button>
									</div>
								</div>
							</form>
						</div>
						<div class="card-header">
							<h3 class="card-title"><?=$page?></h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>No.</th>
										<th>Kode Reservasi</th>
										<th>Tanggal Check In</th>
										<th>Tanggal Check Out</th>
										<th>Total Bayar</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									$check_reservation = $connect->query("SELECT * FROM reservasi a JOIN tamu b ON a.kd_tamu=b.kd_tamu JOIN kamar c ON c.kd_kamar=a.kd_kamar JOIN lokasi d ON c.kd_lokasi=d.kd_lokasi");
									while ($data_reservations = $check_reservation->fetch_assoc()) {
										?>  
										<tr>
											<td><?=$no?></td>
											<td><?=$data_reservations['kd_reservasi']?></td>
											<td><?=$data_reservations['cekin']?></td>
											<td><?=$data_reservations['cekout']?></td>
											<td>Rp.<?=$data_reservations['total_bayar']?></td>
											<td>
												<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-info-data<?=$no?>"><i class="fas fa-info-circle"></i></button>
												<div class="modal fade" id="modal-info-data<?=$no?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Detail Info #<?=$data_reservations['kd_reservasi']?></h4>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<table class="table table-bordered table-striped">
																	<tr>
																		<td>Kode Reservasi</td>
																		<td><?=$data_reservations['kd_reservasi']?></td>
																	</tr>
																	<tr>
																		<td>NIK / Nama Tamu</td>
																		<td><?=$data_reservations['nik']?>/<?=$data_reservations['nama_t']?></td>
																	</tr>
																	<tr>
																		<td>No Handphone Tamu</td>
																		<td><?=$data_reservations['no_tlp']?></td>
																	</tr>
																	<tr>
																		<td>Nama Kamar</td>
																		<td><?=$data_reservations['nama_kamar']?></td>
																	</tr>
																	<tr>
																		<td>Tipe Kamar</td>
																		<td><?=$data_reservations['tipe_kamar']?></td>
																	</tr>
																	<tr>
																		<td>Alamat Kamar</td>
																		<td><?=$data_reservations['alamat_kamar']?></td>
																	</tr>
																	<tr>
																		<td>Tanggal Check-In</td>
																		<td><?=$data_reservations['cekin']?></td>
																	</tr>
																	<tr>
																		<td>Tanggal Check-Out</td>
																		<td><?=$data_reservations['cekout']?></td>
																	</tr>
																</table>
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
										<th>Kode Reservasi</th>
										<th>Tanggal Check In</th>
										<th>Tanggal Check Out</th>
										<th>Total Bayar</th>
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
							<li>Tekan tombol <button type="button" class="btn btn-info btn-xs"><i class="fas fa-info-circle"></i></button> untuk melihat detail data.</li>
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