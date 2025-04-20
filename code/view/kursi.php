<?php
require_once '../config/db.php';
require_once '../class/Kursi.php';

$id_jadwal = $_GET['id_jadwal'] ?? null;

if (!$id_jadwal) {
    echo "Jadwal tidak ditemukan.";
    exit;
}

$kursi = new Kursi($conn);
$daftar_kursi = $kursi->getKursiByJadwal($id_jadwal);
?>

<h2>Daftar Kursi</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Nomor Kursi</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    <?php foreach ($daftar_kursi as $k) : ?>
        <tr>
            <td><?= $k['nomor_kursi'] ?></td>
            <td><?= $k['status'] ?></td>
            <td>
                <?php if ($k['status'] === 'tersedia') : ?>
                    <a href="proses_pilih_kursi.php?id_kursi=<?= $k['id_kursi'] ?>&id_jadwal=<?= $id_jadwal ?>">Pilih</a>
                <?php else : ?>
                    Terisi
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
