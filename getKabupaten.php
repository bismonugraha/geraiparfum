<?php

require_once "admin/config/config.php";

$provinsiId = $_POST['provinsiId'];

$sql = mysqli_query($con, "SELECT * FROM tbl_kabkot WHERE provinsiId = $provinsiId");
echo '<option>Pilih Kabupaten/Kota</option>';
while ($row = mysqli_fetch_array($sql)) {
    echo '<option value="' . $row['kabId'] . '">'
        . $row['kabNama']
        . '</option>';
}
