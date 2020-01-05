<?php include_once('../../header.php'); ?>
<!-- Page Heading -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Pelanggan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Email</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php $query = mysqli_query($con, "SELECT * FROM tbl_pelanggan"); ?>
                        <?php if ($query) {
                            foreach ($query as $data) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $data['email_pelanggan']; ?></td>
                                    <td><?= $data['nama_pelanggan']; ?></td>
                                    <td><?= $data['telepon_pelanggan']; ?></td>
                                    <td>
                                        <button type="submit" class="btn btn-danger btn-sm del-btn" data-idpelanggan="<?= $data['id_pelanggan']; ?>" data-namapelanggan="<?= $data['nama_pelanggan']; ?>">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
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
        var nama = $(this).attr("data-namapelanggan");
        var id = $(this).attr("data-idpelanggan");
        swal({
            title: "Konfirmasi Hapus Data",
            text: "Hapus Data Parfum : " + nama + " ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#D9534f",
            confirmButtonText: "Yes, delete!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function() {
            $.ajax({
                url: "<?= base_url('models/Pelanggan/hapus.php'); ?>",
                type: 'POST',
                data: {
                    id_pelanggan: id
                },
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