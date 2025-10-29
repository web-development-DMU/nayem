<?php
function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programme List</title>
    <!-- Load the student base CSS and the warm theme CSS -->
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
                        <li><a href="index.php?page=programmes" class="active">Programmes</a></li>
                        <li><a href="index.php?page=staff">Staff</a></li>
                        <li><a href="index.php?page=studentLogin">Login</a></li>
                        <li><a href="index.php?page=adminLogin">Admin</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container">

            <!-- Hero section welcoming students -->
            <section class="hero">
                <h1>Welcome to Programme Explorer</h1>
                <p>Discover your future. Explore university programmes, meet faculty, and register your interest in just a few clicks.</p>
            </section>

            <!-- Quick action tiles -->
            <section class="tiles">
                <a href="index.php?page=studentLogin" class="tile">
                    <span class="icon">🎓</span>
                    <span>Student Login</span>
                </a>
                <a href="index.php?page=registerInterestForm" class="tile">
                    <span class="icon">➕</span>
                    <span>Sign Up</span>
                </a>
                <a href="index.php?page=programmes" class="tile">
                    <span class="icon">🧭</span>
                    <span>Explore Programmes</span>
                </a>
            </section>

            <!-- Featured Programmes -->
            <?php
                // Select the first three programmes as featured
                $featuredProgrammes = array_slice($programmes, 0, 3);
            ?>
            <?php if (!empty($featuredProgrammes)): ?>
            <section class="section-featured">
                <h2>Featured Programmes</h2>
                <div class="cards">
                    <?php foreach ($featuredProgrammes as $fp):
                        $fid   = (int) ($fp['ProgrammeID'] ?? 0);
                        $fname = e($fp['ProgrammeName']);
                        $fdesc = e($fp['Description']);
                    ?>
                    <div class="card">
                        <h3><?php echo $fname; ?></h3>
                        <p><?php echo nl2br($fdesc); ?></p>
                        <a href="index.php?page=programme&id=<?php echo $fid; ?>">Explore</a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <!-- Upcoming events -->
            <section class="section-events">
                <h2>Upcoming Events</h2>
                <ul class="events-list">
                    <li>🎤 Guest Lecture: "Future of AI" – Oct 10</li>
                    <li>📢 Interest Registration Deadline – Oct 15</li>
                    <li>🧪 Module Showcase Week – Oct 20–24</li>
                </ul>
            </section>

            <h1>Available Programmes</h1>

            <?php if (empty($programmes)): ?>
                <p>No programmes are available at the moment. Please check back later.</p>
            <?php else: ?>
                <!-- Search and filter controls -->
                <div class="filter-bar">
                    <div>
                        <label for="programmeSearch">Search Programmes:</label>
                        <input type="text" id="programmeSearch" placeholder="Search by name or description" />
                    </div>
                    <div>
                        <label for="levelFilter">Filter by Level:</label>
                        <select id="levelFilter">
                            <option value="all">All Levels</option>
                            <?php foreach ($levels as $level): ?>
                                <option value="<?= (int) ($level['LevelID'] ?? 0) ?>">
                                    <?= htmlspecialchars($level['LevelName']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <ul class="programme-list" id="programmeList">
                    <?php foreach ($programmes as $programme):
                        $id    = (int) ($programme['ProgrammeID'] ?? 0);
                        $name  = e($programme['ProgrammeName']);
                        $desc  = e($programme['Description']);
                        $img   = !empty($programme['Image']) ? e($programme['Image']) : null;
                        $level = (int) ($programme['LevelID'] ?? 0);
                    ?>
                        <li class="programme-card" data-name="<?= strtolower($name) ?>" data-description="<?= strtolower($desc) ?>" data-level="<?= $level ?>">
                            <?php if ($img): ?>
                                <img src="<?php echo $img; ?>" alt="<?php echo $name; ?>" class="programme-image">
                            <?php else: ?>
                                <div class="programme-image placeholder">No image</div>
                            <?php endif; ?>

                            <h2><?php echo $name; ?></h2>
                            <p><?php echo $desc; ?></p>
                            <a href="index.php?page=programme&id=<?php echo $id; ?>" class="btn btn-primary">View details</a>
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

    <!-- Include student.js for search and filter functionality -->
    <script src="assets/js/student.js"></script>
</body>
</html>
