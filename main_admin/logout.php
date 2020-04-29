<?php
session_start();
require("../config.php");
unset($_SESSION['main_admin']);
exit(header("Location: ".base_url()."main-admin/login/"));