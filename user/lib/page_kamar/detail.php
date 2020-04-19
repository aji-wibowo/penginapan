<?php
//Nama page/halaman
$page = "Detail Kamar";

//Start session
session_start();

//Load file config
require '../../../config.php';

require '../../lib/session_user.php';

//Ambil template header dashboard
require '../../layout/header_dashboard.php';

$kd_kamar = isset($_GET['kd_kamar']);

if(isset($kd_kamar) != ''){
	$detail = $connect->query("SELECT * FROM kamar k JOIN lokasi l ON k.kd_lokasi=l.kd_lokasi WHERE k.kd_kamar='$kd_kamar'")->fetch_assoc();
}else{
	set_flashdata_array('notif', array('alert' => 'danger', 'title' => 'Something Wrond', 'message' => 'Please dont act like you are a god!'));
	header("Location: ".base_url()."user/kamar");
	die();
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
						<li class="breadcrumb-item"><a href="<?=base_url()?>user/kamar">Kamar</a></li>
						<li class="breadcrumb-item active"><?=$page?></li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

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
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title"><?= $detail['nama_kamar'] ?></h3>
						</div>
						<div class="card-body">
							<div class="img-responsive">
								<img src="<?=base_url()?>assets/img/kamar/<?=$detail['foto_kamar']?>" style="width: 100%; height: 400px;">
							</div>
							<div class="description">
								<p>Alamat : <?= $detail['alamat_kamar'] ?></p>
								<p>Kota : <?= $detail['kota'] ?></p>
								<p>Tipe Kamar : <?= $detail['tipe_kamar'] ?></p>
								<p>Harga : <?= numberFormat($detail['harga_kamar']) ?></p>
							</div>
							<div class="checkout-btn">
								<a href="<?=base_url()?>kamar/booking/<?= $detail['kd_kamar'] ?>" class="btn btn-sm btn-info" style="width: 100%">booking</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</div>




















