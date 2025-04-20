<?php
session_start();
require_once 'config/db.php';
require_once 'class/Terminal.php';

// Create a new Terminal instance
$terminal = new Terminal();

// Get all terminals
$terminals = $terminal->getAll();

include 'view/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Bus Terminals</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Terminal Name</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($terminals)): ?>
                                <?php $i = 1; foreach ($terminals as $t): ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $t['nama']; ?></td>
                                        <td><?php echo $t['lokasi']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center">No terminals found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'view/footer.php'; ?>