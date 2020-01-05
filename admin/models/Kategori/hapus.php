<?php
require_once '../../config/config.php';

$id_kategori = $_POST['id_kategori'];
$query = mysqli_query($con, "DELETE FROM tbl_kategori WHERE id_kategori = '$id_kategori'");
