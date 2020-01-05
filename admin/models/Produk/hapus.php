<?php
require_once '../../config/config.php';

$id_produk = $_POST['id_produk'];
$query = mysqli_query($con, "DELETE FROM tbl_produk WHERE id_produk = '$id_produk'");
