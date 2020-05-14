<?php
//Nama page/halaman
$page = "Daftar Kamar";

//Start session
session_start();

//Load file config
require '../../../config.php';

require '../../lib/session_user.php';

//Ambil template header dashboard
require '../../layout/header_dashboard.php';

//initialis kamar data
function initializKamar($connect){
	$dataKamar = $connect->query("SELECT * FROM kamar k JOIN lokasi l ON k.kd_lokasi=l.kd_lokasi");
	while($row = $dataKamar->fetch_assoc()){
		$stack[] = $row;
	}

	return $stack;
}

$stack = initializKamar($connect);

if(isset($_POST['submit'])){
	if(!isset($_POST['cari_kd_lokasi'])){
		set_flashdata_array('notif', array('alert' => 'danger', 'title' => 'Pencarian Error', 'message' => 'Mohon isi lokasi'));
	}else{
		if($_POST['cari_kd_lokasi'] != ''){
			$cari_kd_lokasi = $_POST['cari_kd_lokasi'];
			if(empty($_POST['rate_from']) && empty($_POST['rate_to'])){
				unset($stack);
				$dataKamar = $connect->query("SELECT * FROM kamar k JOIN lokasi l ON k.kd_lokasi=l.kd_lokasi WHERE k.kd_lokasi='".$_POST['cari_kd_lokasi']."'");

				if($dataKamar->num_rows > 0){

					while($row = $dataKamar->fetch_assoc()){
						$stack[] = $row;
					}

					if(count($stack) == 0){
						$stack = initializKamar($connect);
						set_flashdata_array('notif', array('alert' => 'info', 'title' => 'Pencarian', 'message' => 'data tidak ada!'));
					}

				}else{
					$stack = initializKamar($connect);
					set_flashdata_array('notif', array('alert' => 'info', 'title' => 'Pencarian', 'message' => 'data tidak ada!'));
				}
			}else{
				$rateFrom = $_POST['rate_from'];
				$rateTo = $_POST['rate_to'];
				if($rateFrom > $rateTo){
					set_flashdata_array('notif', array('alert' => 'danger', 'title' => 'Pencarian Error', 'message' => 'harga rate from tidak boleh lebih tinggi dari rate to!'));
				}else{
					unset($stack);
					$dataKamar = $connect->query("SELECT * FROM kamar k JOIN lokasi l ON k.kd_lokasi=l.kd_lokasi WHERE k.kd_lokasi='".$_POST['cari_kd_lokasi']."' AND harga_kamar BETWEEN '$rateFrom' AND '$rateTo'");

					if($dataKamar->num_rows > 0){

						while($row = $dataKamar->fetch_assoc()){
							$stack[] = $row;
						}

						if(count($stack) == 0){
							$stack = initializKamar($connect);
							set_flashdata_array('notif', array('alert' => 'info', 'title' => 'Pencarian', 'message' => 'data tidak ada!'));
						}

					}else{
						$stack = initializKamar($connect);
						set_flashdata_array('notif', array('alert' => 'info', 'title' => 'Pencarian', 'message' => 'data tidak ada!'));
					}
				}
			}
		}
	}
}

//get list lokasi
$dataLokasi = $connect->query("SELECT * FROM lokasi");
while($row = $dataLokasi->fetch_assoc()){
	$stackLokasi[] = $row;
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
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Pencarian</h3>
					</div>
					<div class="card-body">
						<form method="post">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<select class="form-control" name="cari_kd_lokasi">
											<option value="">-Pilih Lokasi-</option>
											<?php if(count($stackLokasi) > 0){ foreach($stackLokasi as $l){ ?>
												<option <?= isset($cari_kd_lokasi) ? $l['kd_lokasi'] == $cari_kd_lokasi ? 'selected' : '' : '' ?> value="<?= $l['kd_lokasi'] ?>"><?= $l['kota'] ?></option>
											<?php } }?>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group text-center">
										<button type="submit" name="submit" class="btn btn-sm btn-success"><i class="fas fa-search btn-xs"></i> Cari</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<?php if(count($stack) > 0){ foreach ($stack as $row) { ?>
				<div class="col-md-3">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?= $row['nama_kamar'] ?></h3>
						</div>
						<div class="card-body">
							<div class="img-responsive">
								<img src="<?= base_url() ?>assets/img/kamar/<?= $row['foto_kamar'] ?>" style="width: 100%; height: 150px">
							</div>
							<div class="description">
								<p><b>Lokasi</b> : <?= $row['kota'] ?></p>
								<p><b>Tipe Kamar</b> : <?= $row['tipe_kamar'] ?></p>
								<p><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-detail-kamar-<?= $row['kd_kamar'] ?>"><i class="fas fa-info-circle"></i> Detail Kamar</button></p>
								<div class="modal fade" id="modal-detail-kamar-<?= $row['kd_kamar'] ?>">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title">Detail kamar <b><?= $row['nama_kamar'] ?></b></h4>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												
												<textarea style="width:100%;color:#000;" rows="8" disabled><?= $row['deskripsi_kamar'] ?></textarea>
												
											</div>
											<div class="modal-footer">
												<button type="button" data-dismiss="modal" class="btn btn-success"><i class="fas fa-check btn-xs"></i> Ok</button>
											</div>
										</div>
										<!-- /.modal-content -->
									</div>
									<!-- /.modal-dialog -->
								</div>
							</div>
							<div class="price">
								<p>Rp. <?= numberFormat($row['harga_kamar']) ?> / malam</p>
							</div>
							<?php if($row['status'] == 0){ ?>
								<a href="<?=base_url()?>user/kamar/<?= $row['kd_kamar'] ?>" class="btn btn-sm btn-success" style="width: 100%">Reservasi</a>
							<?php }else{ ?>
								<a href="#" class="btn btn-sm btn-warning" style="width: 100%">Booked</a>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } }else { ?>
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Data tidak ada.</h5>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</section>

</div>


<?php
require '../../layout/footer_dashboard.php';
?>






















