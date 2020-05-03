<?php
session_start();
require("../config.php");
unset($_SESSION['admin']);
exit(header("Location: ".base_url()."admin/login/"));