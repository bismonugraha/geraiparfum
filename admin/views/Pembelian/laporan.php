<?php include_once('../../header.php'); ?>

<?php
$ambil = mysqli_query($con, "SELECT * FROM tbl_pembelian pm LEFT JOIN tbl_pelanggan pl
    ON pm.id_pelanggan=pl.id_pelanggan WHERE status_pembelian='sukses'");
while ($data = $ambil->fetch_assoc()) {
    $semuadata[] = $data;
}

?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Pembelian</h6>
        </div>
        <div class="card-body">
            <form method="post" action="Export_pdf.php?act=export">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tglm" value="<?= $tgl_mulai; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="tgls" value="<?= $tgl_selesai; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label><br>
                        <button class="btn btn-danger" name="export">Export PDF</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($semuadata as $key => $value) : ?>
                            <?php $total += $value['total_pembelian'] ?>
                            <tr>
                                <td><?= $key + 1; ?></td>
                                <td><?= $value["nama_pelanggan"]; ?></td>
                                <td><?= $value["tanggal_pembelian"]; ?></td>
                                <td>Rp. <?= number_format($value["total_pembelian"]); ?></td>
                                <td><?= $value["status_pembelian"]; ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th colspan="2">Rp. <?= number_format($total); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('../../footer.php'); ?>