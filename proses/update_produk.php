<?php
include '../koneksi.php';

/** @var mysqli $conn */

$id = $_POST['id'];
$nama = $_POST['nama_produk'];
$harga = $_POST['harga'];

mysqli_query($conn, "

    UPDATE produk
    SET
        nama_produk='$nama',
        harga='$harga'

    WHERE id='$id'

");

header("Location: ../admin/produk.php");
exit;