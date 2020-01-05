<?php include_once('../../header.php'); ?>
<!-- Page Heading -->
<!------------ Kode Otomatis Kode ---------------->
<?php
$id_galeri = $_GET['id_galeri'];
$query_run = mysqli_query($con, "SELECT * FROM tbl_galeri WHERE id_galeri='$id_galeri'");
$data = mysqli_fetch_array($query_run);
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="col-lg-12 col-lg-offset-12 col-sm-6 col-sm-offset-4">
            <h4 style="text-align: center;" class="mt-3">Tambah Data Galeri</h4>
            <div class="thumbnail">
                <form role="form" id="formInput" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-group col-md-6 has-feedback">
                            <label for="id_kategori">ID Galeri</label>
                            <input type="text" name="id_galeri" id="id_galeri" value="<?= $data['id_galeri']; ?>" class=" form-control textbox" readonly>
                            <i class="form-control-feedback"></i>
                            <span class="text-warning"></span>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label for="id_produk">Produk</label>
                            <select for="id_produk" class="form-control textbox" name="id_produk" required>
                                <option value="">Pilih Produk</option>
                                <?php
                                $sql = mysqli_query($con, "SELECT * FROM tbl_produk"); //Ambil data dari tabel produk
                                while ($data_produk = mysqli_fetch_array($sql)) { //buat perulangan
                                    if ($data_produk['id_produk'] == $data['id_produk']) {
                                        ?>
                                        <option value="<?= $data_produk['id_produk']; ?>" selected>
                                            <?= $data_produk['nama_produk']; ?></option>
                                    <?php
                                        } else {
                                            ?>
                                        <option value="<?= $data_produk['id_produk']; ?>">
                                            <?= $data_produk['nama_produk']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                            </select>
                            <i class="form-control-feedback"></i>
                            <span class="text-warning"></span>
                        </div>
                        <div class="form-group col-md-6 has-feedback">
                            <label>Upload Image</label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-secondary btn-file">
                                        Browse… <input type="file" id="foto_produk" name="foto_produk">
                                    </span>
                                </span>
                                <input type="text" class="form-control" value="<?= $data['foto_produk']; ?>" required>
                            </div>
                            <img id='img-upload' />
                        </div>
                    </div>
                    <button type=" submit" name="btn-simpan" class="btn btn-primary btn-block mb-3">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include_once('../../footer.php'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        //Menyembunyikan text-warning saat load
        $('.text-warning').hide();

        //Submit Form Validasi
        $('#formInput').submit(function(e) {
            e.preventDefault();
            var valid = true;
            var form = $(this);
            var formData = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }
            var formAction = form.attr('action');

            $(this).find('.textbox').each(function() {
                if (!$(this).val()) {
                    get_error_text(this);
                    valid = false;
                    $('html,body').animate({
                        scrollTop: 0
                    }, "slow");
                }
                if ($(this).hasClass('no-valid')) {
                    valid = false;
                    $('html,body').animate({
                        scrollTop: 0
                    }, "slow");
                }
            });
            if (valid) {
                swal({
                    title: "Konfirmasi Ubah Data",
                    text: "Data Akan di Ubah",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                }, function() { //apabila sweet alert di confirm maka akan mengirim data ke ubah.php melalui proses ajax
                    $.ajax({
                        url: "../../models/Gallery/ubah.php",
                        type: "POST",
                        data: formdata ? formdata : form.serialize(), //serialize() untuk mengambil semua data didalam form
                        processData: false,
                        contentType: false,
                        success: function() {
                            setTimeout(function() {
                                swal({
                                    title: "Data Berhasil Diubah",
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
            }
        });
    });

    //Menerapkan gaya validasi form bootstrap saat terjadi eror
    function apply_feedback_error(textbox) {
        $(textbox).addClass('no-valid'); //Menambah class no valid
        $(textbox).parent().find('.text-warning').show();
        $(textbox).closest('div').removeClass('has-success');
        $(textbox).closest('div').addClass('has-warning');
        $(textbox).parent().find('.form-control-feedback').removeClass('fas fa-check');
        $(textbox).parent().find('.form-control-feedback').addClass('fas fa-exclamation-triangle');
    }

    //untuk mendapat error teks saat textbox kosong, digunakan saat submit form dan blur fungsi
    function get_error_text(textbox) {
        $(textbox).parent().find('.text-warning').text("");
        $(textbox).parent().find('.text-warning').text("Text Box Ini Tidak Boleh Kosong");
        return apply_feedback_error(textbox);
    }

    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>