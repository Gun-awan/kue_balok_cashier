<?php
include '../koneksi.php';

/** @var mysqli $conn */

$id = $_GET['id'];

// ubah status
mysqli_query($conn, "

    UPDATE transaksi
    SET status='Pending'
    WHERE id='$id'

");

// kembali
header("Location: ../antrian.php");
exit;