<?php
include '../koneksi.php';

/** @var mysqli $conn */

$id = $_GET['id'];
$bayar = $_GET['bayar'];

// ambil transaksi
$transaksi = mysqli_fetch_array(mysqli_query($conn, "

    SELECT *
    FROM transaksi
    WHERE id='$id'

"));

// total
$total = $transaksi['total'];

// hitung kembalian
$kembalian = $bayar - $total;

// update transaksi
mysqli_query($conn, "

    UPDATE transaksi
    SET
        status='Selesai',
        bayar='$bayar',
        kembalian='$kembalian'
    WHERE id='$id'

");

// kembali
header('Location: ../antrian.php');
exit;
?>