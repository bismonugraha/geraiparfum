<?php include_once('../../header.php'); ?>
<!-- Page Heading -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Pembelian</h6>
            <div class="float-right">
                <a href="tambah.php" class="btn btn-success btn-sm"><span class="fas fa-plus"></span> Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Status Pembelian</th>
                            <th>Total Pembelian</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php $query = mysqli_query($con, "SELECT tbl_pembelian.*, tbl_pelanggan.* FROM tbl_pembelian 
                        INNER JOIN tbl_pelanggan ON tbl_pembelian.id_pelanggan = tbl_pelanggan.id_pelanggan ORDER BY id_pembelian DESC"); ?>
                        <?php if ($query) {
                            foreach ($query as $data) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $data['nama_pelanggan']; ?></td>
                                    <td><?= $data['tanggal_pembelian']; ?></td>
                                    <td><?= $data['status_pembelian']; ?></td>
                                    <td>Rp. <?= number_format($data['total_pembelian']); ?></td>
                                    <td>
                                        <a href="detail.php?=detail&id=<?= $data['id_pembelian']; ?>" class="btn btn-primary">Detail</a>

                                        <?php if ($data["status_pembelian"] !== "pending") : ?>
                                            <a href="pembayaran.php?=pembayaran&id=<?= $data['id_pembelian']; ?>" class="btn btn-success">Lihat Pembayaran</a>
                                        <?php endif ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('../../footer.php'); ?>
<script type="text/javascript">
    $('.del-btn').on('click', function(e) {
        e.preventDefault();
        var self = $(this);
        var nama = $(this).attr("data-namaproduk");
        var id = $(this).attr("data-idproduk");
        swal({
            title: "Konfirmasi Hapus Data",
            text: "Hapus Data Parfum : " + nama + " ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#D9534f",
            confirmButtonText: "Yes, delete!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function() { //apabila sweet alert di confirm maka akan mengirim data ke ubah.php melalui proses ajax
            $.ajax({
                url: "<?= base_url('models/Produk/hapus.php'); ?>",
                type: 'POST',
                data: {
                    id_produk: id
                }, //serialize() untuk mengambil semua data didalam form
                success: function() {
                    setTimeout(function() {
                        swal({
                            title: "Data Berhasil Dihapus",
                            text: "Terimakasih",
                            type: "success"
                        }, function() {
                            window.location = "index.php";
                        });
                    }, 2000);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    setTimeout(function() {
                        swal("Error", "Tolong Cek Koneksi Lalu Ulangi", "error");
                    }, 2000);
                }
            });
        });
    })
</script>