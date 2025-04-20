<?php
session_start();
require_once 'config/db.php';
require_once 'class/Agen_bus.php';
require_once 'class/Bus.php';

// Create instances
$agenBus = new AgenBus();
$bus = new Bus();

// Get all agencies
$agencies = $agenBus->getAll();

include 'view/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Bus Agencies</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if (!empty($agencies)): ?>
                        <?php foreach ($agencies as $agency): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card border-0 shadow h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $agency['nama']; ?></h5>
                                        <p class="card-text">
                                            <strong><i class="bi bi-geo-alt-fill"></i> Address:</strong> <?php echo $agency['alamat']; ?>
                                        </p>
                                        <p class="card-text">
                                            <strong><i class="bi bi-telephone-fill"></i> Contact:</strong> <?php echo $agency['kontak']; ?>
                                        </p>
                                        
                                        <?php
                                        // Get all buses for this agency
                                        $buses = $bus->getByAgen($agency['id_agen']);
                                        ?>
                                        
                                        <hr>
                                        <h6>Available Buses: <?php echo count($buses); ?></h6>
                                        
                                        <?php if (!empty($buses)): ?>
                                            <ul class="list-group list-group-flush">
                                                <?php foreach ($buses as $b): ?>
                                                    <li class="list-group-item">
                                                        <?php echo $b['nama']; ?> (<?php echo $b['kelas']; ?>) - <?php echo $b['jumlah_kursi']; ?> seats
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p class="text-muted">No buses available for this agency.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-info">No bus agencies found.</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'view/footer.php'; ?>