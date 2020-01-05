<?php include_once('../../header.php'); ?>
<!-- Page Heading -->
<!------------ Kode Otomatis Kode ---------------->
<?php
$carikode = mysqli_query($con, "SELECT id_kategori from tbl_kategori") or die(mysqli_error($con));
$datakode = mysqli_fetch_array($carikode);
$jumlah_data = mysqli_num_rows($carikode);
if ($datakode) {
    $nilaikode = substr($jumlah_data[0], 1);
    $kode = (int) $nilaikode;
    $kode = $jumlah_data + 1;
    $kode_otomatis = str_pad($kode, 1, STR_PAD_LEFT);
} else {
    $kode_otomatis = "1";
}
?>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="col-lg-12 col-lg-offset-12 col-sm-6 col-sm-offset-4">
            <h4 style="text-align: center;" class="mt-3">Tambah Data Kategori</h4>
            <div class="thumbnail">
                <form role="form" id="formInput">
                    <div class="form-group form-group-lg has-feedback">
                        <label for="id_kategori">ID Kategori</label>
                        <input type="text" name="id_kategori" id="id_kategori" value="<?= $kode_otomatis; ?>" class="form-control textbox" readonly>
                        <i class="form-control-feedback"></i>
                        <span class="text-warning"></span>
                    </div>
                    <div class="form-group form-group-lg has-feedback">
                        <label for="kategori">Kategori</label>
                        <input type="text" name="kategori" id="kategori" class="form-control textbox">
                        <i class="form-control-feedback"></i>
                        <span class="text-warning"></span>
                    </div>
                    <button type="submit" name="btn-simpan" class="btn btn-primary btn-block mb-3">Simpan</button>
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

        //untuk mengecek semua textbox tidak boleh kosong
        $('.input').each(function() {
            $(this).blur(function() { //blur function itu dijalankan saat element kehilangan fokus
                if (!$(this).val()) { //this mengacu pada textbox yang sedang fokus
                    return get_error_text(this); //function get_error_text ada dibawah
                } else {
                    $(this).removeClass('no-valid');
                    $(this).parent().find('.text-warning').hide(); //cari element dengan class text-warning dari element induk text yang sedang fokus
                    $(this).closest('div').removeClass('has-warning');
                    $(this).closest('div').addClass('has-success');
                    $(this).parent().find('.form-control-feedback').removeClass('fas fa-exclamation-triangle');
                    $(this).parent().find('.form-control-feedback').addClass('fas fa-check');
                }
            });
        });

        //Mengecek textbox Kategori Valid atau tidak
        $('#kategori').blur(function() {
            var kategori = $(this).val();
            var len = kategori.length;
            if (len > 0) { //Jika ada isinya
                if (!valid_kategori(kategori)) { //jika kategori tidak valid 
                    $(this).parent().find('.text-warning').text("");
                    $(this).parent().find('.text-warning').text("Kategori Tidak Valid");
                    return apply_feedback_error(this);
                } else {
                    if (len > 30) { //Jika karakter > 30
                        $(this).parent().find('.text-warning').text("");
                        $(this).parent().find('.text-warning').text("Maximal Karakter 30");
                        return apply_feedback_error(this);
                    }
                }
            }
        });

        //Submit Form Validasi
        $('#formInput').submit(function(e) {
            e.preventDefault();
            var valid = true;
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
                    title: "Konfirmasi Simpan Data",
                    text: "Data Akan di Simpan Ke Database",
                    type: "info",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                }, function() { //apabila sweet alert di confirm maka akan mengirim data ke simpan.php melalui proses ajax
                    $.ajax({
                        url: "../../models/Kategori/simpan.php",
                        type: "POST",
                        data: $('#formInput').serialize(), //serialize() untuk mengambil semua data didalam form
                        dataType: "html",
                        success: function() {
                            setTimeout(function() {
                                swal({
                                    title: "Data Berhasil Disimpan",
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

    //Fungsi cek kategori
    function valid_kategori(kategori) {
        var pola = new RegExp(/^[a-z A-Z]+$/);
        return pola.test(kategori);
    }

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
</script>