<?php
require_once '../../config/config.php';

$id_kategori = $_POST['id_kategori'];
$nama_kategori = $_POST['kategori'];
$query = mysqli_query($con, "UPDATE tbl_kategori SET nama_kategori = '$nama_kategori' WHERE id_kategori = '$id_kategori'");
