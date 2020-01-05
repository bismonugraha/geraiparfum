<?php include_once('../../header.php'); ?>
<!-- Page Heading -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Gallery Produk</h6>
            <div class="float-right">
                <a href="tambah.php" class="btn btn-success btn-sm"><span class="fas fa-plus"></span> Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php
                $query = "SELECT tbl_produk.*, tbl_galeri.* FROM tbl_galeri 
                        INNER JOIN tbl_produk ON tbl_galeri.id_produk = tbl_produk.id_produk";
                $query_run = mysqli_query($con, $query);
                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Produk</th>
                            <th>Gambar</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($query_run) {
                            foreach ($query_run as $data) {
                                ?>
                                <tr>
                                    <td><?= $data['id_galeri']; ?></td>
                                    <td><?= $data['nama_produk']; ?></td>
                                    <td><img src="../../uploads/galeri_parfum/<?= $data['foto_produk']; ?>" alt="Foto Produk" width="75px" height="75px"></td>
                                    <td class="text-center">
                                        <a href="edit.php?id_galeri=<?= $data['id_galeri']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                        <button type="submit" class="btn btn-danger btn-sm del-btn" data-idgaleri="<?= $data['id_galeri']; ?>" data-namaproduk="<?= $data['nama_produk']; ?>">
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
        var nama = $(this).attr("data-namaproduk");
        var id = $(this).attr("data-idgaleri");
        swal({
            title: "Konfirmasi Hapus Data",
            text: "Hapus Gambar Produk : " + nama + " ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#D9534f",
            confirmButtonText: "Yes, delete!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function() { //apabila sweet alert di confirm maka akan mengirim data ke ubah.php melalui proses ajax
            $.ajax({
                url: "<?= base_url('models/Gallery/hapus.php'); ?>",
                type: 'POST',
                data: {
                    id_galeri: id
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