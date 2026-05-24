<?php
include '../koneksi.php';

/** @var mysqli $conn */

$id_transaksi = $_POST['id'];

$detail_id     = $_POST['detail_id'];
$produk_id     = $_POST['produk_id'];
$qty_coklat    = $_POST['qty_coklat'];
$qty_matcha    = $_POST['qty_matcha'];
$topping_id    = $_POST['topping_id'];

// hapus detail lama dulu
mysqli_query($conn, "
    DELETE FROM detail_transaksi
    WHERE transaksi_id='$id_transaksi'
");

// total transaksi
$total = 0;

// looping simpan ulang
for($i=0; $i<count($produk_id); $i++){

    $produk = mysqli_fetch_array(mysqli_query($conn,"
    
        SELECT *
        FROM produk
        WHERE id='".$produk_id[$i]."'
    
    "));

    $harga_produk = $produk['harga'];

    // topping
    $harga_topping = 0;

    if($topping_id[$i] != ''){

        $top = mysqli_fetch_array(mysqli_query($conn,"
        
            SELECT *
            FROM topping
            WHERE id='".$topping_id[$i]."'
        
        "));

        $harga_topping = $top['harga'];
    }

    $subtotal = $harga_produk + $harga_topping;

    $total += $subtotal;

    mysqli_query($conn,"
    
        INSERT INTO detail_transaksi(
            transaksi_id,
            produk_id,
            topping_id,
            qty_coklat,
            qty_matcha,
            subtotal
        ) VALUES (
            '$id_transaksi',
            '".$produk_id[$i]."',
            '".$topping_id[$i]."',
            '".$qty_coklat[$i]."',
            '".$qty_matcha[$i]."',
            '$subtotal'
        )
    
    ");
}

// update total transaksi
mysqli_query($conn, "

    UPDATE transaksi
    SET total='$total'
    WHERE id='$id_transaksi'

");

// redirect
header("Location: ../antrian.php");
exit;