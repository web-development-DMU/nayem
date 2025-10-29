<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Modules</title>
    <!-- Load admin and theme styles -->
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/theme.css">
    <style>
        /* Inline styles for popup; keep separate for quick styling */
        #successPopup {
            background-color: #d4edda;
            color: #155724;
            padding: 10px 20px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            font-weight: bold;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
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
            <?php if ($programme && is_array($programme)): ?>
                <h2>Modules for <?= htmlspecialchars($programme['ProgrammeName']) ?></h2>
                <p><a class="add-btn" href="index.php?page=viewInterestedStudents&id=<?= $programme['ProgrammeID'] ?>">📄 View Interested Students</a></p>
            <?php else: ?>
                <p style="color: red; font-weight: bold;">⚠️ Programme not found or invalid ID.</p>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                <div id="successPopup">
                    Module leader assigned successfully.
                </div>
            <?php endif; ?>

            <form method="post" action="index.php?page=assignModule">
                <input type="hidden" name="programmeId" value="<?= $programme['ProgrammeID'] ?>">

                <label>Select Module:</label>
                <select name="moduleId" required>
                    <?php foreach ($allModules as $m): ?>
                        <option value="<?= $m['ModuleID'] ?>">
                            <?= htmlspecialchars($m['ModuleName']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Year:</label>
                <select name="year">
                    <option value="1">Year 1</option>
                    <option value="2">Year 2</option>
                    <option value="3">Year 3</option>
                </select>

                <button type="submit">Assign Module</button>
            </form>

            <h3>Assigned Modules</h3>

            <table class="admin-table">
                <tr>
                    <th>Year</th>
                    <th>Module Name</th>
                    <th>Code</th>
                    <th>Actions</th>
                </tr>
                <?php foreach ($assigned as $a): ?>
                    <tr>
                        <td>Year <?= $a['Year'] ?></td>
                        <td>
                            <?= htmlspecialchars($a['ModuleName']) ?><br>
                            <small>
                                <strong>Leader:</strong>
                                <?= !empty($a['LeaderName']) ? htmlspecialchars($a['LeaderName']) : '<em>Not assigned</em>'; echo '<br>'; ?>
                                <?php if (($a['UsageCount'] ?? 0) > 1): ?>
                                    <span style="color: #aa00aa;">🔁 Shared Module (used in <?= $a['UsageCount'] ?> programmes)</span><br>
                                    <strong>Also used in:</strong>
                                    <ul style="margin: 5px 0; padding-left: 15px;">
                                        <?php foreach ($a['UsedInProgrammes'] as $p): ?>
                                            <?php if ($p['ProgrammeID'] != $programme['ProgrammeID']): ?>
                                                <li><?= htmlspecialchars($p['ProgrammeName']) ?></li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </small>
                        </td>
                        <td><?= $a['ModuleID'] ?></td>
                        <td>
                            <a class="action-btn edit-btn" href="index.php?page=assignModuleLeaderForm&id=<?= $a['ModuleID'] ?>">Assign Leader</a>
                            <a class="action-btn delete-btn" href="index.php?page=removeModule&programmeId=<?= $programme['ProgrammeID'] ?>&moduleId=<?= $a['ModuleID'] ?>"
                                onclick="return confirm('Remove this module?');">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            <p>&copy; 2025 Student Course Hub Admin. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const popup = document.getElementById('successPopup');
        if (popup) {
            setTimeout(() => {
                popup.style.display = 'none';
            }, 3000);
        }
    </script>
</body>
</html>