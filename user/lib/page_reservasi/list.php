<?php
$page = "Daftar Reservasi";
session_start();

//Load file config
require '../../../config.php';
require '../../lib/session_user.php';
require '../../layout/header_dashboard.php';

if (isset($_POST['edit_data'])) {
	$kd_reservasi = $connect->real_escape_string(filter($_POST['kd_reservasi']));

	if (!$kd_reservasi) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap mengisi semua form.');
	}else{
		if(!empty($_FILES['pembayaran_photo'])){
			if(getExtension($_FILES['pembayaran_photo']) == 'jpg' || getExtension($_FILES['pembayaran_photo']) == 'png' || getExtension($_FILES['pembayaran_photo']) == 'jpeg' || getExtension($_FILES['pembayaran_photo']) == 'PNG' || getExtension($_FILES['pembayaran_photo']) == 'JPEG' || getExtension($_FILES['pembayaran_photo']) == 'JPG'){
				$path = '../../../assets/img/pembayaran/';
				if(uploadFile($_FILES['pembayaran_photo'], $path)){
					$tgl_transaksi = date('Y-m-d H:i:s');
					$lastKodeReservasi = getLastReservationCode($connect, "pembayaran");
					if($lastKodeReservasi['kd_bayar'] != ''){
						$lastKode = substr($lastKodeReservasi['kd_bayar'], -3);
					}else{
						$lastKode = 000;
					}
					$newkODE = $lastKode + 1;
					$newkODE = sprintf("%03d", $newkODE);
					$kode = date('dmyy') . $newkODE;
					$kd_bayar = 'BYR'.$kode;
					if ($connect->query("INSERT INTO pembayaran (kd_bayar, tgl_bayar, kd_reservasi, status, foto_pembayaran) VALUES ('$kd_bayar','$tgl_transaksi', '$kd_reservasi', 'pending','".$_FILES['pembayaran_photo']['name']."')") == true) {
						$_SESSION['notification'] = array('alert' => 'success', 'title' => 'Sukses', 'message' => 'Bukti bayar berhasil diupload. harap tunggu perubahan status reservasi.');
					}else{
						$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Fatal error!'.mysqli_error($connect));
					}
				}else{
					$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Fatal error! Gagal upload '. $_FILES['pembayaran_photo']['error']);
				}
			}else{
				$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'file hanya support image dengan format jpg dan png');
			}
		}
	}
}
if (isset($_POST['rating'])) {
	$rating_value = $connect->real_escape_string(filter($_POST['rating_value']));
	$testimoni = $connect->real_escape_string(filter($_POST['testimoni']));
	$kd_reservasi = $connect->real_escape_string(filter($_POST['kd_reservasi']));
	$ulas1 = $kd_reservasi.' '.$testimoni;

	if (!$rating_value || !$testimoni || !$kd_reservasi) {
		$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap mengisi semua form.');
	}else{
		if ($connect->query("INSERT INTO penilaian (nilai, ulasan) VALUES ('$rating_value','$ulas1')") == true) {
			$_SESSION['notification'] = array('alert' => 'success', 'title' => 'Sukses', 'message' => 'Data berhasil ditambahkan.');
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
									$kd_tamu1 = $_SESSION['user']['kd_tamu'];
									$check_reservation = $connect->query("SELECT * FROM reservasi a JOIN tamu b ON a.kd_tamu=b.kd_tamu JOIN kamar c ON c.kd_kamar=a.kd_kamar WHERE a.kd_tamu = $kd_tamu1");
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
												<?php
												$kd_reservasi = $data_reservations['kd_reservasi'];
												$check_bayar = $connect->query("SELECT * FROM pembayaran WHERE kd_reservasi = '$kd_reservasi'");
												$check_bayar_rows = mysqli_num_rows($check_bayar);
												if ($check_bayar_rows != 1) {
													?>
													<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal-bayar-data<?=$no?>"><i class="fas fa-money-bill-wave-alt"></i> Bayar</button>
													<div class="modal fade" id="modal-bayar-data<?=$no?>">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<h4 class="modal-title">Detail Info #<?=$data_reservations['kd_reservasi']?></h4>
																	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																		<span aria-hidden="true">&times;</span>
																	</button>
																</div>
																<div class="modal-body">
																	<form method="POST" enctype="multipart/form-data">
																		<div class="input-group mb-3">
																			<p>Upload bukti pembayaran</p>
																		</div>
																		<div class="input-group mb-3">
																			<input type="file" name="pembayaran_photo" class="form-control">
																			<div class="input-group-append">
																				<div class="input-group-text">
																					<span class="fa fa-upload"></span>
																				</div>
																			</div>
																		</div>
																		<p>*<small>Pastikan foto yang diupload benar.</small></p>
																		<input type="text" name="kd_reservasi" value="<?=$data_reservations['kd_reservasi']?>" hidden>
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
													<?php
												}else{
													?>
													<?php 
													$data = $check_bayar->fetch_assoc();
													$status = $data['status'];
													?>
													<?php if($status == 'pending'){ ?>
														<button type="button" class="btn btn-warning btn-xs"><i class="fas fa-exclamation"></i> Menunggu Pengecekan</button>
														<?php
													}elseif($status == 'lunas'){ ?>
														<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal-cetak-reservasi<?=$no?>"><i class="fas fa-eye"></i> Lihat Bukti Reservasi</button>

														<button type="button" class="btn btn-success btn-xs" value='Print' onclick='printDiv("cetakuy<?=$no?>");'><i class="fas fa-print"></i> Cetak Bukti Reservasi</button>
														<div class="modal fade" id="modal-cetak-reservasi<?=$no?>">
															<div class="modal-dialog modal-lg">
																<div class="modal-content">
																	<div class="modal-header">
																		<h4 class="modal-title">Tiket Reservasi #<?=$data_reservations['kd_reservasi']?></h4>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body" id="cetakuy<?=$no?>">
																		<div class="row">
																			<div class="col-md-4">
																				<div class="form-group">
																					<label><b>Kode Reservasi</b></label>
																					<p><?= $data_reservations['kd_reservasi'] ?></p>
																				</div>
																				<div class="form-group">
																					<label><b>Atas Nama</b></label>
																					<p><?= $data_reservations['nama_t'] ?></p>
																				</div>
																			</div>
																			<div class="col-md-4">
																				<div class="form-group">
																					<label><b>No. KTP</b></label>
																					<p><?= $data_reservations['nik'] ?></p>
																				</div>
																				<div class="form-group">
																					<label><b>Checkin</b></label>
																					<p><?= date('d M Y',strtotime($data_reservations['cekin'])) ?></p>
																				</div>
																			</div>
																			<div class="col-md-4">
																				<div class="form-group">
																					<label><b>Checkout</b></label>
																					<p><?= date('d M Y',strtotime($data_reservations['cekout'])) ?></p>
																				</div>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-12">
																				<hr>
																				<p>Data diatas adalah benar tamu dari hotel kami. Screenshot dan tunjukan kepada resepsionis kami saat melakukan checkin dan checkout. Terima kasih, selamat beristirahat.</p>
																			</div>
																		</div>
																	</div>
																</div>
																<!-- /.modal-content -->
															</div>
															<!-- /.modal-dialog -->
														</div>
													<?php	} ?>
													<?php  

													$kode = trim($data_reservations['kd_reservasi']);
													$getPenilaian = $connect->query("SELECT * FROM penilaian WHERE ulasan like '%".$kode."%'");

													if($getPenilaian->num_rows > 0){
														$nilained = 1;
													}else{
														$nilained = 0;
													}

													?>
													<?php if(strtotime($data_reservations['cekout']) < strtotime(date('d-M-Y')) && $status == 'lunas' && $nilained == 0){?>
														<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-penilaian-reservasi<?=$no?>"><i class="fas fa-star"></i> Penilaian</button>

														<div class="modal fade" id="modal-penilaian-reservasi<?=$no?>">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<h4 class="modal-title">Beri Nilai #<?=$data_reservations['kd_reservasi']?></h4>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body">
																		<form method="POST" enctype="multipart/form-data">
																			<div class="input-group mb-3">
																				<p>Beri nilai sesuai pengalaman anda menginap, masukan anda sangat berarti bagi kami.</p>
																			</div>
																			<div class="input-group mb-3">
																				<select class="form-control" name="rating_value">
																					<option value="1" selected="true">Buruk</option>
																					<option value="2" selected="true">Kurang</option>
																					<option value="3" selected="true">Cukup</option>
																					<option value="4" selected="true">Baik</option>
																					<option value="5" selected="true">Baik Sekali</option>
																				</select>
																			</div>
																			<div class="input-group mb-3">
																				<textarea name="testimoni" class="form-control" rows="2" placeholder="Ulasan..."></textarea>
																				<div class="input-group-append">
																					<div class="input-group-text">
																						<span class="fas fa-pen-square"></span>
																					</div>
																				</div>
																			</div>
																			<input type="text" name="kd_reservasi" value="<?=$data_reservations['kd_reservasi']?>" hidden>
																		</div>
																		<div class="modal-footer">
																			<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times btn-xs"></i> Batal</button>
																			<button type="submit" name="rating" class="btn btn-success"><i class="fas fa-paper-plane btn-xs"></i> Simpan</button>
																		</form>
																	</div>
																</div>
																<!-- /.modal-content -->
															</div>
															<!-- /.modal-dialog -->
														</div>
													<?php } ?>
												<?php }
												?>
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