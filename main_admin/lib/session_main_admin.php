<?php
if (isset($_SESSION['main_admin'])) {
	$sess_email = $_SESSION['main_admin']['email'];
}else{
	$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Mohon login terlebih dahulu.');
	exit(header("Location: ".base_url()."main-admin/login/"));
}
