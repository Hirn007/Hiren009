<?php
require APP_ROOT . '/app/helpers.php';

ob_start();

$title = 'Register';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $firstName = sanitize($_POST['firstName'] ?? '');
    $lastName = sanitize($_POST['lastName'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $phone = sanitize($_POST['phone'] ?? '');

    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($phone)) {
        setFlash('error', 'Please fill in all fields');
        redirect('register');
    } elseif (!isValidEmail($email)) {
        setFlash('error', 'Please enter a valid email');
        redirect('register');
    } elseif ($password !== $confirmPassword) {
        setFlash('error', 'Passwords do not match');
        redirect('register');
    } elseif (strlen($password) < 6) {
        setFlash('error', 'Password must be at least 6 characters');
        redirect('register');
    } else {
        $userModel = new User();
        
        if ($userModel->emailExists($email)) {
            setFlash('error', 'Email already registered');
            redirect('register');
        } else {
            $result = $userModel->register($firstName, $lastName, $email, $password, $phone);

            if ($result['success']) {
                setFlash('success', 'Registration successful! Please login.');
                redirect('login');
            } else {
                setFlash('error', $result['message']);
                redirect('register');
            }
        }
    }
}
?>

<div style="max-width: 500px; margin: 2rem auto;">
    <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <h2 style="text-align: center; margin-bottom: 1.5rem;">Create Account</h2>


        <form method="POST">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" required>
                </div>

                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <input type="hidden" name="action" value="register">
            <button type="submit" class="btn btn-primary" style="font-size: 1rem;">Create Account</button>
        </form>

        <p style="text-align: center; margin-top: 1.5rem;">
            Already have an account? <a href="<?php echo getConfig('app_url'); ?>/?page=login" style="color: #667eea;">Login here</a>
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
include APP_ROOT . '/app/views/layouts/main.php';
?>
