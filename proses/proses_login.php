<?php
session_start();

include '../koneksi.php';

/** @var mysqli $conn */

$username = $_POST['username'];
$password = $_POST['password'];


// cek user
$user = mysqli_query($conn, "

    SELECT *
    FROM user

    WHERE username='$username'
    AND password='$password'

");

// jika ditemukan
if(mysqli_num_rows($user) > 0){

    $u = mysqli_fetch_array($user);

    // session
    $_SESSION['login'] = true;

    $_SESSION['id_user'] = $u['id'];

    $_SESSION['nama'] = $u['nama'];

    $_SESSION['role'] = $u['role'];

    // role admin
    if($u['role'] == 'admin'){

        header("Location: ../admin/dashboard.php");
        exit;

    }

    // role kasir
    if($u['role'] == 'kasir'){

        header("Location: ../index.php");
        exit;

    }

}else{

    header("Location: ../login.php?error=1");
    exit;

}
?>