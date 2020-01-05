<?php

require_once "admin/config/config.php";
$query = mysqli_query($con, "SELECT * FROM tbl_pembelian JOIN tbl_pelanggan
    ON tbl_pembelian.id_pelanggan=tbl_pelanggan.id_pelanggan 
    WHERE tbl_pembelian.id_pembelian='$_GET[id]'");
$detail = $query->fetch_assoc();
?>

<?php
$idpelangganbeli = $detail["id_pelanggan"];
$idpelangganlogin = $_SESSION["pelanggan"]["id_pelanggan"];

if ($idpelangganbeli !== $idpelangganlogin) {
    echo "<script>alert('Anda tidak bisa melihat nota orang lain!');</script>";
    echo "<script>location='riwayat.php';</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Pembelian</title>
    <link rel="stylesheet" href="frontend/libraries/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="frontend/libraries/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="frontend/styles/main.css">
</head>

<body>

    <?php include "menu.php"; ?>

    <div class="konten">
        <div class="container p-5">
            <div class="container-fluid p-5">
                <div class="card shadow">
                    <div class="card-header">
                        <h3 class="text-center p-3">NOTA PEMBELIAN</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <h6>PEMBELIAN</h6>
                                    <strong>No. Pembelian: <?= $detail['id_pembelian']; ?></strong><br>
                                    Tanggal: <?= $detail['tanggal_pembelian']; ?> <br>
                                    Total Pembayaran: Rp. <?= number_format($detail['total_pembelian']); ?>
                                </div>
                                <div class="col-md-4">
                                    <h6>PELANGGAN</h6>
                                    <strong><?= $detail['nama_pelanggan']; ?></strong><br>
                                    <?= $detail['telepon_pelanggan']; ?> <br>
                                    <?= $detail['email_pelanggan']; ?>
                                </div>
                                <div class="col-md-4">
                                    <h6>PENGIRIMAN</h6>
                                    <strong><?= $detail['kabTipe']; ?>, <?= $detail['kabNama']; ?></strong><br>
                                    Alamat Lengkap: <?= $detail['alamat_pengiriman']; ?> <br>
                                    Ongkos kirim: Rp. <?= number_format($detail['tarif']); ?> <br>
                                    Estimasi: <?= $detail['estimasi']; ?> <br>
                                    Kurir: JNE
                                </div>
                            </div>

                            <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Subharga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php $query = mysqli_query($con, "SELECT * FROM tbl_pembelian_produk WHERE id_pembelian='$_GET[id]'"); ?>
                                    <?php while ($data = $query->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $data['nama']; ?></td>
                                            <td>Rp. <?= number_format($data['harga']); ?></td>
                                            <td><?= $data['jumlah']; ?></td>
                                            <td>Rp. <?= number_format($data['subharga']); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-7">
                        <div class="alert alert-info">
                            <p>Silahkan melakukan pembayaran sebesar Rp. <?= number_format($detail['total_pembelian']); ?> ke <br>
                                <strong>BANK BRI 137-0010088-3276 AN. Bismo Nugraha</strong> <br>
                                Apabila 2x24 Jam tidak bayar, pesanan dibatalkan!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include "footer.php" ?>

</body>

</html>