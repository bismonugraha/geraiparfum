<?php
require_once '../../config/config.php';

$id_galeri = $_POST['id_galeri'];
$query = mysqli_query($con, "DELETE FROM tbl_galeri WHERE id_galeri = '$id_galeri'");
