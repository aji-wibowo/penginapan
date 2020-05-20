<?php
//Nama page/halaman
$page = "Checkout Kamar";

//Start session
session_start();

//Load file config
require '../../../config.php';

require '../../lib/session_user.php';

//Ambil template header dashboard
require '../../layout/header_dashboard.php';

$kd_kamar = isset($_GET['kd_kamar']) ? $_GET['kd_kamar'] : '';

if($kd_kamar != ''){
	$detail = $connect->query("SELECT * FROM kamar k JOIN lokasi l ON k.kd_lokasi=l.kd_lokasi WHERE k.kd_kamar='".$_GET['kd_kamar']."'")->fetch_assoc();
}else{
	set_flashdata_array('notif', array('alert' => 'danger', 'title' => 'Something Wrong', 'message' => 'Please dont act like you are a god!'));
	header("Location: ".base_url()."user/kamar");
	die();
}

$submit = isset($_POST['submit']) ? $_POST['submit'] : '';

if($submit != ''){
	$cekin = $_POST['checkin'];
	$cekot = $_POST['checkout'];

	if($cekot == ''){
		set_flashdata_array('notif', array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap isi form dengan benar.'));
	}else{
		if($cekin != ''){
			$cekin = $cekin;
		}else{
			$cekin = date('d-m-Y');
		}

		echo $cekin;

		if(strtotime($cekin) > strtotime('now') || strtotime($cekot) > strtotime('now')){
			if(strtotime($cekin) > strtotime($cekot)){
				set_flashdata_array('notif', array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap mengisi tanggal dengan benar.'));
			}else{
				$lastKodeReservasi = getLastReservationCode($connect);
				$lastKode = substr($lastKodeReservasi['kd_reservasi'], -3);
				$newkODE = $lastKode + 1;
				$newkODE = sprintf("%03d", $newkODE);
				$kd_reservasi = 'RV'.date('ymd').$newkODE;
				$kd_kamar = $kd_kamar;
				$kd_tamu = $_SESSION['user']['kd_tamu'];
				$cekin = date('Y-m-d', strtotime($cekin));
				$cekot = date('Y-m-d', strtotime($cekot));
				$tgl_transaksi = date('Y-m-d H:i:s');
				$diff = strtotime($cekot) - strtotime($cekin);
				$totalBayar = round($diff / (60 * 60 * 24)) * $detail['harga_kamar'];

				$admin = $connect->query("SELECT * FROM admin WHERE kd_lokasi='".$detail['kd_lokasi']."'")->fetch_assoc();

				$kd_admin = $admin['kd_admin'];

				if($connect->query("INSERT INTO reservasi VALUES('$kd_reservasi', '$kd_tamu', '$kd_kamar', '$cekin', '$cekot', '$tgl_transaksi', '$totalBayar', '$kd_admin')")){
					set_flashdata_array('notif', array('alert' => 'success', 'title' => 'Berhasil Reservasi', 'message' => 'Silahkan lakukan bukti pembayaran!'));
					echo "<script>window.location.href='".base_url()."user/checkout/sukses'</script>";
				}else{
					set_flashdata_array('notif', array('alert' => 'danger', 'title' => 'Something Wrong', 'message' => 'Silahkan coba sekali lagi!'.mysqli_error($connect)));
				}
			}
		}else{
			set_flashdata_array('notif', array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Harap mengisi tanggal dengan benar.'));
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
							<h3 class="card-title">Nama Kamar : <?= $detail['nama_kamar'] ?></h3>
						</div>
						<div class="card-body">
							<div class="description">
								<p>Alamat : <?= $detail['alamat_kamar'] ?></p>
								<p>Kota : <?= $detail['kota'] ?></p>
								<p>Tipe Kamar : <?= $detail['tipe_kamar'] ?></p>
								<p>Harga : <?= numberFormat($detail['harga_kamar']) ?></p>
							</div>
							<hr>
							<form method="post">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Check in</label>
											<input type="date" name="checkin" class="form-control">
										</div>
										<div class="form-group">
											<label>Check out</label>
											<input type="date" name="checkout" class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Nama</label>
											<input type="text" disabled="true" value="<?= $_SESSION['user']['nama_t'] ?>" class="form-control">
										</div>
										<div class="form-group">
											<label>Email</label>
											<input type="text" disabled="true" value="<?= $_SESSION['user']['email_t'] ?>" class="form-control">
										</div>
									</div>
								</div>
								<hr>
								<div class="checkout-btn">
									<input type="submit" value="reservasi" name="submit" class="btn btn-sm btn-info" style="width: 100%"></input>
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





















