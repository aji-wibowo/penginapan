<?php
//************************************************
//* Mulai dibuat : 4/11/20 07:20 PM
//* Selesai : -
//************************************************
error_reporting(0);

$config['db'] = array(
	'host' => 'localhost',
	'name' => 'hotel',
	'username' => 'root',
	'password' => ''
);

$conn = mysqli_connect($config['db']['host'], $config['db']['username'], $config['db']['password'], $config['db']['name']);
if(!$conn) {
	die("Koneksi Gagal : ".mysqli_connect_error());
	}

date_default_timezone_set('Asia/Jakarta');
$date = date("Y-m-d");
$time = date("H:i:s");

require("lib/function.php");
?>