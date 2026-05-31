<?php
include 'koneksi.php';

$token = $_GET['token'];

// transaksi
$t = mysqli_fetch_array(mysqli_query($conn, "

    SELECT *
    FROM transaksi
    WHERE token='$token'

"));

if(!$t){

    die('Struk tidak ditemukan');

}

// ambil id transaksi dari token
$id = $t['id'];

// detail
$detail = mysqli_query($conn, "

    SELECT
        detail_transaksi.*,
        produk.nama_produk,
        produk.harga,
        topping.nama_topping,
        topping.harga as harga_topping

    FROM detail_transaksi

    LEFT JOIN produk
    ON detail_transaksi.produk_id = produk.id

    LEFT JOIN topping
    ON detail_transaksi.topping_id = topping.id

    WHERE transaksi_id='$id'

");
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<title>Struk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    font-family: monospace;
    background:white;
}

.struk{
    max-width:350px;
    margin:auto;
    padding:20px;
}

.line{
    border-top:1px dashed #000;
    margin:10px 0;
}

@media print{

    .no-print{
        display:none;
    }

}

</style>

</head>
<body>

<div class="struk">

    <div class="text-center">

        <h5>KUE BALOK</h5>

        <small>
            Struk Pembelian
        </small>

    </div>

    <div class="line"></div>

    <div>

        No :
        #<?php echo $t['id']; ?>

        <br>

        Customer :
        <?php echo ucwords($t['nama_customer']); ?>

        <br>

        Tanggal :
        <?php echo date('d-m-Y H:i', strtotime($t['tanggal'])); ?>

    </div>

    <div class="line"></div>

    <?php while($d = mysqli_fetch_array($detail)){ ?>

    <?php

    // harga topping
    $hargaTopping = $d['harga_topping'] ?? 0;

    // nama topping
    $namaTopping = $d['nama_topping'] ?: '-';

    ?>

    <!-- ITEM -->
    <div style="margin-bottom:15px;">

        <!-- NAMA PRODUK -->
        <div style="display:flex; justify-content:space-between;">

            <span>
                <?php echo $d['nama_produk']; ?>
            </span>

            <!-- HARGA PORSI -->
            <span>
                Rp <?php echo number_format($d['harga']); ?>
            </span>

        </div>

        <!-- COKLAT -->
        <div style="margin-top:4px;">
            Coklat : <?php echo $d['qty_coklat']; ?>
        </div>

        <!-- MATCHA -->
        <div>
            Matcha : <?php echo $d['qty_matcha']; ?>
        </div>

        <!-- TOPPING -->
        <div style="display:flex; justify-content:space-between;">

            <span>
                Topping : <?php echo $namaTopping; ?>
            </span>

            <!-- HARGA TOPPING -->
            <span>

                <?php
                if($hargaTopping > 0){
                    echo 'Rp ' . number_format($hargaTopping);
                }else{
                    echo '-';
                }
                ?>

            </span>

        </div>
        <hr class="mb-0 mt-0">

        <!-- SUBTOTAL -->
        <div style="text-align:right; margin-top:2px; margin-bottom: 5px; font-weight:bold;">

            Rp <?php echo number_format($d['subtotal']); ?>

        </div>

    </div>

<?php } ?>

    <div class="line"></div>

    <div class="d-flex justify-content-between">

        <strong>Total</strong>

        <strong>
            Rp <?php echo number_format($t['total']); ?>
        </strong>

    </div>

    <div class="d-flex justify-content-between">

        <span>Bayar</span>

        <span>
            Rp <?php echo number_format($t['bayar']); ?>
        </span>

    </div>

    <div class="d-flex justify-content-between">

        <span>Kembalian</span>

        <span>
            Rp <?php echo number_format($t['kembalian']); ?>
        </span>

    </div>

    <div class="line"></div>

    <div class="text-center mt-3">

        Terima kasih 🙏

    </div>

    <div class="text-center mt-3 no-print">

        <button
            onclick="window.print()"
            class="btn btn-dark btn-sm"
        >
            Print
        </button>

    </div>

</div>

</body>
</html>