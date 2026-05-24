<?php
include '../../koneksi.php';

/** @var mysqli $conn */

$nama = $_POST['nama_topping'];
$harga = $_POST['harga'];

mysqli_query($conn, "

    INSERT INTO topping(

        nama_topping,
        harga,
        status

    ) VALUES (

        '$nama',
        '$harga',
        'Aktif'

    )

");

header("Location: ../produk.php");