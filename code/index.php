<?php
session_start();
require_once 'config/db.php';
require_once 'class/Terminal.php';
require_once 'class/Jadwal.php';

$terminal = new Terminal();
$terminals = $terminal->getAll();

// Process search form if submitted
$schedules = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jadwal = new Jadwal();
    $asal = $_POST['asal'];
    $tujuan = $_POST['tujuan'];
    $tanggal = $_POST['tanggal'];
    
    // Validate that origin and destination are different
    if ($asal === $tujuan) {
        $error = "Origin and destination terminals cannot be the same";
    } else {
        $schedules = $jadwal->getByRute($asal, $tujuan, $tanggal);
    }
}

include 'view/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="jumbotron bg-light p-5 rounded">
            <h1 class="display-4">Welcome to Bus Ticket Booking</h1>
            <p class="lead">Find and book your bus tickets for a comfortable journey.</p>
            <hr class="my-4">
            
            <div class="search-box p-4 bg-white shadow rounded">
                <h4 class="mb-4">Search for Bus Tickets</h4>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="post" action="">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="asal" class="form-label">From</label>
                            <select name="asal" id="asal" class="form-select" required>
                                <option value="">-- Select Origin --</option>
                                <?php foreach ($terminals as $term): ?>
                                    <option value="<?php echo $term['id_terminal']; ?>" <?php echo (isset($_POST['asal']) && $_POST['asal'] == $term['id_terminal']) ? 'selected' : ''; ?>>
                                        <?php echo $term['nama'] . ' (' . $term['lokasi'] . ')'; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="tujuan" class="form-label">To</label>
                            <select name="tujuan" id="tujuan" class="form-select" required>
                                <option value="">-- Select Destination --</option>
                                <?php foreach ($terminals as $term): ?>
                                    <option value="<?php echo $term['id_terminal']; ?>" <?php echo (isset($_POST['tujuan']) && $_POST['tujuan'] == $term['id_terminal']) ? 'selected' : ''; ?>>
                                        <?php echo $term['nama'] . ' (' . $term['lokasi'] . ')'; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="tanggal" class="form-label">Departure Date</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" 
                                   value="<?php echo isset($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d'); ?>" 
                                   min="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Search Tickets</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <?php if (!empty($schedules)): ?>
                <div class="mt-4">
                    <h4>Available Schedules</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Bus Name</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Class</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($schedules as $schedule): ?>
                                    <tr>
                                        <td><?php echo $schedule['nama_bus']; ?></td>
                                        <td><?php echo $schedule['terminal_asal_nama']; ?></td>
                                        <td><?php echo $schedule['terminal_tujuan_nama']; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($schedule['tanggal_berangkat'])); ?></td>
                                        <td><?php echo date('H:i', strtotime($schedule['jam_berangkat'])); ?></td>
                                        <td><?php echo $schedule['kelas']; ?></td>
                                        <td>Rp <?php echo number_format($schedule['harga'], 0, ",", "."); ?></td>
                                        <td>
                                            <a href="booking.php?id=<?php echo $schedule['id_jadwal']; ?>" class="btn btn-sm btn-success">Book Now</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-4">
        <div class="card border-0 shadow">
            <div class="card-body text-center">
                <i class="bi bi-search fs-1 text-primary mb-3"></i>
                <h5 class="card-title">Search Tickets</h5>
                <p class="card-text">Find the perfect bus for your journey. Search by destination, date, and time.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow">
            <div class="card-body text-center">
                <i class="bi bi-credit-card fs-1 text-primary mb-3"></i>
                <h5 class="card-title">Easy Payment</h5>
                <p class="card-text">Multiple payment methods available for your convenience.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow">
            <div class="card-body text-center">
                <i class="bi bi-ticket-perforated fs-1 text-primary mb-3"></i>
                <h5 class="card-title">E-Tickets</h5>
                <p class="card-text">Get your tickets delivered instantly to your email.</p>
            </div>
        </div>
    </div>
</div>

<?php include 'view/footer.php'; ?>