<?php
/**
 * Staff Module List View
 *
 * Displays a list of modules taught by a particular staff member.  The
 * controller passes the following variables:
 *   - $modules: array of modules with keys ProgrammeName, ModuleName, Year
 *   - $staffName: the full name of the staff member
 *   - $_GET['id']: the staff ID (used in links)
 */

function e($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modules Taught by <?= e($staffName) ?></title>
    <!-- Load staff and theme styles -->
    <link rel="stylesheet" href="assets/css/staff.css">
    <link rel="stylesheet" href="assets/css/theme.css">
</head>
<body>
    <!-- Staff header and navigation -->
    <header class="staff-header">
        <h1>Course Hub</h1>
    </header>
    <nav class="staff-nav">
        <a href="index.php?page=staffModules&amp;id=<?= (int)($_GET['id'] ?? 0) ?>" class="active">Modules</a>
        <a href="index.php?page=staffImpact&amp;id=<?= (int)($_GET['id'] ?? 0) ?>">Impact</a>
        <a href="index.php?page=programmes">Programmes</a>
        <a href="index.php?page=staff">Staff</a>
    </nav>

    <main class="main-content">
        <div class="staff-container">
            <h1>Modules Taught by <?= e($staffName) ?></h1>
            <?php if (empty($modules)): ?>
                <p>This staff member is not currently leading any modules.</p>
            <?php else: ?>
            <div class="staff-card">
            <table class="staff-card">
                    <tr>
                        <th>Programme</th>
                        <th>Module</th>
                        <th>Year</th>
                    </tr>
                    <?php foreach ($modules as $m): ?>
                        <tr>
                            <td><?= e($m['ProgrammeName']) ?></td>
                            <td><?= e($m['ModuleName']) ?></td>
                            <td><?= e($m['Year']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php endif; ?>
            <p class="back-link"><a href="index.php?page=staffImpact&amp;id=<?= (int)($_GET['id'] ?? 0) ?>">View Programme Impact</a></p>
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