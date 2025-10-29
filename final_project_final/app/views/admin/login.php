<?php
// Helper function to safely escape output
function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
// Retrieve CSRF token from the session
$csrf_token = $_SESSION['csrf_token'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Use student styles for consistent login look, plus the warm theme -->
    <link rel="stylesheet" href="assets/css/student.css">
    <link rel="stylesheet" href="assets/css/theme.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>Admin Login</h1>
                <p>Enter your credentials to manage the site</p>
            </div>
            <?php if (isset($_GET['error'])): ?>
                <p class="error">Invalid email or password. Please try again.</p>
            <?php endif; ?>
            <form action="index.php?page=adminAuth" method="post" class="login-form" id="adminLoginForm" novalidate>
                <input type="hidden" name="csrf_token" value="<?php echo e($csrf_token); ?>">
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-full">Login</button>
            </form>
        </div>
    </div>
</body>
</html>