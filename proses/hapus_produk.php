<?php
include '../koneksi.php';

/** @var mysqli $conn */

$id = $_GET['id'];

mysqli_query($conn, "

    DELETE FROM produk
    WHERE id='$id'

");

header("Location: ../admin/produk.php");
exit;