<?php
include 'koneksi.php';

/** @var mysqli $conn */

$id = $_GET['id'];

// transaksi
$transaksi = mysqli_fetch_array(mysqli_query($conn, "

    SELECT *
    FROM transaksi
    WHERE id='$id'

"));

// detail
$detail = mysqli_query($conn, "

    SELECT
        detail_transaksi.*,
        produk.nama_produk,
        produk.harga
    FROM detail_transaksi

    LEFT JOIN produk
    ON detail_transaksi.produk_id = produk.id

    WHERE transaksi_id='$id'

");

// topping
$topping = mysqli_query($conn, "
    SELECT *
    FROM topping
    WHERE status='Aktif'
");

$toppingData = [];
$optionTopping = '';

while($t = mysqli_fetch_array($topping)){

    $toppingData[] = $t;

    $optionTopping .= '
        <option
            value="'.$t['id'].'"
            data-harga="'.$t['harga'].'"
        >
            '.$t['nama_topping'].'
        </option>
    ';
}

$firstTop = $toppingData[0] ?? null;
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Transaksi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4f4f4;
    font-family:Arial,sans-serif;
}

.app-container{
    height:100vh;
    display:flex;
    flex-direction:column;
    padding:14px;
    gap:14px;
}

/* BOX UTAMA */
.box-edit{
    height: 77vh;
    background: white;
    border-radius: 20px;
    padding: 15px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* HEADER */
.header-edit{
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 12px;
    margin-bottom: 12px;
    border-bottom: 1px solid #ddd;
    flex-shrink: 0;
}

/* CONTENT SCROLL */
.content-edit{
    flex: 1;
    overflow-y: auto;
    padding-right: 3px;
}

/* FOOTER */
.footer-edit{
    padding-top: 12px;
    margin-top: 12px;
    border-top: 1px solid #ddd;
    flex-shrink: 0;
    background: white;
}

.item-pesanan{
    background:#fafafa;
    border:1px solid #ddd;
    border-radius:15px;
    padding:12px;
    margin-bottom:12px;
}

.menu-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:10px;
}

.tombol-menu{
    aspect-ratio:1/1;
    border:none;
    border-radius:14px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    color:white;
}

.angka-menu{
    font-size:30px;
    font-weight:bold;
}

.text-kembali{
    font-size:16px;
    font-weight:bold;
}

.text-menu{
    font-size:12px;
}

.badge-isi{
    width:32px;
    height:32px;
    border-radius:10px;
    background:#eee;
    display:flex;
    justify-content:center;
    align-items:center;
    font-weight:bold;
}

/* .menu-grid{

    display: flex;

    gap: 10px;

    justify-content: center;

    align-items: center;

    flex-wrap: wrap;

}

.tombol-menu:hover{
    color: #f4f4f4;
}

.tombol-menu{

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

.angka-menu{

    font-size: 28px;

    font-weight: bold;

    line-height: 1;

}

.text-menu{

    font-size: 14px;

    margin-top: 2px;

} */

</style>

</head>

<body>

<div class="app-container">

<form action="proses/update_transaksi.php" method="POST" id="formEditPesanan">

<input
    type="hidden"
    name="id"
    value="<?php echo $id; ?>"
>

<div class="box-edit">

    <!-- HEADER -->
    <div class="header-edit">

        <div>

            <strong>
                Edit Pesanan
            </strong>

            <div class="small text-muted">
                <?php echo $transaksi['nama_customer']; ?>
            </div>

        </div>

    </div>

    <!-- CONTENT -->
    <div class="content-edit" id="daftarPesanan">

        <?php while($d = mysqli_fetch_array($detail)){ ?>

        <div class="item-pesanan">

            <input
                type="hidden"
                name="detail_id[]"
                value="<?php echo $d['id']; ?>"
            >

            <input
                type="hidden"
                name="produk_id[]"
                value="<?php echo $d['produk_id']; ?>"
            >

            <input
                type="hidden"
                class="harga-produk"
                value="<?php echo $d['harga']; ?>"
            >

            <input
                type="hidden"
                class="max-isi"
                value="<?php echo str_replace('Isi ','',$d['nama_produk']); ?>"
            >

            <div class="d-flex justify-content-between align-items-start mb-2">

                <div>

                    <strong>
                        <?php echo $d['nama_produk']; ?>
                    </strong>

                    <div class="small text-muted">
                        Rp <?php echo number_format($d['harga']); ?>
                    </div>

                </div>

                <div class="badge-isi sisa-isi">
                    0
                </div>

                <button
                    type="button"
                    class="btn btn-sm btn-danger"
                    onclick="hapusItem(this)"
                >
                    ✕
                </button>

            </div>

            <div class="row g-2">

                <!-- coklat -->
                <div class="col-4">

                    <small>Coklat</small>

                    <input
                        type="number"
                        name="qty_coklat[]"
                        class="form-control form-select-sm qty-coklat"
                        value="<?php echo $d['qty_coklat']; ?>"
                        oninput="updateSisa(this)"
                    >

                </div>

                <!-- matcha -->
                <div class="col-4">

                    <small>Matcha</small>

                    <input
                        type="number"
                        name="qty_matcha[]"
                        class="form-control form-select-sm qty-matcha"
                        value="<?php echo $d['qty_matcha']; ?>"
                        oninput="updateSisa(this)"
                    >

                </div>

                <!-- topping -->
                <div class="col-4">

                    <small>Topping</small>

                    <select
    name="topping_id[]"
    class="form-select form-select-sm topping-select"
    onchange="ubahTopping(this)"
>

    <!-- <option value="">
        Tanpa Topping
    </option> -->

    <?php foreach($toppingData as $t){ ?>

    <option
        value="<?php echo $t['id']; ?>"
        data-harga="<?php echo $t['harga']; ?>"

        <?php

        if($d['topping_id'] == $t['id']){

            echo 'selected';

        }

        else if(
            empty($d['topping_id']) &&
            $firstTop &&
            $t['id'] == $firstTop['id']
        ){

            echo 'selected';

        }

        ?>
    >
        <?php echo $t['nama_topping']; ?>
    </option>

    <?php } ?>

</select>

                    <input
                    type="hidden"
                    class="harga-topping"
                    value="<?php echo $firstTop['harga']; ?>"
                >

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

    <!-- FOOTER -->
    <div class="footer-edit">

        <div class="text-end mb-2">

            <strong id="totalHarga">
                Rp 0
            </strong>

        </div>

        <button type="submit" class="btn btn-success w-100">

            Update Pesanan

        </button>

    </div>

</div>

</form>

<!-- MENU -->
<div class="menu-wrapper">

        <?php

$produk = mysqli_query($conn, "

    SELECT *
    FROM produk

    ORDER BY id ASC

");

?>

<div class="menu-grid">

<?php while($p = mysqli_fetch_array($produk)){ ?>

    <?php

    // ambil angka isi
    $isi = str_replace(
        'Isi ',
        '',
        $p['nama_produk']
    );

    // warna otomatis
    $warna = 'bg-primary';

    if($isi == 3){
        $warna = 'bg-warning';
    }

    if($isi == 4){
        $warna = 'bg-danger';
    }

    ?>
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

    <!-- <button
        type="button"
        class="tombol-menu bg-info"
        onclick="tambahPesanan(2,'Isi 4',14000,4)"
    >
        <div class="angka-menu">4</div>
        <div class="text-menu">14K</div>
    </button>

    <button
        type="button"
        class="tombol-menu bg-primary"
        onclick="tambahPesanan(3,'Isi 5',17000,5)"
    >
        <div class="angka-menu">5</div>
        <div class="text-menu">17K</div>
    </button> -->
    <?php } ?>

    <a
            href="antrian.php"
            class="btn btn-sm btn-secondary tombol-menu"
        >
            <div class="text-kembali"> Kembali </div>
        </a>

</div>

</div>
</div>

<script>
window.onload = function(){

    document
    .querySelectorAll('.topping-select')
    .forEach(function(select){

        ubahTopping(select);

    });

}
</script>

<script>
        document
            .getElementById('formEditPesanan')
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
                    'Update pesanan?'
                );

                // jika cancel
                if (!konfirmasi) {

                    e.preventDefault();

                }

            });
    </script>

<script>

let total = 0;

let optionTopping = `
<?php echo $optionTopping; ?>
`;

function hitungTotal(){

    total = 0;

    document
    .querySelectorAll('.item-pesanan')
    .forEach(function(item){

        let hargaProduk =
        parseInt(item.querySelector('.harga-produk').value) || 0;

        let hargaTopping =
        parseInt(item.querySelector('.harga-topping').value) || 0;

        total += hargaProduk + hargaTopping;

    });

    document.getElementById('totalHarga').innerHTML =
    'Rp ' + total.toLocaleString('id-ID');

}

function ubahTopping(select){

    let selected =
    select.options[select.selectedIndex];

    let harga =
    selected.getAttribute('data-harga');

    if(harga == null){
        harga = 0;
    }

    select.parentElement
    .querySelector('.harga-topping')
    .value = harga;

    hitungTotal();

}

// function updateSisa(input){

//     let item =
//     input.closest('.item-pesanan');

//     let maxIsi =
//     parseInt(item.querySelector('.max-isi').value);

//     let coklat =
//     parseInt(item.querySelector('.qty-coklat').value) || 0;

//     let matcha =
//     parseInt(item.querySelector('.qty-matcha').value) || 0;

//     let sisa =
//     maxIsi - (coklat + matcha);

//     item.querySelector('.sisa-isi').innerHTML = sisa;

// }

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

function hapusItem(button){

    button.closest('.item-pesanan').remove();

    hitungTotal();

}

function tambahPesanan(id,nama,isi,harga){

    let html = `

<div class="item-pesanan">

    <input type="hidden" name="detail_id[]" value="">

    <input type="hidden" name="produk_id[]" value="${id}">

    <input type="hidden" class="max-isi" value="${isi}">

    <input type="hidden" class="harga-produk" value="${harga}">

    <div class="d-flex justify-content-between align-items-start mb-2">

        <div>

            <strong>${nama}</strong>

            <div class="small text-muted">
                Rp ${harga.toLocaleString('id-ID')}
            </div>

        </div>

        <div class="badge-isi sisa-isi">
            ${isi}
        </div>

        <button
            type="button"
            class="btn btn-sm btn-danger"
            onclick="hapusItem(this)"
        >
            ✕
        </button>

    </div>

    <div class="row g-2">

        <div class="col-4">

            <small>Coklat</small>

            <small><input
                type="number"
                name="qty_coklat[]"
                class="form-control form-control-sm qty-coklat"
                value="0"
                oninput="updateSisa(this)"
            ></small>

        </div>

        <div class="col-4">

            <small>Matcha</small>

            <input
                type="number"
                name="qty_matcha[]"
                class="form-control form-control-sm qty-matcha"
                value="0"
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
    class="harga-topping"
    value="<?php echo $firstTop['harga'] ?? 0; ?>"
>

        </div>

    </div>

</div>

`;

    document
    .getElementById('daftarPesanan')
    .insertAdjacentHTML('beforeend', html);
    let items = document.querySelectorAll('.item-pesanan');
let lastItem = items[items.length - 1];

ubahTopping(
    lastItem.querySelector('.topping-select')
);

    hitungTotal();

}

// INIT
window.onload = function(){

    document
    .querySelectorAll('.item-pesanan')
    .forEach(function(item){

        updateSisa(
            item.querySelector('.qty-coklat')
        );

        let select =
            item.querySelector('.topping-select');

        if(select){
            ubahTopping(select);
        }

    });

    hitungTotal();

}

</script>

</body>
</html>