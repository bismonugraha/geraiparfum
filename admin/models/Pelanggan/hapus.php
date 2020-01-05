<?php
require_once '../../config/config.php';

$id_pelanggan = $_POST['id_pelanggan'];
$query = mysqli_query($con, "DELETE FROM tbl_pelanggan WHERE id_pelanggan = '$id_pelanggan'");
