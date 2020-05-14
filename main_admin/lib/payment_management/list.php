<?php
$page = "Daftar Pembayaran";
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
					<h1 class="m-0 text-dark"><i class="nav-icon fas fa-hand-holding-usd"></i> <?=$page?></h1>
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
							<h3 class="card-title"><?=$page?></h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>No.</th>
										<th>Kode Bayar</th>
										<th>Kode Reservasi</th>
										<th>Nama Tamu</th>
										<th>Total Bayar</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$no = 1;
									$check_payments = $connect->query("SELECT a.kd_bayar, b.kd_reservasi, c.nama_t, b.total_bayar, a.status, c.nik, c.no_tlp, d.nama_kamar, d.tipe_kamar, d.alamat_kamar, b.cekin, b.cekout, a.foto_pembayaran, d.kd_kamar  FROM pembayaran a JOIN reservasi b ON a.kd_reservasi=b.kd_reservasi JOIN tamu c ON c.kd_tamu=b.kd_tamu JOIN kamar d ON d.kd_kamar=b.kd_kamar JOIN lokasi l ON d.kd_lokasi=l.kd_lokasi");
									while ($data_payments = $check_payments->fetch_assoc()) {
										?>  
										<tr>
											<td><?=$no?></td>
											<td><?=$data_payments['kd_bayar']?></td>
											<td><?=$data_payments['kd_reservasi']?></td>
											<td><?=$data_payments['nama_t']?></td>
											<td>Rp.<?=$data_payments['total_bayar']?></td>
											<td>
												<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-info-data<?=$no?>"><i class="fas fa-info-circle"></i></button>
												<div class="modal fade" id="modal-info-data<?=$no?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Detail Info #<?=$data_payments['kd_bayar']?></h4>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body">
																<table class="table table-bordered table-striped">
																	<tr>
																		<th>Kode Bayar</th>
																		<th><?=$data_payments['kd_bayar']?></th>
																	</tr>
																	<tr>
																		<td>Kode Reservasi</td>
																		<td><?=$data_payments['kd_reservasi']?></td>
																	</tr>
																	<tr>
																		<td>NIK / Nama Tamu</td>
																		<td><?=$data_payments['nik']?>/<?=$data_payments['nama_t']?></td>
																	</tr>
																	<tr>
																		<td>No Handphone Tamu</td>
																		<td><?=$data_payments['no_tlp']?></td>
																	</tr>
																	<tr>
																		<td>Nama Kamar</td>
																		<td><?=$data_payments['nama_kamar']?></td>
																	</tr>
																	<tr>
																		<td>Tipe Kamar</td>
																		<td><?=$data_payments['tipe_kamar']?></td>
																	</tr>
																	<tr>
																		<td>Alamat Kamar</td>
																		<td><?=$data_payments['alamat_kamar']?></td>
																	</tr>
																	<tr>
																		<td>Tanggal Check-In</td>
																		<td><?=$data_payments['cekin']?></td>
																	</tr>
																	<tr>
																		<td>Tanggal Check-Out</td>
																		<td><?=$data_payments['cekout']?></td>
																	</tr>
																	<tr>
																		<td>Status Pembayaran</td>
																		<?php
																		if ($data_payments['status'] == 0) {
																			$sts = "Belum lunas";
																		}
																		?>
																		<td><?=$sts ?></td>
																	</tr>
																	<tr>
																		<td>Bukti Pembayaran</td>
																		<td><?= isset($data_payments['foto_pembayaran']) != 'nothing' ? "<a download class='link' href='".base_url()."assets/img/pembayaran/".$data_payments['foto_pembayaran']."'>lihat bukti transfer</a>" : 'belum melakukan pembayaran' ?></td>
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
										<th>Kode Bayar</th>
										<th>Kode Reservasi</th>
										<th>Nama Tamu</th>
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
							<li>Tekan tombol <button type="button" class="btn btn-xs btn-primary"><i class="fas fa-plus btn-xs"></i> Tambah Data</button> untuk menambahkan data baru.</li>
							<li>Tekan tombol <button type="button" class="btn btn-xs btn-success"><i class="fas fa-paper-plane btn-xs"></i> Simpan</button> untuk menyimpan data.</li>
							<li>Tekan tombol <button type="button" class="btn btn-xs btn-danger"><i class="fas fa-times btn-xs"></i> Batal</button> untuk membatalkan aksi.</li>
							<li>Tekan tombol <button type="button" class="btn btn-info btn-xs"><i class="fas fa-info-circle"></i></button> untuk melihat detail data.</li>
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