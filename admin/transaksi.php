<?php
include '../koneksi.php';

session_start();

if(!isset($_SESSION['login'])){

    header("Location: login.php");
    exit;

}

if($_SESSION['role'] != 'admin'){

    header("Location: ../index.php");
    exit;

}

/** @var mysqli $conn */

// tanggal filter
$tanggal_dari = isset($_GET['tanggal_dari'])
    ? $_GET['tanggal_dari']
    : date('Y-m-d');

$tanggal_sampai = isset($_GET['tanggal_sampai'])
    ? $_GET['tanggal_sampai']
    : date('Y-m-d');

// ambil transaksi selesai
$transaksi = mysqli_query($conn, "

    SELECT *
    FROM transaksi

    WHERE status='Selesai'

    AND DATE(tanggal)
    BETWEEN '$tanggal_dari'
    AND '$tanggal_sampai'

    ORDER BY id DESC

");

// total pendapatan
$totalPendapatan = mysqli_fetch_array(mysqli_query($conn, "

    SELECT SUM(total) as total
    FROM transaksi

    WHERE status='Selesai'

AND DATE(tanggal)
BETWEEN '$tanggal_dari'
AND '$tanggal_sampai'

"));

$totalHariIni = $totalPendapatan['total'] ?: 0;

// total transaksi
$totalTransaksi = mysqli_num_rows($transaksi);

?>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Transaksi</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        /* CONTAINER */
        .dashboard-container {

            max-width: 500px;

            margin: auto;

            /* padding: 15px; */

        }

        /* BOX */
        .dashboard-box {

            background: white;

            /* border-radius: 35px; */

            padding: 20px;

            min-height: 95vh;

            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);

        }

        .header-dashboard {

            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 20px;

        }

        .header-left {

            display: flex;
            align-items: center;

            gap: 12px;

        }

        .btn-menu {

            width: 42px;
            height: 42px;

            border: none;

            border-radius: 14px;

            background: #f4f4f4;

            font-size: 22px;

        }

        .container-app {

            max-width: 500px;
            margin: auto;

            padding: 15px;

        }

        /* HEADER */
        .header-page {

            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 15px;

        }

        /* CARD TOTAL */
        .card-total {

            background: white;

            border-radius: 25px;

            padding: 20px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            margin-bottom: 15px;

            border: 2px solid #0d8039;

        }

        .icon-box {

            width: 55px;
            height: 55px;

            border-radius: 15px;

            background: #d4f5df;

            display: flex;
            justify-content: center;
            align-items: center;

            font-size: 24px;

            color: #0d6efd;

        }

        .divider {

            width: 1px;
            height: 60px;

            background: #ddd;

        }

        /* FILTER */
        .filter-box {

            /* background: #00be19; */

            border-radius: 18px;

            padding: 15px;

            margin-bottom: 15px;

        }

        /* LIST */
        .list-transaksi {

            display: flex;
            flex-direction: column;

            gap: 12px;

        }

        .item-transaksi {

            background: white;

            border-radius: 18px;

            padding: 15px;

            border: 1px solid #198d19;

        }

        .tanggal {

            font-size: 12px;
            color: #777;
        }

        .harga {

            color: #198754;
            font-weight: bold;
        }

        .modal-custom {

            height: 90vh;

            display: flex;
            flex-direction: column;

        }

        .modal-body-scroll {

            flex: 1;

            overflow-y: auto;

        }
    </style>

</head>

<body>

    <div class="dashboard-container">

        <div class="dashboard-box">
            <!-- <div class="container-app"> -->

            <!-- HEADER -->

            <div class="header-dashboard">

                <!-- LEFT -->
                <div class="header-left">

                    <button class="btn-menu">
                        <i class="bi-receipt-cutoff"></i>
                    </button>

                    <div>

                        <strong style="font-size:18px;">
                            Transaksi
                        </strong>

                        <div class="small text-muted">

                            Detail & Riwayat Transaksi

                        </div>

                    </div>

                </div>

                <!-- RIGHT -->
                <div>

                    <a
                        href="dashboard.php"
                        class="btn btn-sm btn-secondary">
                        Kembali
                    </a>

                </div>

            </div>

            <!-- CARD TOTAL -->
            <div class="card-total">

                <!-- KIRI -->
                <div class="d-flex align-items-center gap-3">

                    <div class="icon-box text-success">
                        <i class="bi bi-cash-stack"></i>
                    </div>

                    <div>

                    <small class="text-muted">
                            Pendapatan :
                        </small>

                        <h4 class="mb-0 text-success">
                            Rp <?php echo number_format($totalHariIni); ?>
                        </h4>

                        

                    </div>

                </div>

                <!-- GARIS -->
                <div class="divider"></div>

                <!-- KANAN -->
                <div class="text-center">

                    <h3 class="mb-0 text-success">
                        <?php echo $totalTransaksi; ?>
                    </h3>

                    <small class="text-muted">
                        Transaksi
                    </small>

                </div>

            </div>

            <!-- FILTER -->
            <form>

                <div class="filter-box bg-success">

                    <div class="row g-2">

                        <!-- DARI -->
                        <div class="col-6">

                            <label class="small mb-1 text-white">
                                Dari
                            </label>

                            <input
                                type="date"
                                name="tanggal_dari"
                                class="form-control"
                                value="<?php echo $tanggal_dari; ?>">

                        </div>

                        <!-- SAMPAI -->
                        <div class="col-6">

                            <label class="small mb-1 text-white">
                                Sampai
                            </label>

                            <input
                                type="date"
                                name="tanggal_sampai"
                                class="form-control"
                                value="<?php echo $tanggal_sampai; ?>">

                        </div>

                    </div>

                    <!-- BUTTON -->
                    <button class="btn btn-light w-100 mt-3">

                        Filter Transaksi

                    </button>

                </div>

            </form>

            <!-- LIST -->
            <div class="list-transaksi">

                <?php while ($t = mysqli_fetch_array($transaksi)) { ?>

                    <div class="item-transaksi">

                        <div class="d-flex justify-content-between align-items-start">

                            <!-- KIRI -->
                            <div>

                                <strong>
                                    <?php echo ucwords($t['nama_customer']); ?>
                                </strong>

                                <div class="d-flex align-items-center gap-2 mt-1">

                                    <div class="tanggal">

                                        <?php
                                        echo date(
                                            'd M Y H:i',
                                            strtotime($t['tanggal'])
                                        );
                                        ?>

                                    </div>



                                </div>

                            </div>

                            <div>
                                <!-- KANAN -->
                                <div class="harga">

                                    Rp <?php echo number_format($t['total']); ?>

                                </div>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <!-- DETAIL -->
                                    <span
                                        class="badge bg-primary"
                                        style="cursor:pointer;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detail<?php echo $t['id']; ?>">
                                        Detail
                                    </span>
                                </div>
                            </div>

                        </div>

                    </div>

                    <?php

                    $detail = mysqli_query($conn, "

    SELECT
    detail_transaksi.*,

    produk.nama_produk,
    produk.harga AS harga_produk,

    topping.nama_topping,
    topping.harga AS harga_topping

FROM detail_transaksi

LEFT JOIN produk
ON detail_transaksi.produk_id = produk.id

LEFT JOIN topping
ON detail_transaksi.topping_id = topping.id

WHERE transaksi_id='".$t['id']."'

");

                    ?>

                    <!-- MODAL DETAIL -->
                    <div
                        class="modal fade"
                        id="detail<?php echo $t['id']; ?>">

                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

                            <div class="modal-content rounded-4 modal-custom">

                                <!-- HEADER -->
                                <div class="modal-header flex-shrink-0">

                                    <div>

                                        <h5 class="mb-0">
                                            <?php echo ucwords($t['nama_customer']); ?>
                                        </h5>

                                        <small class="text-muted">
                                            Detail Pesanan
                                        </small>

                                    </div>

                                    <button
                                        class="btn-close"
                                        data-bs-dismiss="modal">
                                    </button>

                                </div>

                                <!-- BODY -->
                                <div class="modal-body modal-body-scroll">

                                    <?php while ($d = mysqli_fetch_array($detail)) { ?>

                                        <div class="border rounded-3 p-3 mb-3">

                                            <!-- TOP -->
                                            <div class="d-flex justify-content-between mb-2">

                                            <div>
                                                <strong>
                                                    <?php echo $d['nama_produk']; ?>
                                                </strong>

                                                    <small class="d-block text-muted">
                                                        Rp <?php echo number_format($d['harga_produk']); ?>
                                                    </small> 

                                            </div>

                                                <strong class="text-success">

                                                    Rp <?php echo number_format($d['subtotal']); ?>

                                                </strong>

                                            </div>

                                            <!-- DETAIL -->
                                            <div class="small text-muted">

                                                Coklat :
                                                <?php echo $d['qty_coklat']; ?>

                                                <br>

                                                Matcha :
                                                <?php echo $d['qty_matcha']; ?>

                                                <br>

                                                Topping :
                                                        <?php
                                                        if($d['nama_topping']){

                                                            echo $d['nama_topping'] .
                                                                ' (Rp ' .
                                                                number_format($d['harga_topping']) .
                                                                ')';

                                                        }else{

                                                            echo '-';

                                                        }
                                                        ?>

                                            </div>

                                        </div>

                                    <?php } ?>

                                </div>

                                <!-- FOOTER -->
                                <div class="modal-footer d-block flex-shrink-0">

                                    <!-- TOTAL -->
                                    <div class="d-flex justify-content-between mb-2">

                                        <strong>Total</strong>

                                        <strong class="text-success">

                                            Rp <?php echo number_format($t['total']); ?>

                                        </strong>

                                    </div>

                                    <!-- BAYAR -->
                                    <div class="d-flex justify-content-between mb-2">

                                        <span class="text-muted">
                                            Bayar
                                        </span>

                                        <strong>

                                            Rp <?php echo number_format($t['bayar']); ?>

                                        </strong>

                                    </div>

                                    <!-- KEMBALIAN -->
                                    <div class="d-flex justify-content-between">

                                        <span class="text-muted">
                                            Kembalian
                                        </span>

                                        <strong class="text-primary">

                                            Rp <?php echo number_format($t['kembalian']); ?>

                                        </strong>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php } ?>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>