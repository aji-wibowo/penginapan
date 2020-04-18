<?php
//************************************************
//* Mulai dibuat : 4/11/20 07:20 PM
//* Selesai : -
//************************************************
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

require('fpdf/fpdf.php');

// you may need to change mysql_report.php to find the fpdf libraries
require('mysql_report.php');

// the PDF is defined as normal, in this case a Landscape, measurements in points, A3 page.
$pdf = new PDF('L','pt','A3');
$pdf->SetFont('Arial','',10);

//Konfigurasi database
$config['db'] = array(
	'host' => 'localhost',
	'name' => 'hotel',
	'username' => 'root',
	'password' => ''
);

// should not need changing, change above instead.
$pdf->connect($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['name']);

$connect = mysqli_connect($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['name']);
if(!$connect) {
	die("Koneksi Gagal : ".mysqli_connect_error());
}

//Setting timezone dan waktu
date_default_timezone_set('Asia/Jakarta');
$date = date("Y-m-d");
$time = date("H:i:s");

//Include fungsi
include("lib/function.php");

// initalize dashboard admin
$months = generateAllMonths();

if (isset($_SESSION['admin'])) {

	$data = $connect->query("SELECT r.tgl_transaksi as tgl_transaksi FROM reservasi r JOIN pembayaran p ON r.kd_reservasi=p.kd_reservasi JOIN tamu t ON t.kd_tamu=r.kd_tamu WHERE kd_admin='".$_SESSION['admin']['kd_admin']."' AND p.status='lunas' ORDER BY tgl_transaksi desc");

	$all = $connect->query("SELECT p.status, r.tgl_transaksi as tgl_transaksi FROM reservasi r JOIN pembayaran p ON r.kd_reservasi=p.kd_reservasi JOIN tamu t ON t.kd_tamu=r.kd_tamu WHERE kd_admin='".$_SESSION['admin']['kd_admin']."' ORDER BY tgl_transaksi desc");

	while ($row = $data->fetch_assoc()) {
		$dataArray[date('F', strtotime($row['tgl_transaksi']))][] = 1;
	}

	foreach($months as $m){
		if(isset($dataArray[$m])){
			$dataChart[] = count($dataArray[$m]);
		}else{
			$dataChart[] = 0;
		}
	}


	while($r = $all->fetch_assoc()){
		$dataKotak[$r['status']][] = 1;
	}

	$dashboard['reservationCount'] = $all->num_rows;
	$dashboard['belumLunas'] = isset($dataKotak['pending']) ? count($dataKotak['pending']) : 0;
	$dashboard['expired'] = isset($dataKotak['expired']) ? count($dataKotak['expired']) : 0;
	$dashboard['lunas'] = isset($dataKotak['lunas']) ? count($dataKotak['lunas']) : 0;

}

// end initialize dashboard admin

//Ambil informasi web dari fungsi
$web_info = get_webSettings();
?>







