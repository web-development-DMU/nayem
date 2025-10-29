<?php
/**
 * Staff Programme Impact View
 *
 * Shows how many modules each programme contains that are taught by the
 * specified staff member.  Variables passed from the controller:
 *   - $impact: associative array keyed by ProgrammeID with ProgrammeName
 *              and ModuleCount fields
 *   - $staffName: full name of the staff member
 *   - $_GET['id']: the staff ID for navigation links
 */

function e($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programme Impact for <?= e($staffName) ?></title>
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
        <a href="index.php?page=staffModules&amp;id=<?= (int)($_GET['id'] ?? 0) ?>">Modules</a>
        <a href="index.php?page=staffImpact&amp;id=<?= (int)($_GET['id'] ?? 0) ?>" class="active">Impact</a>
        <a href="index.php?page=programmes">Programmes</a>
        <a href="index.php?page=staff">Staff</a>
    </nav>

    <main class="main-content">
        <div class="staff-container">
            <h1>Programme Impact for <?= e($staffName) ?></h1>
            <?php if (empty($impact)): ?>
                <p>This staff member does not impact any programmes at present.</p>
            <?php else: ?>
                <div class="staff-card">
                <table class="staff-card">
                    <tr>
                        <th>Programme</th>
                        <th>Number of Modules Taught</th>
                    </tr>
                    <?php foreach ($impact as $pid => $info): ?>
                        <tr>
                            <td><?= e($info['ProgrammeName']) ?></td>
                            <td><?= (int)$info['ModuleCount'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php endif; ?>
            <p class="back-link"><a href="index.php?page=staffModules&amp;id=<?= (int)($_GET['id'] ?? 0) ?>">Back to Modules</a></p>
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