<?php
session_start();
require("../config.php");
unset($_SESSION['user']);
exit(header("Location: ".base_url()."user/login/"));