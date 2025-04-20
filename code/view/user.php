<?php
session_start();
require_once 'config/db.php';
require_once 'class/User.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$error = '';

// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        $user = new User();
        
        // Get user by email
        $userModel = new User();
        $userData = $userModel->getUserByEmail($email);
        
        if ($userData && password_verify($password, $userData['password'])) {
            // Set session
            $_SESSION['user_id'] = $userData['id_user'];
            $_SESSION['user_name'] = $userData['nama'];
            $_SESSION['user_email'] = $userData['email'];
            
            // Redirect to home page
            header('Location: index.php');
            exit();
        } else {
            $error = 'Invalid email or password';
        }
    }
}

include 'view/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Login</h5>
            </div>
            <div class="card-body">
                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
                
                <div class="mt-3 text-center">
                    <p>Don't have an account? <a href="register.php">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'view/footer.php'; ?>