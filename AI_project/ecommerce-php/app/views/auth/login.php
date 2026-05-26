<?php
require APP_ROOT . '/app/helpers.php';

ob_start();

$title = 'Login';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields';
    } elseif (!isValidEmail($email)) {
        $error = 'Please enter a valid email';
    } else {
        $userModel = new User();
        $result = $userModel->login($email, $password);

        if ($result['success']) {
            $_SESSION['user_id'] = $result['user']['id'];
            $_SESSION['user'] = $result['user'];
            setFlash('success', 'Login successful!');
            redirect('home');
        } else {
            $error = $result['message'];
        }
    }
}
?>

<div style="max-width: 400px; margin: 2rem auto;">
    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; margin-bottom: 1.5rem;">Login</h2>

        <form method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <input type="hidden" name="action" value="login">
            <button type="submit" class="btn btn-primary" style="font-size: 1rem;">Login</button>
        </form>

        <p style="text-align: center; margin-top: 1.5rem;">
            Don't have an account? <a href="<?php echo getConfig('app_url'); ?>/?page=register" style="color: #667eea;">Register here</a>
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
include APP_ROOT . '/app/views/layouts/main.php';
?>
