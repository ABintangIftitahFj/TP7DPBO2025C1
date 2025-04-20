<?php
require_once '../config/db.php';
require_once '../class/Pembayaran.php';
require_once '../class/Pembelian.php';

$id_pembelian = $_GET['id_pembelian'] ?? null;

if (!$id_pembelian) {
    echo "ID Pembelian tidak ditemukan.";
    exit;
}

$pembayaran = new Pembayaran($conn);
$data_pembayaran = $pembayaran->getByPembelian($id_pembelian);

?>

<h2>Status Pembayaran</h2>

<?php if ($data_pembayaran) : ?>
    <p>Metode: <?= $data_pembayaran['metode'] ?></p>
    <p>Status: <?= $data_pembayaran['status'] ?></p>
    <p>Waktu Bayar: <?= $data_pembayaran['waktu_bayar'] ?? '-' ?></p>

    <?php if ($data_pembayaran['status'] === 'belum dibayar') : ?>
        <form action="proses_bayar.php" method="POST">
            <input type="hidden" name="id_pembayaran" value="<?= $data_pembayaran['id_pembayaran'] ?>">
            <label>Pilih Metode Pembayaran:
                <select name="metode">
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="E-Wallet">E-Wallet</option>
                    <option value="Kartu Kredit">Kartu Kredit</option>
                </select>
            </label>
            <br><br>
            <button type="submit">Bayar Sekarang</button>
        </form>
    <?php endif; ?>

<?php else : ?>
    <p>Tidak ada data pembayaran ditemukan untuk pembelian ini.</p>
<?php endif; ?>
