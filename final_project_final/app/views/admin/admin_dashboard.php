<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
                        <li><a href="index.php?page=adminDashboard" class="active">Dashboard</a></li>
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
            <h2>Admin Dashboard</h2>
            <p><a class="add-btn" href="index.php?page=addProgrammeForm">+ Add New Programme</a></p>
            <p><a class="add-btn" href="index.php?page=mailingList">📤 View Mailing List Of Interested Students</a></p>

            <table class="admin-table">
                <tr>
                    <th>Programme Name</th>
                    <th>Level</th>
                    <th>Published</th>
                    <th>Actions</th>
                </tr>

                <?php foreach ($programmes as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['ProgrammeName']) ?></td>
                        <td><?= htmlspecialchars($p['LevelName']) ?></td>
                        <td><?= $p['is_published'] ? 'Yes' : 'No' ?></td>
                        <td>
                            <a class="action-btn edit-btn" href="index.php?page=editProgramme&id=<?= $p['ProgrammeID'] ?>">Edit</a>
                            <a class="action-btn delete-btn" href="index.php?page=deleteProgramme&id=<?= $p['ProgrammeID'] ?>"
                                onclick="return confirm('Are you sure you want to delete this programme?');">Delete</a>
                            <a class="action-btn edit-btn" href="index.php?page=programmeModules&id=<?= $p['ProgrammeID'] ?>">Manage Modules</a>
                            <a class="action-btn edit-btn" href="index.php?page=togglePublish&id=<?= $p['ProgrammeID'] ?>"
                                onclick="return confirm('Toggle publish status for this programme?');">
                                <?= $p['is_published'] ? 'Unpublish' : 'Publish' ?>
                            </a>
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
</body>
</html>