<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Module Leader</title>
    <!-- Load admin and theme styles -->
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/theme.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="index.php?page=adminDashboard" style="color: white; font-weight: bold; font-size: 1.4rem; text-decoration: none;">Admin Panel</a>
                </div>
                <nav class="main-nav">
                    <ul>
                        <li><a href="index.php?page=adminDashboard">Dashboard</a></li>
                        <li><a href="index.php?page=addProgrammeForm">Add Programme</a></li>
                        <li><a href="index.php?page=mailingList">Mailing List</a></li>
                        <li><a href="index.php?page=programmes">View Site</a></li>
                        <li><a href="index.php?page=adminLogout">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main class="main-content">
        <div class="container">
            <h2>Assign Module Leader</h2>
            <?php if (isset($module)): ?>
                <p><strong>Assigning Leader to:</strong> <?= htmlspecialchars($module['ModuleName']) ?></p>
            <?php endif; ?>
            <form method="post" action="index.php?page=assignModuleLeader">
                <input type="hidden" name="moduleId" value="<?= $module['ModuleID'] ?>">
                <input type="hidden" name="programmeId" value="<?= $programmeId ?>">
                <label for="staffId">Select Module Leader:</label>
                <select name="staffId" id="staffId" required>
                    <?php foreach ($staff as $s): ?>
                        <option value="<?= $s['StaffID'] ?>">
                            <?= htmlspecialchars($s['Name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Assign Leader</button>
            </form>
            <div class="back-link"><a href="index.php?page=programmeModules&id=<?= $programmeId ?>">Back to Programme Modules</a></div>
        </div>
    </main>
    <footer class="site-footer">
        <div class="container">
            <p>&copy; 2025 Student Course Hub Admin. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>