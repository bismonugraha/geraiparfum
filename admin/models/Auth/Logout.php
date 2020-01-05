<?php
require_once "../../config/config.php";
session_destroy();
echo "<script>window.location='" . base_url('views/Login/index.php') . "';</script>";
