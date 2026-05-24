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

body{

    background:#f4f4f4;
    font-family:Arial, sans-serif;

}

/* CONTAINER */
.dashboard-container{

    max-width:500px;

    margin:auto;

    padding:15px;

}

/* BOX */
.dashboard-box{

    background:white;

    border-radius:35px;

    padding:20px;

    min-height:95vh;

    box-shadow:0 10px 25px rgba(0,0,0,0.08);

}

/* HEADER */
.header-dashboard{

    display:flex;
    justify-content:space-between;
    align-items:center;

    margin-bottom:20px;

}

.header-left{

    display:flex;
    align-items:center;

    gap:12px;

}

.btn-menu{

    width:42px;
    height:42px;

    border:none;

    border-radius:14px;

    background:#f4f4f4;

    font-size:22px;

}

/* FILTER */
.filter-box{

    margin-bottom:20px;

}

.filter-box input{

    border-radius:15px;
    padding:12px;

}

.card-pendapatan{

    background: white;

    border: 2px solid #1e3a8a;
    border-radius: 25px;

    padding: 20px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 15px;

}

.icon{

    width: 55px;
    height: 55px;

    border-radius: 15px;

    background: #e8f0ff;

    display: flex;
    justify-content: center;
    align-items: center;

    font-size: 24px;

    color: #1e3a8a;

}

.isi-pendapatan{

    flex: 1;

}

