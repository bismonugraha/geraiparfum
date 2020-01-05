<?php
require_once "admin/config/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Toko Parfum</title>
    <link rel="stylesheet" href="frontend/libraries/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="frontend/libraries/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="frontend/styles/main.css">
</head>

<body>
    <?php include "menu.php"; ?>

    <div class="row mt-5 no-gutters">
        <div class="col-md-12">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="frontend/images/slide1.jpg" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="frontend/images/slide2.jpg" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="frontend/images/slide3.jpg" class="d-block w-100">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-md-2 bg-light">
            <ul class="list-group list-group-flush p-2 pt-4">
                <li class="list-group-item bg-dark text-light"> <i class="fas fa-list"></i> KATEGORI PRODUK</li>
                <?php $ambil = mysqli_query($con, "SELECT * FROM tbl_kategori"); ?>
                <?php while ($data = $ambil->fetch_assoc()) { ?>
                    <li class="list-group-item">
                        <a href="search_kategori.php?id=<?= $data['id_kategori'] ?>" class="text-dark">
                            <i class="fas fa-angle-right"></i>
                            Parfum <?= $data['nama_kategori'] ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="col-md-10">
            <h4 class="text-center font-weight-bold m-4">SEMUA PARFUM</h4>
            <div class="row mx-auto mb-2">
                <?php $ambil = mysqli_query($con, "SELECT tbl_galeri.*, tbl_produk.* FROM tbl_galeri 
                        INNER JOIN tbl_produk ON tbl_galeri.id_produk = tbl_produk.id_produk"); ?>
                <?php while ($data = $ambil->fetch_assoc()) { ?>
                    <div class="card ml-4 mr-4 mb-4" style="width: 16rem;">
                        <img src="admin/uploads/galeri_parfum/<?= $data['foto_produk']; ?>" class="card-img-top">
                        <div class="card-body bg-light text-center">
                            <h5 class="card-title"><?= $data['nama_produk']; ?></h5>
                            <span class="badge badge-primary mb-2">Stok: <?= $data['stok_produk']; ?></span>
                            <span class="badge badge-pill badge-success mb-2">Rp. <?= number_format($data['harga_produk']); ?></span>
                            <form method="POST" action="beli.php?id=<?= $data['id_galeri']; ?>">
                                <div class="input-group mb-3">
                                    <input type="number" min="1" class="form-control" name="jumlah" max="<?= $data['stok_produk']; ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-danger" name="beli"><i class="fas fa-cart-plus"></i></button>
                                    </div>
                                </div>
                            </form>
                            <button class="btn btn-light view_data" data-toggle="modal" id="<?= $data['id_galeri']; ?>">Detail</button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="galeriModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Produk</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="galeri_result"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white p-5">
        <div class="row">
            <div class="col-md-3">
                <h5>LAYANAN PELANGGAN</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white">Pusat Bantuan</a></li>
                    <li><a href="#" class="text-white">Cara Pembelian</a></li>
                    <li><a href="#" class="text-white">Pengiriman</a></li>
                    <li><a href="#" class="text-white">Pusat Bantuan</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>SOCIAL MEDIA</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white"><i class="fab fa-instagram"></i> gerai_parfumeYK</a></li>
                    <li><a href="#" class="text-white"><i class="fab fa-facebook-square"></i> Gerai Parfume</a></li>
                    <li><a href="#" class="text-white"><i class="fab fa-twitter-square"></i> Gerai_ParfumeYK</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>HUBUNGI KAMI</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white"><i class="fas fa-phone"></i> 0821-2222-8888</a></li>
                    <li><a href="#" class="text-white"><i class="fab fa-whatsapp"></i> 0867-2222-1111</a></li>
                    <li><a href="#" class="text-white"><i class="fab fa-line"></i> gerai_parfume</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>JAM OPERASIONAL</h5>
                <table class="trip-informations">
                    <tr>
                        <td width="50%">Senin-Jumat</td>
                        <td width="50%" class="text-right">
                            : 08.00 - 21.00
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">Sabtu</td>
                        <td width="50%" class="text-right">
                            : 08:00 - 18:00
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">Minggu</td>
                        <td width="50%" class="text-right">
                            : 10:00 - 18:00
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">Hari Libur</td>
                        <td width="50%" class="text-right">
                            : 08:00 - 21:00
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>

    <div class="copyright text-center text-white font-weight-bold bg-dark p-2">
        <p>Developed by Parfum Shop Copyright <i class="far fa-copyright"></i> 2019</p>
    </div>

    <?php include "footer.php" ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.view_data').click(function() {
                var produkData = $(this).attr('id');

                $.ajax({
                    url: 'detailProduk.php',
                    type: 'POST',
                    data: {
                        produkData: produkData
                    },
                    success: function(data) {
                        $('#galeri_result').html(data);

                        $('#galeriModal').modal('show');
                    }
                });
            });
        });
    </script>

</body>

</html>