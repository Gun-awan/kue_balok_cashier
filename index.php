<?php
include 'koneksi.php';

session_start();

if (!isset($_SESSION['login'])) {

    header("Location: login.php");
    exit;
}

/** @var mysqli $conn */

$topping = mysqli_query($conn, "
    SELECT * FROM topping
    WHERE status='Aktif'
");

$antrian = mysqli_query($conn, "

    SELECT *
    FROM transaksi

    WHERE status='Antrian'

    ORDER BY id ASC

");

// hitung total
$total = mysqli_num_rows($antrian);
?>

<?php

$optionTopping = '';

while ($t = mysqli_fetch_array($topping)) {

    $selected = '';

    if ($t['id'] == 1) {
        $selected = 'selected';
    }

    $optionTopping .= '

    <option 
        value="' . $t['id'] . '"
        data-harga="' . $t['harga'] . '"
        ' . $selected . '
    >
        ' . $t['nama_topping'] . '
    </option>

';
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kasir Kue Balok</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        */ body {
            background: #f4f4f4;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* CONTAINER APP */
        .app-container {
            height: 100vh;

            display: flex;
            flex-direction: column;

            padding: 14px;
            gap: 14px;
        } 

        /* BOX BESAR */
        .box-pesanan {
            flex: 1;
            height: 77vh;

            background: white;
            border: 1px solid #868383;
            border-radius: 30px;

            padding: 20px;

            overflow-y: auto;
        }

        /* ITEM */
        .item-pesanan {
            background: #f8f8f8;
            border-radius: 14px;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        /* MENU BAWAH */
        /* .menu-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);

            gap: 10px;
        } */

        /* BUTTON */
        /* .tombol-menu {
            aspect-ratio: 1/1;

            border: none;
            border-radius: 14px;
            background: white;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            transition: 0.2s;
        } */

        .tombol-antrian {

        width: 85px;
    height: 85px;
            aspect-ratio: 1/1;

            border: none;
            border-radius: 14px;
            background: white;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            transition: 0.2s;
        }

        .tombol-antrian:hover {
            color: white;

        }

        /* ANGKA */
        .angka-menu {
            font-size: 36px;
            font-weight: bold;
            line-height: 1;
        }

        .text-menu {
            font-size: 11px;
        }

        /* BUTTON TEXT */
        .text-antrian {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        /* WARNA */
        .tombol-antrian {
            position: relative;
            color: black;
            border: none;
        }

        .badge-antrian {
            position: absolute;
            top: -5px;
            right: -5px;

            background: red;
            color: white;

            font-size: 12px;
            font-weight: bold;

            width: 22px;
            height: 22px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        .tombol-dashboard {
            background: #212529;
            color: white;
            border: none;
        }

        /* INPUT */
        .form-control-sm {
            border-radius: 10px;
            text-align: center;
        }

        .box-pesanan {
            flex: 1;

            background: white;
            /* border: 1px solid #7e7676; */
            border-radius: 20px;

            padding: 10px 20px 10px 20px;

            display: flex;
            flex-direction: column;

            overflow: hidden;
        }

        /* AREA SCROLL */
        .pesanan-content {
            flex: 1;
            overflow-y: auto;

            padding-right: 3px;
        }

        /* FOOTER BAWAH */
        .pesanan-footer {
            padding-top: 10px;
            margin-top: 10px;

            border-top: 1px solid #ddd;

            background: white;
        }

        /* HEADER */
        .pesanan-header {
            display: flex;
            align-items: end;

            gap: 10px;

            padding-bottom: 10px;
            margin-bottom: 12px;

            border-bottom: 1px solid #ddd;

            background: white;
        }

        /* TOTAL BOX */
        .total-header {
            min-width: 100px;

            text-align: right;
        }

        .total-header strong {
            font-size: 18px;
        }

        /* INPUT */
        .pesanan-header .form-control {
            border-radius: 12px;
        }

        .tombol-menu:hover {
            color: #f4f4f4;
        }

        .hapus-item {
            width: 28px;
            height: 28px;

            padding: 0;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .badge-isi {
            width: 30px;
            height: 30px;

            border-radius: 12px;

            background: #f1f1f1;
            border: 1px solid #ccc;

            display: flex;
            justify-content: center;
            align-items: center;

            font-size: 18px;
            font-weight: bold;
        }

        .menu-wrapper {

            width: 100%;

            display: flex;

            justify-content: center;

            margin-top: 8px;

        }

        .menu-grid {

            display: flex;

            gap: 10px;

            justify-content: center;

            align-items: center;

            flex-wrap: wrap;

        }

        .tombol-menu {

            width: 85px;
            height: 85px;

            border: none;

            border-radius: 18px;

            color: black;

            display: flex;

            flex-direction: column;

            justify-content: center;

            align-items: center;

            position: relative;

        }

        .angka-menu {

            font-size: 28px;

            font-weight: bold;

            line-height: 1;

        }

        .text-menu {

            font-size: 14px;

            margin-top: 2px;

        }
    </style>
</head>

<body>

    <div class="app-container">

        <!-- BOX UTAMA -->
        <form
            action="proses/simpan_transaksi.php"
            method="POST"
            id="formPesanan">

            <div class="box-pesanan">

                <!-- HEADER -->
                <div class="pesanan-header">

                    <!-- NAMA CUSTOMER -->
                    <div class="flex-fill me-2">

                        <input
                            type="text"
                            name="nama_customer"
                            id="namaCustomer"
                            class="form-control"
                            placeholder="Masukkan nama"
                            required>

                    </div>

                    <!-- TOTAL -->
                    <div class="total-header">

                        <small class="text-muted d-block">
                            Total
                        </small>

                        <strong id="totalHarga">
                            Rp 0
                        </strong>

                        <input type="hidden" name="total" id="inputTotal">

                    </div>

                </div>

                <!-- CONTENT SCROLL -->
                <div class="pesanan-content" id="daftarPesanan">

                    <!--  -->

                </div>

                <!-- FOOTER -->
                <div class="pesanan-footer">

                    <div class="d-flex gap-2">

                        <!-- <button class="btn btn-danger flex-fill">
                        Clear
                    </button> -->

                        <button type="submit" class="btn btn-success flex-fill" style="border-radius: 15px;"
                            onclick="return cekPesanan2()">
                            Simpan Pesanan
                        </button>

                    </div>

                </div>

            </div>
        </form>

        <!-- MENU BUTTON -->
        <!-- <div class="menu-wrapper"> -->

            <?php

            $produk = mysqli_query($conn, "

    SELECT *
    FROM produk

    ORDER BY id ASC

");

            ?>

            <div class="menu-grid">

                <?php while ($p = mysqli_fetch_array($produk)) { ?>

                    <?php

                    // ambil angka isi
                    $isi = str_replace(
                        'Isi ',
                        '',
                        $p['nama_produk']
                    );

                    // warna otomatis
                    $warna = 'bg-primary';

                    if ($isi == 3) {
                        $warna = 'bg-warning';
                    }

                    if ($isi == 4) {
                        $warna = 'bg-danger';
                    }

                    ?>

                    <!-- ISI 3 -->
                    <button
                        type="button"
                        class="tombol-menu <?php echo $warna; ?>"
                        onclick="tambahPesanan(
            <?php echo $p['id']; ?>,
            '<?php echo $p['nama_produk']; ?>',
            <?php echo $isi; ?>,
            <?php echo $p['harga']; ?>
        )">
                        <div class="angka-menu"><?php echo $isi; ?></div>
                        <div class="text-menu"><?php echo number_format($p['harga'] / 1000); ?>K</div>
                    </button>

                    <!-- ISI 4 -->
                    <!-- <button
                type="button"
                class="tombol-menu bg-danger"
                onclick="tambahPesanan(2,'Isi 4',4,14000)">
                <div class="angka-menu">4</div>
                <div class="text-menu">14K</div>
            </button> -->

                    <!-- ISI 5 -->
                    <!-- <button
                type="button"
                class="tombol-menu bg-primary"
                onclick="tambahPesanan(3,'Isi 5',5,17000)">
                <div class="angka-menu">5</div>
                <div class="text-menu">17K</div>
            </button> -->

                <?php } ?>

                <!-- ANTRIAN -->
                <button
                    type="button"
                    class="tombol-antrian bg-secondary position-relative"
                    onclick="cekPesanan()">

                    <div class="text-antrian">
                        Antrian
                    </div>

                    <!-- BADGE -->
                    <span class="badge-antrian">
                        <?php echo $total; ?>
                    </span>

                </button>

            </div>

        </div>

    <!-- </div> -->

    <script>
        let optionTopping = `

    <?php echo $optionTopping; ?>

`;
    </script>

    <script>
        function cekPesanan2() {

            // cek jumlah item
            let jumlahPesanan =
                document.querySelectorAll('.item-pesanan').length;

            // jika kosong
            if (jumlahPesanan < 1) {

                alert('Belum ada pesanan');

                return false;

            }

            // lanjut submit
            return true;

        }
    </script>

    <script>
        document
            .getElementById('formPesanan')
            .addEventListener('submit', function(e) {

                // semua badge sisa
                let semuaSisa = document.querySelectorAll('.sisa-isi');


                // cek
                for (let i = 0; i < semuaSisa.length; i++) {

                    let sisa = parseInt(
                        semuaSisa[i].innerHTML
                    );

                    // jika belum 0
                    if (sisa != 0) {

                        e.preventDefault();

                        alert('Silahkan lengkapi menu terlebih dahulu');

                        return;

                    }


                }

                // confirm simpan
                let konfirmasi = confirm(
                    'Simpan pesanan?'
                );

                // jika cancel
                if (!konfirmasi) {

                    e.preventDefault();

                }

            });
    </script>

    <script>
        function cekPesanan() {

            // cek apakah ada item pesanan
            let jumlahPesanan = document.querySelectorAll('.item-pesanan').length;

            // jika ada pesanan belum disimpan
            if (jumlahPesanan > 0) {

                alert('Selesaikan pesanan dahulu');

                return;

            }

            // pindah halaman
            window.location.href = 'antrian.php';

        }
    </script>

    <script>
        let total = 0;

        function tambahPesanan(produkId, namaProduk, angkaIsi, harga) {

            // ambil topping pertama
            let temp = document.createElement('div');

            temp.innerHTML = optionTopping;

            let firstOption = temp.querySelector('option');

            let hargaToppingAwal =
                parseInt(firstOption.getAttribute('data-harga')) || 0;

            let rupiah = harga.toLocaleString('id-ID');

            // id unik item
            let idItem = 'item_' + Date.now();

            let html = `
    
<div class="item-pesanan" id="${idItem}">

    <!-- hidden -->
    <input type="hidden" class="max-isi" value="${angkaIsi}">
    <input type="hidden" name="produk_id[]" value="${produkId}">
    <input type="hidden" name="harga[]" value="${harga}">

    <div class="d-flex justify-content-between align-items-start mb-2">

        <!-- KIRI -->
        <div>
            <strong>${namaProduk}</strong>

            <div style="font-size:11px;">
                Rp ${rupiah}
            </div>
        </div>

        <!-- TENGAH -->
        <div class="badge-isi sisa-isi">
            ${angkaIsi}
        </div>

        <!-- KANAN -->
        <button 
            type="button"
            class="btn btn-sm btn-danger"
            onclick="hapusPesanan('${idItem}', ${harga})"
        >
            ✕
        </button>

    </div>

    <div class="row g-2">

        <div class="col-4">

            <small>Coklat</small>

            <input 
            type="number"
            name="qty_coklat[]"
            class="form-control form-control-sm qty-coklat"
            value=""
            min="0"
            oninput="updateSisa(this)"
        >

        </div>

        <div class="col-4">

            <small>Matcha</small>

            <input 
            type="number"
            name="qty_matcha[]"
            class="form-control form-control-sm qty-matcha"
            value=""
            min="0"
            oninput="updateSisa(this)"
        >

        </div>

        <div class="col-4">

            <small>Topping</small>

            <select 
                name="topping_id[]"
                class="form-select form-select-sm topping-select"
                onchange="ubahTopping(this)"
            >
                ${optionTopping}
            </select>

            <input 
    type="hidden" 
    name="harga_topping[]" 
    value="${hargaToppingAwal}"
    class="harga-topping"
>

        </div>

    </div>

</div>
`;

            // tampilkan item
            document
                .getElementById('daftarPesanan')
                .insertAdjacentHTML('beforeend', html);

            // tambah total
            total += harga;
            total += hargaToppingAwal;

            updateTotal();

        }


        // HAPUS ITEM
        function hapusPesanan(idItem, hargaProduk) {

            // ambil item
            let item = document.getElementById(idItem);

            // ambil harga topping
            let hargaTopping = item.querySelector('.harga-topping').value;

            hargaTopping = parseInt(hargaTopping) || 0;

            // kurangi total
            total -= hargaProduk;
            total -= hargaTopping;

            // hapus item
            item.remove();

            // update total
            updateTotal();

            // jika kosong
            if (document.querySelectorAll('.item-pesanan').length == 0) {

                document.getElementById('pesananKosong').style.display = 'flex';

            }

        }

        function updateSisa(input) {

            // item parent
            let item = input.closest('.item-pesanan');

            // max isi
            let maxIsi = parseInt(
                item.querySelector('.max-isi').value
            );

            // qty
            let coklat = parseInt(
                item.querySelector('.qty-coklat').value
            ) || 0;

            let matcha = parseInt(
                item.querySelector('.qty-matcha').value
            ) || 0;

            if ((coklat + matcha) > maxIsi) {

                alert('Jumlah melebihi isi menu');

                input.value = 0;

                return;

            }

            // hitung sisa
            let sisa = maxIsi - (coklat + matcha);

            // minimal 0
            if (sisa < 0) {

                sisa = 0;

            }

            // update badge
            item.querySelector('.sisa-isi').innerHTML = sisa;

        }


        // UPDATE TOTAL
        function updateTotal() {

            document.getElementById('totalHarga').innerHTML =
                'Rp ' + total.toLocaleString('id-ID');

            document.getElementById('inputTotal').value = total;

        }

        function ubahTopping(select) {

            // ambil option dipilih
            let selected = select.options[select.selectedIndex];

            // ambil harga topping
            let harga = selected.getAttribute('data-harga');

            // jika kosong
            if (harga == null) {

                harga = 0;

            }

            harga = parseInt(harga);

            // hidden input
            let hidden = select.parentElement.querySelector('.harga-topping');

            // harga lama
            let hargaLama = parseInt(hidden.value);

            // update total
            total -= hargaLama;

            total += harga;

            // simpan harga baru
            hidden.value = harga;

            // update tampilan
            updateTotal();

        }
    </script>

</body>

</html>