<?php

require_once "admin/config/config.php";

$produkData = $_POST['produkData'];

$output = '';
$sql = "SELECT tbl_galeri.*, tbl_produk.* FROM tbl_galeri 
        INNER JOIN tbl_produk ON tbl_galeri.id_produk = tbl_produk.id_produk
        WHERE id_galeri='$produkData'";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_assoc($result)){
    $output .= '
    <div class="row">
        <div class="col-md-6">
            <div style="width: 18rem;">
                <img src="admin/uploads/galeri_parfum/'.$row["foto_produk"]. '" class="card-img-top">
            </div>
        </div>
        <div class="col-md-6">
            <table class="table table-borderless">
                <tr>
                    <th>Nama</th>
                    <td>: ' . $row["nama_produk"] . '</td>
                </tr>
                <tr>
                    <th>Berat</th>
                    <td>: ' . $row["ukuran"] . ' Ml</td>
                </tr>
                <tr>
                    <th>Stok</th>
                    <td>: ' . $row["stok_produk"] . '</td>
                </tr>
                <tr>
                    <th>Harga</th>
                    <td>: Rp. ' . number_format($row["harga_produk"]) . '</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>: ' . $row["deskripsi"] . '
                    </td>
                </tr>
            </table>
        </div>
    </div>';
}
echo $output;

exit;