<?php
function get_webSettings()

{
	global $connect;
	$CallData = mysqli_query($connect, "SELECT * FROM web_settings WHERE id = '1'");
	$ThisData = mysqli_fetch_assoc($CallData);
	return $ThisData;
}

function base_url()
{
	$base_url = "http://localhost/hotel/";
	return $base_url;
}

function notification()
{
	$_SESSION['notification'] = array('alert' => 'null', 'title' => 'null', 'message' => 'null');
	return $_SESSION['notification'];
}

function filter($data)
{
	$filter = stripslashes(strip_tags(htmlspecialchars(htmlentities($data,ENT_QUOTES))));
	return $filter;
}

function set_flashdata($key, $value){
	$_SESSION[$key] = $value;
}

function set_flashdata_array($key, $array){
	$_SESSION[$key] = $array;
}

function check_flashdata($key){
	if(isset($_SESSION[$key])){
		$data = $_SESSION[$key];
		return $data;
	}
}

function get_flashdata($key){
	if(isset($_SESSION[$key])){
		$data = $_SESSION[$key];
		if($_SESSION[$key] != ''){
			$_SESSION[$key] = '';
		}
		return $data;
	}
}

function generateAllMonths(){
	for ($m=1; $m<=12; $m++) {
		$month = date('F', mktime(0,0,0,$m, 1, date('Y')));
		$months[] = $month;
	}

	return $months;
}

function js_str($s)
{
	return '"' . addcslashes($s, "\0..\37\"\\") . '"';
}

function js_array($array)
{
	$temp = array_map('js_str', $array);
	return '[' . implode(',', $temp) . ']';
}

function visualArr($array){
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

function uploadFile($file, $path){
	$targetPath = $path . $file['name'];
	if (move_uploaded_file($file['tmp_name'], $targetPath)) {
		return true;
	}

	echo $file['error'];
}

function getExtension($file){
	$exploded = explode('.', $file['name']);
	$extension = end($exploded);
	return $extension;
}

function numberFormat($number){
	return number_format($number, 0, '.', ',');
}

function getLastReservationCode($connect, $forwhat = "reservasi"){
	if($forwhat == "reservasi"){
		$rv = $connect->query("SELECT MAX(kd_reservasi) kd_reservasi FROM reservasi")->fetch_assoc();
	}else{
		$rv = $connect->query("SELECT MAX(kd_bayar) kd_bayar FROM pembayaran")->fetch_assoc();
	}
	return $rv;
}














