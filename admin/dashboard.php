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

// FILTER TANGGAL
$tanggal = isset($_GET['tanggal'])
    ? $_GET['tanggal']
    : date('Y-m-d');


// =======================
// PENDAPATAN
// =======================
$qPendapatan = mysqli_query($conn, "

    SELECT SUM(total) as total
    FROM transaksi

    WHERE status='Selesai'
    AND DATE(tanggal)='$tanggal'

");

$dPendapatan = mysqli_fetch_array($qPendapatan);

$pendapatan = $dPendapatan['total'] ?? 0;


// =======================
// TOTAL TRANSAKSI
// =======================
$qTransaksi = mysqli_query($conn, "

    SELECT COUNT(*) as total
    FROM transaksi

    WHERE status='Selesai'
    AND DATE(tanggal)='$tanggal'

");

$totalTransaksi =
    mysqli_fetch_array($qTransaksi)['total'];


// =======================
// TOTAL CUSTOMER
// =======================
$qCustomer = mysqli_query($conn, "

    SELECT COUNT(DISTINCT nama_customer) as total
    FROM transaksi

    WHERE DATE(tanggal)='$tanggal'

");

$totalCustomer =
    mysqli_fetch_array($qCustomer)['total'];


// =======================
// TOTAL PORSI TERJUAL
// =======================
$qPorsi = mysqli_query($conn, "

    SELECT COUNT(*) as total_porsi

    FROM detail_transaksi

    LEFT JOIN transaksi
    ON detail_transaksi.transaksi_id = transaksi.id

    WHERE transaksi.status='Selesai'
    AND DATE(transaksi.tanggal)='$tanggal'

");

$dPorsi = mysqli_fetch_array($qPorsi);

$totalPorsi =
    $dPorsi['total_porsi'] ?? 0;
?>

<?php

// =======================
// RANKING PORSI
// =======================

$qRankingPorsi = mysqli_query($conn, "

    SELECT
        produk.nama_produk,
        COUNT(detail_transaksi.id) as total

    FROM detail_transaksi

    LEFT JOIN produk
    ON detail_transaksi.produk_id = produk.id

    LEFT JOIN transaksi
    ON detail_transaksi.transaksi_id = transaksi.id

    WHERE transaksi.status='Selesai'
    AND DATE(transaksi.tanggal)='$tanggal'

    GROUP BY detail_transaksi.produk_id

    ORDER BY total DESC

    LIMIT 3

");

?>
<?php

// =======================
// RANKING TOPPING
// =======================

$qRankingTopping = mysqli_query($conn, "

    SELECT
        topping.nama_topping,
        COUNT(detail_transaksi.id) as total

    FROM detail_transaksi

    LEFT JOIN topping
    ON detail_transaksi.topping_id = topping.id

    LEFT JOIN transaksi
    ON detail_transaksi.transaksi_id = transaksi.id

    WHERE transaksi.status='Selesai'
    AND DATE(transaksi.tanggal)='$tanggal'
    AND detail_transaksi.topping_id IS NOT NULL

    GROUP BY detail_transaksi.topping_id

    ORDER BY total DESC

    LIMIT 3

");

?>

<?php

// =======================
// TOTAL COKLAT
// =======================

$qCoklat = mysqli_query($conn, "

    SELECT
        SUM(qty_coklat) as total

    FROM detail_transaksi

    LEFT JOIN transaksi
    ON detail_transaksi.transaksi_id = transaksi.id

    WHERE transaksi.status='Selesai'
    AND DATE(transaksi.tanggal)='$tanggal'

");

$dCoklat = mysqli_fetch_array($qCoklat);

$totalCoklat =
    $dCoklat['total'] ?? 0;


// =======================
// TOTAL MATCHA
// =======================

$qMatcha = mysqli_query($conn, "

    SELECT
        SUM(qty_matcha) as total

    FROM detail_transaksi

    LEFT JOIN transaksi
    ON detail_transaksi.transaksi_id = transaksi.id

    WHERE transaksi.status='Selesai'
    AND DATE(transaksi.tanggal)='$tanggal'

");

$dMatcha = mysqli_fetch_array($qMatcha);

$totalMatcha =
    $dMatcha['total'] ?? 0;

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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

        /* HEADER */
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

        /* FILTER */
        .filter-box {

            margin-bottom: 20px;

        }

        .filter-box input {

            border-radius: 15px;
            padding: 12px;

        }

        .card-pendapatan {

            background: #0d6efd;

            border: 2px solid #0d6efd;
            border-radius: 25px;

            padding: 20px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

        }

        .icon {

            width: 55px;
            height: 55px;

            border-radius: 15px;

            background: #e8f0ff;

            display: flex;
            justify-content: center;
            align-items: center;

            font-size: 24px;

            color: #0d6efd;

        }

        .isi-pendapatan {

            flex: 1;

        }

        .divider {

            width: 1px;
            height: 60px;

            background: #ccc;

        }

        /* CARD PENDAPATAN */
        /* .card-pendapatan{

    background: white;

    border: 2px solid #1f3c88;
    border-radius: 25px;

    padding: 22px 18px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 15px;

    margin-bottom: 20px;

} */

        /* KIRI */
        .pendapatan-kiri {

            display: flex;
            align-items: center;

            gap: 14px;

            flex: 1;

        }

        /* .icon{

    width: 55px;
    height: 55px;

    border-radius: 18px;

    background: #eef4ff;

    display: flex;
    justify-content: center;
    align-items: center;

    font-size: 24px;

    color: #1f3c88;

} */

        /* TEXT */
        .pendapatan-kiri h2 {

            margin: 0;

            font-size: 26px;
            font-weight: bold;

        }

        .pendapatan-kiri small {

            color: #555;
            font-size: 13px;

        }

        /* GARIS */
        .garis-pemisah {

            width: 1px;
            height: 70px;

            background: #ccc;

        }

        /* KANAN */
        .pendapatan-kanan {

            width: 110px;

            text-align: center;

        }

        .pendapatan-kanan h1 {

            margin: 0;

            font-size: 30px;
            font-weight: bold;

        }

        .pendapatan-kanan small {

            font-size: 13px;
            color: #555;

        }

        .card-pendapatan .icon {

            font-size: 42px;

            margin-bottom: 5px;

        }

        .card-pendapatan h2 {

            font-size: 38px;
            margin: 0;

            font-weight: bold;

        }

        .card-pendapatan small {

            color: #a8a7a7;

        }

        /* TITLE */
        .section-title {

            font-size: 14px;

            font-weight: bold;

            color: #666;

            margin-bottom: 12px;

        }

        /* STAT GRID */
        .stat-grid {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 14px;

            margin-bottom: 20px;

        }

        /* CARD STAT */
        .stat-card {

            background: #fafafa;

            border-radius: 22px;

            padding: 18px;

            border: 1px solid #eee;

            text-align: center;

        }

        .stat-icon {

            font-size: 24px;

            margin-bottom: 8px;

        }

        .stat-number {

            font-size: 34px;

            font-weight: bold;

            line-height: 1;

        }

        .stat-label {

            font-size: 14px;

            /* color:#666; */

        }

        /* FAVORIT */
        .favorite-card {

            background: #eff0f1;

            /* border: 1px solid #d3d2d2; */

            border-radius: 22px;

            padding: 18px;

            text-align: center;

        }

        .favorite-icon {

            font-size: 28px;

            margin-bottom: 8px;

        }

        .favorite-title {

            font-size: 24px;

            font-weight: bold;

        }

        .favorite-label {

            /* color:#666; */

            font-size: 13px;

        }

        /* RANKING */
        .ranking-box {

            background: #d1cfcf;

            border-radius: 22px;

            padding: 18px;

            margin-bottom: 18px;

            border: 1px solid #fff6f6;

        }

        .ranking-item {

            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 10px 0;

            border-bottom: 1px solid #e8e8e8;

        }

        .ranking-item:last-child {

            border-bottom: none;

        }

        .badge-rank {

            width: 28px;
            height: 28px;

            border-radius: 50%;

            background: black;
            color: white;

            display: flex;
            justify-content: center;
            align-items: center;

            font-size: 13px;

        }

        /* QUICK MENU */
        .quick-menu {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 12px;

            margin-top: 25px;

        }

        .quick-menu a {

            border-radius: 18px;

            padding: 14px;

            font-weight: bold;

        }

        /* MOBILE */
        @media(max-width:480px) {

            .dashboard-box {

                border-radius: 28px;

            }

        }

        .tombol-menu {
            border-radius: 18px;
        }
    </style>

</head>

<body>

    <div class="dashboard-container">

        <div class="dashboard-box">

            <!-- HEADER -->
            <div class="header-dashboard">

                <!-- LEFT -->
                <div class="header-left">

                    <button class="btn-menu">
                        <i class="bi-grid-1x2-fill"></i>
                    </button>

                    <div>

                        <strong style="font-size:18px;">
                            Dashboard
                        </strong>

                        <div class="small text-muted">

                            Informasi Staistik

                        </div>

                    </div>

                </div>

                <!-- RIGHT -->
                <div class="tombol-menu">

                    <a style="border-radius: 18px;"
                        href="produk.php"
                        class="btn btn-sm btn-info text-white">
                        Produk
                    </a>

                    <a style="border-radius: 18px;"
                        href="transaksi.php"
                        class="btn btn-sm btn-warning text-white">
                        Transaksi
                    </a>

                </div>
                <!-- <div>

                <i class="bi bi-person-circle"
                style="font-size:28px;"></i>

            </div> -->

            </div>

            <?php

            $tanggal = isset($_GET['tanggal'])
                ? $_GET['tanggal']
                : date('Y-m-d');

            ?>

            <!-- FILTER -->
            <form method="GET">

                <!-- FILTER -->
                <div class="filter-box">

                    <input
                        type="date"
                        class="form-control"
                        name="tanggal"
                        value="<?php echo $tanggal; ?>"
                        onchange="this.form.submit()">

                </div>

            </form>

            <!-- CARD -->
            <div class="card-pendapatan">

                <!-- ICON -->
                <div class="icon">
                    <i class="bi bi-cash-stack"></i>
                </div>

                <!-- ISI -->
                <div class="isi-pendapatan">

                    <small class="text-white">
                        Pendapatan hari ini
                    </small>

                    <!-- NOMINAL -->
                    <div class="d-flex align-items-center justify-content-center gap-2">

                        <h4 id="nominalPendapatan" class="mb-0 text-white">
                            Rp <?php echo number_format($pendapatan); ?>
                        </h4>

                        <!-- TOGGLE -->
                        <button
                            type="button"
                            class="btn btn-sm btn-light border-0"
                            onclick="togglePendapatan()">
                            <i
                                class="bi bi-eye"
                                id="iconPendapatan"></i>
                        </button>

                    </div>

                </div>

                <!-- GARIS -->
                <div class="divider"></div>

                <!-- TRANSAKSI -->
                <div class="text-center">

                    <small class="text-white">
                        Transaksi hari ini
                    </small>

                    <h2 class="mb-0 text-white">
                        <?php echo $totalTransaksi; ?>
                    </h2>

                </div>

            </div>

            <!-- TITLE -->
            <div class="section-title mt-4">

                Statistik Hari Ini

            </div>

            <!-- STAT -->
            <div class="stat-grid text-white">

                <!-- CUSTOMER -->
                <div class="stat-card bg-danger">

                    <div class="stat-icon">
                        <i class="bi bi-people"></i>
                    </div>

                    <div class="stat-number">
                        <?php echo $totalCustomer; ?>
                    </div>

                    <div class="stat-label">
                        Customer
                    </div>

                </div>

                <!-- PORSI -->
                <div class="stat-card bg-success">

                    <div class="stat-icon">
                        <i class="bi-box-seam"></i>
                    </div>

                    <div class="stat-number">
                        <?php echo $totalPorsi; ?>
                    </div>

                    <div class="stat-label">
                        Porsi Terjual
                    </div>

                </div>

            </div>

            <!-- FAVORIT -->
            <div class="section-title">

                Varian Favorit

            </div>

            <div class="stat-grid">

                <!-- COKLAT -->
                <div class="favorite-card">

                    <div class="favorite-icon">

                        <img
                            style="width:150px; height:150px; border-radius:15px;"
                            src="../assets/kue_balok.jpg">

                    </div>

                    <div class="favorite-title">

                        Coklat

                    </div>

                    <!-- BADGE -->
                    <div class="mt-2">

                        <span class="badge bg-success px-3 py-2">

                            Terjual :
                            <?php echo $totalCoklat; ?> pcs

                        </span>

                    </div>

                </div>

                <!-- MATCHA -->
                <div class="favorite-card">

                    <div class="favorite-icon">

                        <img
                            style="width:150px; height:150px; border-radius:15px;"
                            src="../assets/matcha.jpg">

                    </div>

                    <div class="favorite-title">

                        Matcha

                    </div>

                    <!-- BADGE -->
                    <div class="mt-2">

                        <span class="badge bg-success px-3 py-2">

                            Terjual :
                            <?php echo $totalMatcha; ?> pcs

                        </span>

                    </div>

                </div>

            </div>

            <!-- RANKING -->
            <div class="section-title">

                Ranking Penjualan

            </div>

            <!-- PORSI -->
            <div class="ranking-box">

                <div class="mb-2 fw-bold">
                    Porsi Terlaris
                </div>

                <?php

                $no = 1;

                while ($r = mysqli_fetch_array($qRankingPorsi)) {

                ?>

                    <div class="ranking-item">

                        <div class="d-flex align-items-center gap-2">

                            <div class="badge-rank">
                                <?php echo $no++; ?>
                            </div>

                            <span>
                                <?php echo $r['nama_produk']; ?>
                            </span>

                        </div>

                        <strong>
                            Terjual : <?php echo $r['total']; ?>
                        </strong>

                    </div>

                <?php } ?>

            </div>

            <!-- TOPPING -->
            <div class="ranking-box">

                <div class="mb-2 fw-bold">
                    Topping Terlaris
                </div>

                <?php

                $no = 1;

                while ($t = mysqli_fetch_array($qRankingTopping)) {

                ?>

                    <div class="ranking-item">

                        <div class="d-flex align-items-center gap-2">

                            <div class="badge-rank">
                                <?php echo $no++; ?>
                            </div>

                            <span>
                                <?php echo ucwords($t['nama_topping']); ?>
                            </span>

                        </div>

                        <strong>
                            Terjual : <?php echo $t['total']; ?>
                        </strong>

                    </div>

                <?php } ?>

            </div>

            <!-- QUICK MENU -->
            <div class="quick-menu">

                <a
                    href="../index.php"
                    class="btn btn-dark">
                    <i class="bi bi-shop"></i>
                    Kasir
                </a>

                <a
                    href="../antrian.php"
                    class="btn btn-secondary">
                    <i class="bi bi-list-task"></i>
                    Antrian
                </a>

            </div>
            <div class="d-flex align-items-center justify-content-center mt-3">
                <a
                    href="../logout.php"
                    class="btn btn-danger d-flex align-items-center justify-content-center gap-2"
                    style="height:50px; width:100%; border-radius:18px;">
                    <i class="bi bi-box-arrow-right"></i>
                    <strong>Logout</strong>
                </a>
            </div>

        </div>

    </div>

    <script>
        let tampilPendapatan = true;

        function togglePendapatan() {

            let nominal = document.getElementById('nominalPendapatan');

            let icon = document.getElementById('iconPendapatan');

            if (tampilPendapatan) {

                nominal.innerHTML = '•••••••';

                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');

                tampilPendapatan = false;

            } else {

                nominal.innerHTML = 'Rp <?php echo number_format($pendapatan); ?>';

                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');

                tampilPendapatan = true;

            }

        }
    </script>

</body>

</html>