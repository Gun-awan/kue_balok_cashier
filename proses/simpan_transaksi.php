<?php

include '../koneksi.php';

/** @var mysqli $conn */

$nama_customer = $_POST['nama_customer'];
$total = $_POST['total'];
$token = md5(uniqid());

// simpan transaksi
mysqli_query($conn, "
    INSERT INTO transaksi
    (
        nama_customer,
        total,
        status,
        token
    )

    VALUES

    (
        '$nama_customer',
        '$total',
        'Antrian',
        '$token'
    )

");

// ambil id transaksi
$transaksi_id = mysqli_insert_id($conn);

// ambil array
$produk = $_POST['produk_id'];
$harga = $_POST['harga'];

$qty_coklat = $_POST['qty_coklat'];
$qty_matcha = $_POST['qty_matcha'];

$topping = $_POST['topping_id'];

$harga_topping = $_POST['harga_topping'];

// loop detail
for($i=0; $i<count($produk); $i++){

    $produk_id = $produk[$i];

    $harga_produk = $harga[$i];

    $coklat = $qty_coklat[$i];
    $matcha = $qty_matcha[$i];

    $topping_id = $topping[$i];

    $hargaTop = $harga_topping[$i];

    // subtotal
    $subtotal = $harga_produk + $hargaTop;

    mysqli_query($conn, "
    
        INSERT INTO detail_transaksi
        (
            transaksi_id,
            produk_id,
            topping_id,

            qty_coklat,
            qty_matcha,

            harga_produk,
            subtotal
        )

        VALUES

        (
            '$transaksi_id',
            '$produk_id',
            '$topping_id',

            '$coklat',
            '$matcha',

            '$harga_produk',
            '$subtotal'
        )

    ");

}

// kembali
header("Location: ../index.php?success=1");