<?php include_once('../../header.php'); ?>
<!-- Page Heading -->
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Kategori Produk</h6>
            <div class="float-right">
                <a href="tambah.php" class="btn btn-success btn-sm"><span class="fas fa-plus"></span> Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <?php
                $query = "SELECT tbl_produk.*, tbl_kategori.* FROM tbl_produk 
                        INNER JOIN tbl_kategori ON tbl_produk.id_kategori = tbl_kategori.id_kategori";
                $query_run = mysqli_query($con, $query);
                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Kategori</th>
                            <th>Nama</th>
                            <th>Ukuran</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Deskripsi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($query_run) {
                            foreach ($query_run as $data) {
                                ?>
                                <tr>
                                    <td><?= $data['id_produk']; ?></td>
                                    <td><?= $data['nama_kategori']; ?></td>
                                    <td><?= $data['nama_produk']; ?></td>
                                    <td><?= $data['ukuran']; ?> ML</td>
                                    <td>Rp. <?= $data['harga_produk']; ?></td>
                                    <td><?= $data['stok_produk']; ?></td>
                                    <td><?= $data['deskripsi']; ?></td>
                                    <td class="text-center">
                                        <a href="edit.php?id_produk=<?= $data['id_produk']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                        <button type="submit" class="btn btn-danger btn-sm del-btn" data-idproduk="<?= $data['id_produk']; ?>" data-namaproduk="<?= $data['nama_produk']; ?>">
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