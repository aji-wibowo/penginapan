<?php
//************************************************
//* Mulai dibuat : 4/11/20 07:20 PM
//* Selesai : -
//************************************************
//error_reporting(0);

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

//Ambil informasi web dari fungsi
$web_info = get_webSettings();
?>