<?php
require_once '../../config/config.php';

$id_kategori = $_POST['id_kategori'];
$nama_kategori = $_POST['kategori'];
$query = mysqli_query($con, "INSERT INTO tbl_kategori VALUES('$id_kategori','$nama_kategori')");
