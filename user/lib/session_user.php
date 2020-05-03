<?php
if (isset($_SESSION['user'])) {
	$sess_email = $_SESSION['user']['email_t'];
}else{
	$_SESSION['notification'] = array('alert' => 'danger', 'title' => 'Gagal', 'message' => 'Mohon login terlebih dahulu.');
	exit(header("Location: ".base_url()."user/login/"));
}
