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
    <title>Student Dashboard</title>
    <!-- Load the student styles and the warm theme -->
    <link rel="stylesheet" href="assets/css/student.css">
    <link rel="stylesheet" href="assets/css/theme.css">
</head>
<body>
    <!-- Site header with navigation -->
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="index.php?page=programmes" style="color: white; font-weight: bold; font-size: 1.4rem; text-decoration: none;">Course Hub</a>
                </div>
                <nav class="main-nav">
                    <ul>
                        <li><a href="index.php?page=programmes">Programmes</a></li>
                        <li><a href="index.php?page=staff">Staff</a></li>
                        <li><a href="index.php?page=studentDashboard" class="active">Dashboard</a></li>
                        <li><a href="index.php?page=adminLogin">Admin</a></li>
                        <li><a href="index.php?page=logout">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <h1>Welcome, <?php echo e($_SESSION['student']['name'] ?? 'Student'); ?></h1>
            <p>Below is a list of programmes you have registered interest in.</p>
            <?php if (empty($registrations)): ?>
                <p>You have not registered interest in any programmes yet.</p>
            <?php else: ?>
                <ul class="registration-list">
                    <?php foreach ($registrations as $reg): ?>
                        <li class="registration-item">
                            <strong><?php echo e($reg['ProgrammeName']); ?></strong><br>
                            <span><?php echo e($reg['Description']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <p>Email: <a href="mailto:admissions@example.edu">admissions@example.edu</a></p>
                    <p>Phone: +44 (0) 123 456 7890</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Accessibility</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Follow Us</h3>
                    <ul class="social-links">
                        <li><a href="#" aria-label="Facebook">Facebook</a></li>
                        <li><a href="#" aria-label="Twitter">Twitter</a></li>
                        <li><a href="#" aria-label="LinkedIn">LinkedIn</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Student Course Hub. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>