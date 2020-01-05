<?php
require_once "config/config.php";
if (@$_SESSION['OPERATOR'] || @$_SESSION['MANAJER']) {
    echo "<script>window.location='" . base_url('views/Dashboard/index.php') . "';</script>";
} else {
    echo "<script>window.location='" . base_url('views/Login/index.php') . "';</script>";
}
