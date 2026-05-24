<?php
include '../koneksi.php';

/** @var mysqli $conn */

// PRODUK
$produk = mysqli_query($conn,"
    SELECT * FROM produk
    ORDER BY id ASC
");

// VARIAN
// $varian = mysqli_query($conn,"
//     SELECT * FROM varian
//     ORDER BY id ASC
// ");

// TOPPING
$topping = mysqli_query($conn,"
    SELECT * FROM topping
    ORDER BY id ASC
");
?>
<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manajemen Produk</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>

body{
    background:#f4f4f4;
    font-family:Arial,sans-serif;
}

.dashboard-container {

            max-width: 500px;

            margin: auto;

            padding: 15px;

        }

        /* BOX */
        .dashboard-box {

            background: white;

            border-radius: 35px;

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

.container-app{

    max-width:550px;
    margin:auto;

    padding:15px;

}

.section-box{

    background: #f5f5f5;

    border-radius:25px;

    padding:18px;

    margin-bottom:15px;

}

.section-header{

    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-bottom:15px;

}

.item-card{

    border:1px solid #bbb9b9;

    border-radius:18px;

    padding:12px;

    margin-bottom:10px;

}

.badge-status{

    font-size:11px;
}

</style>

</head>

<body>

<!-- <div class="container-app"> -->

<div class="dashboard-container">

        <div class="dashboard-box">
            <!-- <div class="container-app"> -->

            <!-- HEADER -->

            <div class="header-dashboard">

                <!-- LEFT -->
                <div class="header-left">

                    <button class="btn-menu">
                        <i class="bi-box-seam-fill"></i>
                    </button>

                    <div>

                        <strong style="font-size:18px;">
                            Produk
                        </strong>

                        <div class="small text-muted">

                            Kelola menu & topping

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

    <!-- HEADER -->
    <!-- <div class="d-flex justify-content-between align-items-center mb-3">

        <div>

            <h5 class="mb-0">
                Produk
            </h5>

            <small class="text-muted">
                Kelola menu & topping
            </small>

        </div>

        <a
            href="dashboard.php"
            class="btn btn-secondary btn-sm"
        >
            Kembali
        </a>

    </div> -->

    <!-- PORSI -->
    <div class="section-box">

        <div class="section-header">

            <strong>
                Porsi
            </strong>

            <button
                class="btn btn-primary btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#modalTambahPorsi"
            >
                <i class="bi bi-plus-lg"></i>
            </button>

        </div>

        

        <?php while($p = mysqli_fetch_array($produk)){ ?>

        <div class="item-card">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <strong>
                        <?php echo $p['nama_produk']; ?>
                    </strong>

                    <div class="small text-muted">

                        Rp <?php echo number_format($p['harga']); ?>

                    </div>

                </div>

                <div class="d-flex gap-2 align-items-center">

                    <span class="badge bg-success badge-status">

                        <?php echo $p['status']; ?>

                    </span>

                    <button class="btn btn-warning btn-sm">

                        <i class="bi bi-pencil"></i>

                    </button>

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

    <!-- VARIAN
    <div class="section-box">

        <div class="section-header">

            <strong>
                Varian
            </strong>

            <button
                class="btn btn-primary btn-sm"
            >
                <i class="bi bi-plus-lg"></i>
            </button>

        </div>

        <php while($v = mysqli_fetch_array($varian)){ ?>

        <div class="item-card">

            <div class="d-flex justify-content-between align-items-center">

                <strong>
                    <php echo $v['nama_varian']; ?>
                </strong>

                <button class="btn btn-warning btn-sm">

                    <i class="bi bi-pencil"></i>

                </button>

            </div>

        </div>

        <php } ?> 

    </div> -->

    <!-- TOPPING -->
    <div class="section-box">

        <div class="section-header">

            <strong>
                Topping
            </strong>

            <button
                class="btn btn-primary btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#modalTambahTopping"
            >
                <i class="bi bi-plus-lg"></i>
            </button>

        </div>

        <?php while($t = mysqli_fetch_array($topping)){ ?>

        <div class="item-card">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <strong>
                        <?php echo ucwords($t['nama_topping']); ?>
                    </strong>

                    <div class="small text-muted">

                        Rp <?php echo number_format($t['harga']); ?>

                    </div>

                </div>

                <button class="btn btn-warning btn-sm">

                    <i class="bi bi-pencil"></i>

                </button>

            </div>

        </div>

        <?php } ?>

    </div>
        
        </div>

</div>

<!-- MODAL TAMBAH PORSI -->
<div
    class="modal fade"
    id="modalTambahPorsi"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content rounded-4">

            <!-- HEADER -->
            <div class="modal-header">

                <h5 class="modal-title">
                    Tambah Porsi
                </h5>

                <button
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <!-- FORM -->
            <form
                action="proses/tambah_produk.php"
                method="POST"
            >

                <!-- BODY -->
                <div class="modal-body">

                    <!-- NAMA -->
                    <div class="mb-3">

                        <label class="form-label">
                            Nama Porsi
                        </label>

                        <input
                            type="text"
                            name="nama_produk"
                            class="form-control"
                            placeholder="Contoh : Isi 3"
                            required
                        >

                    </div>

                    <!-- HARGA -->
                    <div class="mb-3">

                        <label class="form-label">
                            Harga
                        </label>

                        <input
                            type="number"
                            name="harga"
                            class="form-control"
                            placeholder="Masukkan harga"
                            required
                        >

                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer">

                    <button
                        class="btn btn-primary w-100"
                    >
                        Simpan Porsi
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- MODAL TAMBAH TOPPING -->
<div
    class="modal fade"
    id="modalTambahTopping"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content rounded-4">

            <!-- HEADER -->
            <div class="modal-header">

                <h5 class="modal-title">
                    Tambah Topping
                </h5>

                <button
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <!-- FORM -->
            <form
                action="proses/tambah_topping.php"
                method="POST"
            >

                <!-- BODY -->
                <div class="modal-body">

                    <!-- NAMA -->
                    <div class="mb-3">

                        <label class="form-label">
                            Nama Topping
                        </label>

                        <input
                            type="text"
                            name="nama_topping"
                            class="form-control"
                            placeholder="Contoh : Keju"
                            required
                        >

                    </div>

                    <!-- HARGA -->
                    <div class="mb-3">

                        <label class="form-label">
                            Harga
                        </label>

                        <input
                            type="number"
                            name="harga"
                            class="form-control"
                            placeholder="Masukkan harga topping"
                            required
                        >

                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer">

                    <button
                        class="btn btn-primary w-100"
                    >
                        Simpan Topping
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>