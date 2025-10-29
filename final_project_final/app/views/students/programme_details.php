<?php
// Escape helper
function e($text) {
    return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($programme['ProgrammeName']); ?> - Student Course Hub</title>
    <!-- Load styles for student pages and the warm theme -->
    <link rel="stylesheet" href="assets/css/student.css">
    <link rel="stylesheet" href="assets/css/theme.css">
</head>
<body>
    <!-- Header with navigation -->
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
                        <li><a href="index.php?page=studentDashboard">Dashboard</a></li>
                        <li><a href="index.php?page=adminLogin">Admin</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            <section class="programme-details">
                <h1><?php echo e($programme['ProgrammeName']); ?></h1>

                <!-- Description -->
                <p><?php echo nl2br(e($programme['Description'])); ?></p>

                <!-- Programme Image -->
                <?php if (!empty($programme['Image'])): ?>
                    <img src="<?php echo e($programme['Image']); ?>" alt="<?php echo e($programme['ProgrammeName']); ?> image">
                <?php endif; ?>

                <!-- Programme Leader -->
                <h2>Programme Leader</h2>
                <p><?php echo e($leader['Name'] ?? 'Not assigned'); ?></p>

                <!-- Modules by Year -->
                <h2>Modules by Year</h2>
                <?php foreach ($modules as $year => $yearModules): ?>
                    <h3 class="year-heading" data-year="<?= e($year) ?>">
                        Year <?= e($year) ?> <span class="toggle-indicator">&#9654;</span>
                    </h3>
                    <ul class="module-list" style="display:none;">
                        <?php foreach ($yearModules as $module): ?>
                            <li>
                                <strong><?= e($module['ModuleName']) ?></strong><br>
                                <?= nl2br(e($module['Description'])) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>

                <!-- Actions -->
                <div class="form-actions">
                    <a href="index.php?page=programmes" class="btn btn-secondary">Back to Programmes</a>
                    <a href="index.php?page=registerInterestForm" class="btn btn-primary">Register Interest</a>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer -->
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

    <!-- Include our JavaScript for toggling modules -->
    <script src="assets/js/student.js"></script>
</body>
</html>