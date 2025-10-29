<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interested Students</title>
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
            <h2>Interested Students</h2>
            <table class="admin-table">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registered At</th>
                </tr>
                <?php foreach ($students as $s): ?>
                    <tr>
                        <td><?= htmlspecialchars($s['StudentName']) ?></td>
                        <td><a href="mailto:<?= htmlspecialchars($s['Email']) ?>"><?= htmlspecialchars($s['Email']) ?></a></td>
                        <td><?= htmlspecialchars($s['RegisteredAt']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <form method="post" action="index.php?page=exportEmails">
                <input type="hidden" name="programmeId" value="<?= $programmeId ?>">
                <button type="submit">Export Emails to CSV</button>
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