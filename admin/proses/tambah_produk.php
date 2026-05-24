<?php
include '../../koneksi.php';

/** @var mysqli $conn */

$nama = $_POST['nama_produk'];
$harga = $_POST['harga'];

mysqli_query($conn, "

    INSERT INTO produk(

        nama_produk,
        harga,
        status

    ) VALUES (

        '$nama',
        '$harga',
        'Aktif'

    )

");

header("Location: ../produk.php");