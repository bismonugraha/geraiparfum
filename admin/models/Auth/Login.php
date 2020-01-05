<?php
require_once '../../config/config.php';

$email = mysqli_escape_string($con, $_POST['email']);
$pass = mysqli_escape_string($con, MD5($_POST['password']));
$login = @$_POST['submit'];
$vercode = @$_POST['vercode'];

if ($login) {
    $sql = mysqli_query($con, "SELECT * FROM tbl_admin WHERE email = '$email' and password = '$pass'");
    $data = mysqli_fetch_array($sql);
    $cek = mysqli_num_rows($sql);
    if ($cek > 0) {
        if ($data['level'] == "OPERATOR") {
            @$_SESSION['OPERATOR'] = $data['id'];
            @$_SESSION['level'] = $data['level'];
            @$_SESSION['nama'] = $data['nama'];
            @$_SESSION['email'] = $data['email'];
            echo "<script>window.location='" . base_url('') . "';</script>";
        } elseif ($data['level'] == "MANAJER") {
            @$_SESSION['MANAJER'] = $data['id'];
            @$_SESSION['level'] = $data['level'];
            @$_SESSION['nama'] = $data['nama'];
            @$_SESSION['email'] = $data['email'];
            echo "<script>window.location='" . base_url('') . "';</script>";
        }
    } else {
        $_SESSION['message'] = 'Username atau Password salah!';
        $_SESSION['msg_type'] = "danger";
        echo "<script>window.location='" . base_url('') . "';</script>";
    }
}
