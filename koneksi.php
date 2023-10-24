<?php
$con = mysqli_connect("localhost", "root", "", "toko_online");

//check koneksi
if (mysqli_connect_errno()){
    echo "gagal terhubung dengan sql" . mysqli_connect_error();
    exit();

}

?>