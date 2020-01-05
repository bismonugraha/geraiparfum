<?php

require_once "admin/config/config.php";

session_destroy();

echo "<script>alert('Anda telah logout');</script>";
echo "<script>location='index.php';</script>";