<?php
include 'koneksi.php';

/** @var mysqli $conn */

// ambil antrian


$today = date('Y-m-d');

// ambil semua transaksi hari ini
$antrian = mysqli_query($conn, "

    SELECT *
    FROM transaksi

    WHERE DATE(tanggal) = '$today'

    ORDER BY

    FIELD(
        status,
        'Antrian',
        'Pending',
        'Selesai'
    ),

    id ASC

");

// TOTAL ANTRIAN
$qAntrian = mysqli_query($conn, "

    SELECT COUNT(*) as total
    FROM transaksi

    WHERE status='Antrian'
    AND DATE(tanggal)='$today'

");

$dataAntrian = mysqli_fetch_array($qAntrian);

$totalAntrian = $dataAntrian['total'];


// TOTAL PENDING
$qPending = mysqli_query($conn, "

    SELECT COUNT(*) as total
    FROM transaksi

    WHERE status='Pending'
    AND DATE(tanggal)='$today'

");

$dataPending = mysqli_fetch_array($qPending);

$totalPending = $dataPending['total'];


// TOTAL TRANSAKSI
$qSelesai = mysqli_query($conn, "

    SELECT COUNT(*) as total
    FROM transaksi

    WHERE status='Selesai'
    AND DATE(tanggal)='$today'

");

$dataSelesai = mysqli_fetch_array($qSelesai);

$totalSelesai = $dataSelesai['total'];

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Antrian</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            background: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .box-antrian{

            height: 75vh;

            background: white;

            border: 1px solid #333;
            border-radius: 15px;

            padding: 20px;

            display: flex;
            flex-direction: column;

        }

        .header-antrian{

            display: flex;
            justify-content: space-between;
            align-items: center;

            margin-bottom: 20px;

        }

        .list-antrian{

            flex: 1;

            overflow-y: auto;
        }

        .item-antrian{

            border: 1px solid #333;
            border-radius: 10px;

            padding: 12px;

            margin-bottom: 12px;

            text-align: center;

            background: white;

        }

        .btn-kasir{

            width: 100%;

            border-radius: 10px;

            border: 1px solid #333;

            background: white;

            padding: 10px;

        }

        .modal-custom{

    height: 90vh;

    display: flex;
    flex-direction: column;

}

.modal-body-scroll{

    flex: 1;

    overflow-y: auto;

}

    </style>

</head>

<body>

<div class="container py-3">

    <!-- BOX -->
    <div class="box-antrian">

        <!-- HEADER -->
        <div class="header-antrian">

            <strong>
                Daftar Antrian
            </strong>

            <div class="d-flex gap-2 flex-wrap">

                <!-- ANTRIAN -->
                <span class="badge bg-primary">

                    Antrian :
                    <?php echo $totalAntrian; ?>

                </span>

                <!-- PENDING -->
                <span class="badge bg-warning text-dark">

                    Pending :
                    <?php echo $totalPending; ?>

                </span>

                <!-- TRANSAKSI -->
                <span class="badge bg-success">

                    Transaksi :
                    <?php echo $totalSelesai; ?>

                </span>

            </div>

        </div>

        <!-- LIST -->
        <div class="list-antrian">

            <?php while($a = mysqli_fetch_array($antrian)){ ?>

            <?php

$warna = 'bg-primary';

if($a['status'] == 'Pending'){
    $warna = 'bg-warning';
}

if($a['status'] == 'Selesai'){
    $warna = 'bg-success';
}

?>

<button
    class="item-antrian w-100 text-white border-0 <?php echo $warna; ?>"
    data-bs-toggle="modal"
    data-bs-target="#modal<?php echo $a['id']; ?>"
>

                    <?php echo ucwords($a['nama_customer']); ?>

                </button>

                <?php

// ambil detail
$detail = mysqli_query($conn, "

    SELECT
        detail_transaksi.*,
        produk.nama_produk,
        topping.nama_topping

    FROM detail_transaksi

    LEFT JOIN produk
    ON detail_transaksi.produk_id = produk.id

    LEFT JOIN topping
    ON detail_transaksi.topping_id = topping.id

    WHERE transaksi_id='".$a['id']."'

");

?>

<!-- MODAL -->
<div class="modal fade" id="modal<?php echo $a['id']; ?>">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content rounded-4 modal-custom">

            <!-- HEADER -->
            <div class="modal-header w-100 flex-shrink-0">

                <div class="d-flex justify-content-between align-items-start w-100">

                    <!-- KIRI -->
                    <div class="d-flex gap-2 align-items-center">

                        <h5 class="modal-title mb-0">
                            <?php echo $a['nama_customer']; ?>
                        </h5>

                        <?php if($a['status'] != 'Selesai'){ ?>

                        <!-- EDIT -->
                        <a 
                            href="edit_transaksi.php?id=<?php echo $a['id']; ?>"
                            class="btn btn-sm btn-warning"
                        >
                            <i class="bi bi-pencil"></i>
                        </a>

                        <!-- HAPUS -->
                        <a 
                            href="hapus_transaksi.php?id=<?php echo $a['id']; ?>"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Hapus pesanan ini?')"
                        >
                            <i class="bi bi-trash"></i>
                        </a>

                    <?php } ?>

                    </div>

                    <!-- KANAN -->
                    <div class="d-flex align-items-center gap-2">

                        <small class="text-muted">
                            #<?php echo $a['id']; ?>
                        </small>

                        <button
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>

                    </div>

                </div>

            </div>

            <!-- BODY -->
            <div class="modal-body modal-body-scroll">

                <?php while($d = mysqli_fetch_array($detail)){ ?>

                    <div class="border rounded-3 p-2 mb-2">

                        <div class="d-flex justify-content-between mb-2">

                            <strong>
                                <?php echo $d['nama_produk']; ?>
                            </strong>

                            <strong>
                                Rp <?php echo number_format($d['subtotal']); ?>
                            </strong>

                        </div>

                        <div class="small text-muted">

                            Coklat :
                            <?php echo $d['qty_coklat']; ?>

                            <br>

                            Matcha :
                            <?php echo $d['qty_matcha']; ?>

                            <br>

                            Topping :
                            <?php echo $d['nama_topping'] ?: '-'; ?>

                        </div>

                    </div>

                <?php } ?>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer d-block flex-shrink-0">

                <!-- TOTAL -->
                <div class="text-end text-danger mb-0">

                    <strong>Total :</strong>

                    <strong>
                        Rp <?php echo number_format($a['total']); ?>
                    </strong>

                </div>

                <!-- INPUT BAYAR -->
                <div class="mb-2">

                    <label class="form-label small">
                        Bayar
                    </label>

                    <input
                        type="number"
                        class="form-control bayar-input"

                        data-total="<?php echo $a['total']; ?>"

                        oninput="hitungKembalian(this)"

                        placeholder="Masukkan pembayaran"

                        value="<?php echo $a['bayar']; ?>"

                        <?php
                        if($a['status'] == 'Selesai'){
                            echo 'readonly';
                        }
                        ?>
                    >

                </div>

                <!-- KEMBALIAN -->
                <div class="d-flex justify-content-between mb-2">

                    <strong>Kembalian</strong>

                    <strong class="text-success kembalian-text">
                        Rp <?php echo number_format($a['kembalian']); ?>
                    </strong>

                </div>

                <!-- BUTTON -->
               <?php if($a['status'] != 'Selesai'){ ?>

                <div class="d-flex gap-2">

                    <?php if($a['status'] == 'Antrian'){ ?>

                        <!-- PENDING -->
                        <a
                            href="proses/pending_transaksi.php?id=<?php echo $a['id']; ?>"
                            class="btn btn-warning flex-fill"
                            onclick="return confirm('Pending Pesanan?')"
                        >
                            Pending
                        </a>

                    <?php } ?>

                    <!-- SELESAI -->
                    <a
                        href="#"
                        class="btn btn-success flex-fill btn-selesai"
                        data-id="<?php echo $a['id']; ?>"
                        onclick="return false;"
                    >
                        Selesai
                    </a>

                </div>

                <?php } ?>

            </div>

        </div>

    </div>

</div>

            <?php } ?>

        </div>

    </div>

    <!-- BUTTON -->
    <div class="mt-3">

        <a href="index.php" class="btn-kasir text-decoration-none d-block text-center bg-secondary text-white">

            Ke Kasir

        </a>

    </div>

</div>

<script>

document.querySelectorAll('.btn-selesai').forEach(btn => {

    btn.addEventListener('click', function () {

        let modalFooter = this.closest('.modal-footer');

        let input = modalFooter.querySelector('.bayar-input');

        let total = parseInt(
            input.dataset.total
        );

        let bayar = parseInt(
            input.value
        ) || 0;

        // jika kosong
        if(input.value == ''){

            alert('Masukan nominal bayar');

            input.focus();

            return;

        }

        // jika kurang dari total
        if(bayar < total){

            alert('Uang bayar kurang');

            input.focus();

            return;

        }

        // konfirmasi selesai
        let konfirmasi = confirm(
            'Pesanan selesai?'
        );

        // jika oke
        if(konfirmasi){

            let id = this.dataset.id;

            window.location.href =
                'proses/selesai_transaksi.php?id=' + id +
                '&bayar=' + bayar;

        }

    });

});

</script>

<script>

function hitungKembalian(input){

    // total
    let total = parseInt(
        input.dataset.total
    );

    // bayar
    let bayar = parseInt(
        input.value
    ) || 0;

    // hitung
    let kembali = bayar - total;

    // minimal 0
    if(kembali < 0){

        kembali = 0;

    }

    // cari text kembalian
    let modalFooter = input.closest('.modal-footer');

    modalFooter
    .querySelector('.kembalian-text')
    .innerHTML =
        'Rp ' + kembali.toLocaleString('id-ID');

}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>