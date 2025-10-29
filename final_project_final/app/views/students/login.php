<?php
// Helper function to escape output safely
function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <!-- Load student styles and warm theme -->
    <link rel="stylesheet" href="assets/css/student.css">
    <link rel="stylesheet" href="assets/css/theme.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>Student Login</h1>
                <p>Sign in to manage your interests</p>
            </div>
            <?php if (isset($_GET['error'])): ?>
                <p class="error">Invalid email or password. Please try again.</p>
            <?php endif; ?>
            <form action="index.php?page=studentAuth" method="post" class="login-form" id="loginForm" novalidate>
                <!-- CSRF token to prevent cross‑site request forgery -->
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8'); ?>">
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
            <div class="login-footer">
                <a href="index.php?page=registerInterestForm">Don’t have an account? Register here</a>
            </div>
        </div>
    </div>
    <!-- Include student.js for client-side validation -->
    <script src="assets/js/student.js"></script>
</body>
</html>