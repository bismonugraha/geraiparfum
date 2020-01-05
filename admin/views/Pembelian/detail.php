<?php

include_once('../../header.php');

$query = mysqli_query($con, "SELECT * FROM tbl_pembelian JOIN tbl_pelanggan
                     ON tbl_pembelian.id_pelanggan=tbl_pelanggan.id_pelanggan 
                     WHERE tbl_pembelian.id_pembelian='$_GET[id]'");
$detail = $query->fetch_assoc();
?>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Pembelian</h6>
        </div>
        <div class="card-body">
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
                    Estimasi: <?= $detail['estimasi']; ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php $query = mysqli_query($con, "SELECT * FROM tbl_pembelian_produk JOIN tbl_produk
                        ON tbl_pembelian_produk.id_produk=tbl_produk.id_produk WHERE
                        tbl_pembelian_produk.id_pembelian='$_GET[id]'"); ?>
                        <?php while ($data = $query->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $data['nama_produk']; ?></td>
                                <td>Rp. <?= number_format($data['harga_produk']); ?></td>
                                <td><?= $data['jumlah']; ?></td>
                                <td>Rp. <?= number_format($data['harga_produk'] * $data['jumlah']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('../../footer.php'); ?>