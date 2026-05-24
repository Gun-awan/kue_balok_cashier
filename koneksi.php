<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_kue_balok";

date_default_timezone_set('Asia/Jakarta');

$conn = mysqli_connect($host, $user, $pass, $db);

// cek koneksi
if (!$conn) {

    die("Koneksi database gagal : " . mysqli_connect_error());

}
?>