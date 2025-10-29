<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Programme</title>
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
            <h2>Edit Programme</h2>
            <?php if (!$programme): ?>
                <p>Programme not found.</p>
            <?php else: ?>
                <form action="index.php?page=updateProgramme" method="post">
                    <input type="hidden" name="programmeId" value="<?= (int)$programme['ProgrammeID'] ?>">
                    <label for="programmeName">Programme Name</label>
                    <input type="text" id="programmeName" name="programmeName" value="<?= htmlspecialchars($programme['ProgrammeName']) ?>" required>

                    <label for="levelId">Level</label>
                    <select id="levelId" name="levelId" required>
                        <?php foreach ($levels as $level): ?>
                            <option value="<?= (int)$level['LevelID'] ?>" <?= ($programme['LevelID'] == $level['LevelID']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($level['LevelName']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($programme['Description']) ?></textarea>

                    <label for="image">Image URL (optional)</label>
                    <input type="text" id="image" name="image" value="<?= htmlspecialchars($programme['Image']) ?>">

                    <button type="submit">Update Programme</button>
                </form>
            <?php endif; ?>
            <div class="back-link"><a href="index.php?page=adminDashboard">Back to Dashboard</a></div>
        </div>
    </main>
    <footer class="site-footer">
        <div class="container">
            <p>&copy; 2025 Student Course Hub Admin. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>