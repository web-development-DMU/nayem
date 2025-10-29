<?php
// Helper to escape output for HTML safety
function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Staff</title>
    <!-- Load the student stylesheet and warm theme -->
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
                        <li><a href="index.php?page=staff" class="active">Staff</a></li>
                        <?php if (!empty($_SESSION['student'])): ?>
                            <li><a href="index.php?page=studentDashboard">Dashboard</a></li>
                            <li><a href="index.php?page=logout">Logout</a></li>
                        <?php else: ?>
                            <li><a href="index.php?page=studentLogin">Login</a></li>
                        <?php endif; ?>
                        <li><a href="index.php?page=adminLogin">Admin</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <h1>Meet Our Staff</h1>
            <p>Get to know the lecturers and professionals who lead our modules and programmes.</p>
            <?php if (empty($staffList)): ?>
                <p>No staff information is available at the moment.</p>
            <?php else: ?>
                <ul class="programme-list">
                    <?php foreach ($staffList as $st): ?>
                        <li class="programme-card">
                            <h2><?php echo e($st['Name'] ?? ''); ?></h2>
                            <?php if (!empty($st['Email'])): ?>
                                <p>Email: <a href="mailto:<?php echo e($st['Email']); ?>"><?php echo e($st['Email']); ?></a></p>
                            <?php endif; ?>
                            <?php if (!empty($st['Bio'])): ?>
                                <p><?php echo e($st['Bio']); ?></p>
                            <?php endif; ?>
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