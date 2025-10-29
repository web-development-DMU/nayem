<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Your Interest</title>
    <!-- Load student styles and warm theme -->
    <link rel="stylesheet" href="assets/css/student.css">
    <link rel="stylesheet" href="assets/css/theme.css">
</head>
<body>
    <!-- Header -->
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
            <section class="interest-form-section">
                <div class="section-header">
                    <h1>Register Your Interest</h1>
                </div>

                <!-- Display error messages if present -->
                <?php if (isset($_GET['error'])): ?>
                    <p class="error">
                        <?php
                            switch ($_GET['error']) {
                                case 'password_mismatch':
                                    echo '❌ Passwords do not match.';
                                    break;
                                case 'email_exists':
                                    echo '❌ Email already registered.';
                                    break;
                                case 'missing_fields':
                                    echo '❌ Please fill in all required fields.';
                                    break;
                                default:
                                    echo '❌ Something went wrong. Please try again.';
                            }
                        ?>
                    </p>
                <?php endif; ?>

                <form method="post" action="index.php?page=registerInterest" id="interestForm" novalidate>
                    <!-- CSRF token for security -->
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="programmeId">Select Programme:</label>
                        <select name="programmeId" id="programmeId" required>
                            <?php foreach ($programmes as $p): ?>
                                <option value="<?= $p['ProgrammeID'] ?>">
                                    <?= htmlspecialchars($p['ProgrammeName']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Create Password:</label>
                        <input type="password" name="password" id="password" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" name="confirm_password" id="confirm_password" required minlength="6">
                    </div>
                    <div class="form-group checkbox-group">
                        <input type="checkbox" id="consent" required>
                        <label for="consent">I consent to my data being processed for course information.</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">Register Interest</button>
                </form>
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

    <!-- Include student.js for form validation -->
    <script src="assets/js/student.js"></script>
</body>
</html>