.divider{

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
.pendapatan-kiri{

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
.pendapatan-kiri h2{

    margin: 0;

    font-size: 24px;
    font-weight: bold;

}

.pendapatan-kiri small{

    color: #555;
    font-size: 13px;

}

/* GARIS */
.garis-pemisah{

    width: 1px;
    height: 70px;

    background: #ccc;

}

/* KANAN */
.pendapatan-kanan{

    width: 110px;

    text-align: center;

}

.pendapatan-kanan h1{

    margin: 0;

    font-size: 30px;
    font-weight: bold;

}

.pendapatan-kanan small{

    font-size: 13px;
    color: #555;

}

.card-pendapatan .icon{

    font-size:42px;

    margin-bottom:5px;

}

.card-pendapatan h2{

    font-size:30px;
    margin:0;

    font-weight:bold;

}

.card-pendapatan small{

    color: #a8a7a7;

}

/* TITLE */
.section-title{

    font-size:14px;

    font-weight:bold;

    color:#666;

    margin-bottom:12px;

}

/* STAT GRID */
.stat-grid{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:14px;

    margin-bottom:20px;

}

/* CARD STAT */
.stat-card{

    background:#fafafa;

    border-radius:22px;

    padding:18px;

    border:1px solid #eee;

    text-align:center;

}

.stat-icon{

    font-size:24px;

    margin-bottom:8px;

}

.stat-number{

    font-size:34px;

    font-weight:bold;

    line-height:1;

}

.stat-label{

    font-size:14px;

    /* color:#666; */

}

/* FAVORIT */
.favorite-card{

    background:#fff;

    border:1px solid #eee;

    border-radius:22px;

    padding:18px;

    text-align:center;

}

.favorite-icon{

    font-size:28px;

    margin-bottom:8px;

}

.favorite-title{

    font-size:24px;

    font-weight:bold;

}

.favorite-label{

    /* color:#666; */

    font-size:13px;

}

/* RANKING */
.ranking-box{

    background: #d1cfcf;

    border-radius:22px;

    padding:18px;

    margin-bottom:18px;

    border:1px solid #fff6f6;

}

.ranking-item{

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:10px 0;

    border-bottom:1px solid #e8e8e8;

}

.ranking-item:last-child{

    border-bottom:none;

}

.badge-rank{

    width:28px;
    height:28px;

    border-radius:50%;

    background:black;
    color:white;

    display:flex;
    justify-content:center;
    align-items:center;

    font-size:13px;

}

/* QUICK MENU */
.quick-menu{

    display:grid;

    grid-template-columns:1fr 1fr;

    gap:12px;

    margin-top:25px;

}

.quick-menu a{

    border-radius:18px;

    padding:14px;

    font-weight:bold;

}

/* MOBILE */
@media(max-width:480px){

    .dashboard-box{

        border-radius:28px;

    }

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
                    <i class="bi bi-list"></i>
                </button>

                <div>

                    <strong style="font-size:18px;">
                        Dashboard
                    </strong>

                    <div class="small text-muted">

                        Administrator

                    </div>

                </div>

            </div>

            <!-- RIGHT -->
            <div>

                <i class="bi bi-person-circle"
                style="font-size:28px;"></i>

            </div>

        </div>

        <?php

$tanggal = isset($_GET['tanggal'])
    ? $_GET['tanggal']
    : date('Y-m-d');

?>

        <!-- FILTER -->
        <div class="filter-box">

            <input
            type="date"
            class="form-control"
            name="tanggal"
            value="<?php echo $tanggal; ?>"
        >

        </div>

        <!-- CARD -->
        <div class="card-pendapatan">

            <!-- ICON -->
            <div class="icon">
                <i class="bi bi-cash-stack"></i>
            </div>

            <!-- ISI -->
            <div class="isi-pendapatan">

                <!-- NOMINAL -->
                <div class="d-flex align-items-center justify-content-center gap-2">

                    <h4 id="nominalPendapatan" class="mb-0">
                        Rp 200.000
                    </h4>

                    <!-- TOGGLE -->
                    <button
                        type="button"
                        class="btn btn-sm btn-light border-0"
                        onclick="togglePendapatan()"
                    >
                        <i
                            class="bi bi-eye"
                            id="iconPendapatan"
                        ></i>
                    </button>

                </div>

                <small>
                    Pendapatan hari ini
                </small>

            </div>

            <!-- GARIS -->
            <div class="divider"></div>

            <!-- TRANSAKSI -->
            <div class="text-center">

                <h2 class="mb-0">
                    20
                </h2>

                <small>
                    Transaksi hari ini
                </small>

            </div>

        </div>

        <!-- TITLE -->
        <div class="section-title mt-4">

            Statistik Hari Ini

        </div>

        <!-- STAT -->
        <div class="stat-grid">

            <!-- CUSTOMER -->
            <div class="stat-card bg-primary">

                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>

                <div class="stat-number">
                    12
                </div>

                <div class="stat-label">
                    Customer
                </div>

            </div>

            <!-- PORSI -->
            <div class="stat-card bg-danger">

                <div class="stat-icon">
                    <i class="bi bi-cup-hot"></i>
                </div>

                <div class="stat-number">
                    32
                </div>

                <div class="stat-label">
                    Porsi Terjual
                </div>

            </div>

        </div>

        <!-- FAVORIT -->
        <div class="section-title">

            Menu Favorit

        </div>

        <div class="stat-grid">

            <!-- VARIAN -->
            <div class="favorite-card bg-success">

                <div class="favorite-icon">
                    🍫
                </div>

                <div class="favorite-title">
                    Coklat
                </div>

                <div class="favorite-label">
                    Varian Favorit
                </div>

            </div>

            <!-- TOPPING -->
            <div class="favorite-card bg-warning">

                <div class="favorite-icon">
                    🧀
                </div>

                <div class="favorite-title">
                    Keju
                </div>

                <div class="favorite-label">
                    Topping Favorit
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

            <div class="ranking-item">

                <div class="d-flex align-items-center gap-2">

                    <div class="badge-rank">
                        1
                    </div>

                    <span>Isi 3</span>

                </div>

                <strong>
                    24
                </strong>

            </div>

            <div class="ranking-item">

                <div class="d-flex align-items-center gap-2">

                    <div class="badge-rank">
                        2
                    </div>

                    <span>Isi 4</span>

                </div>

                <strong>
                    19
                </strong>

            </div>

            <div class="ranking-item">

                <div class="d-flex align-items-center gap-2">

                    <div class="badge-rank">
                        3
                    </div>

                    <span>Isi 5</span>

                </div>

                <strong>
                    14
                </strong>

            </div>

        </div>

        <!-- TOPPING -->
        <div class="ranking-box">

            <div class="mb-2 fw-bold">
                Topping Terlaris
            </div>

            <div class="ranking-item">

                <div class="d-flex align-items-center gap-2">

                    <div class="badge-rank">
                        1
                    </div>

                    <span>Keju</span>

                </div>

                <strong>
                    18
                </strong>

            </div>

            <div class="ranking-item">

                <div class="d-flex align-items-center gap-2">

                    <div class="badge-rank">
                        2
                    </div>

                    <span>Oreo</span>

                </div>

                <strong>
                    13
                </strong>

            </div>

        </div>

        <!-- QUICK MENU -->
        <div class="quick-menu">

            <a
                href="../index.php"
                class="btn btn-dark"
            >
                <i class="bi bi-shop"></i>
                Kasir
            </a>

            <a
                href="../antrian.php"
                class="btn btn-secondary"
            >
                <i class="bi bi-list-task"></i>
                Antrian
            </a>

        </div>

    </div>

</div>

<script>

let tampilPendapatan = true;

function togglePendapatan(){

    let nominal = document.getElementById('nominalPendapatan');

    let icon = document.getElementById('iconPendapatan');

    if(tampilPendapatan){

        nominal.innerHTML = '•••••••';

        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');

        tampilPendapatan = false;

    }else{

        nominal.innerHTML = 'Rp 200.000';

        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');

        tampilPendapatan = true;

    }

}

</script>

</body>
</html>