<?php
session_start();
require_once 'config/db.php';
require_once 'class/Jadwal.php';
require_once 'class/Terminal.php';

// Create instances
$jadwal = new Jadwal();
$terminal = new Terminal();

// Get all terminals for the filter
$terminals = $terminal->getAll();

// Default filter
$filter = [
    'asal' => '',
    'tujuan' => '',
    'tanggal' => date('Y-m-d')
];

// Process filter
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['filter'])) {
    if (!empty($_GET['asal'])) {
        $filter['asal'] = $_GET['asal'];
    }
    if (!empty($_GET['tujuan'])) {
        $filter['tujuan'] = $_GET['tujuan'];
    }
    if (!empty($_GET['tanggal'])) {
        $filter['tanggal'] = $_GET['tanggal'];
    }
}

// Get schedules based on filter
$schedules = [];
if (!empty($filter['asal']) && !empty($filter['tujuan'])) {
    $schedules = $jadwal->getByRute($filter['asal'], $filter['tujuan'], $filter['tanggal']);
} else {
    // Get all schedules if no filter is applied
    $schedules = $jadwal->getAll();
}

include 'view/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Bus Schedules</h5>
            </div>
            <div class="card-body">
                <!-- Filter Form -->
                <form method="get" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="asal" class="form-label">From</label>
                            <select name="asal" id="asal" class="form-select">
                                <option value="">-- All Origins --</option>
                                <?php foreach ($terminals as $term): ?>
                                    <option value="<?php echo $term['id_terminal']; ?>" <?php echo ($filter['asal'] == $term['id_terminal']) ? 'selected' : ''; ?>>
                                        <?php echo $term['nama'] . ' (' . $term['lokasi'] . ')'; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="tujuan" class="form-label">To</label>
                            <select name="tujuan" id="tujuan" class="form-select">
                                <option value="">-- All Destinations --</option>
                                <?php foreach ($terminals as $term): ?>
                                    <option value="<?php echo $term['id_terminal']; ?>" <?php echo ($filter['tujuan'] == $term['id_terminal']) ? 'selected' : ''; ?>>
                                        <?php echo $term['nama'] . ' (' . $term['lokasi'] . ')'; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="tanggal" class="form-label">Date</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" 
                                   value="<?php echo $filter['tanggal']; ?>" min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" name="filter" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
                </form>
                
                <!-- Schedules Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Bus Name</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($schedules)): ?>
                                <?php foreach ($schedules as $schedule): ?>
                                    <tr>
                                        <td><?php echo $schedule['nama_bus']; ?></td>
                                        <td><?php echo $schedule['terminal_asal_nama']; ?></td>
                                        <td><?php echo $schedule['terminal_tujuan_nama']; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($schedule['tanggal_berangkat'])); ?></td>
                                        <td><?php echo date('H:i', strtotime($schedule['jam_berangkat'])); ?></td>
                                        <td>Rp <?php echo number_format($schedule['harga'], 0, ',', '.'); ?></td>
                                        <td>
                                            <a href="booking.php?id=<?php echo $schedule['id_jadwal']; ?>" class="btn btn-sm btn-success">Book Now</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No schedules found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>