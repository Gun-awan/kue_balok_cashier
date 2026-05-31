<?php
include '../koneksi.php';

/** @var mysqli $conn */

$id = $_POST['id'];
$nama = $_POST['nama_topping'];
$harga = $_POST['harga'];

mysqli_query($conn, "

    UPDATE topping
    SET
        nama_topping='$nama',
        harga='$harga'

    WHERE id='$id'

");

header("Location: ../admin/produk.php");
exit;