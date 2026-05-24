<?php
include 'koneksi.php';

/** @var mysqli $conn */

$id = $_GET['id'];

// hapus detail dulu
mysqli_query($conn, "

    DELETE FROM detail_transaksi
    WHERE transaksi_id='$id'

");

// hapus transaksi
mysqli_query($conn, "

    DELETE FROM transaksi
    WHERE id='$id'

");

// kembali
header("Location: antrian.php");
exit;
?>