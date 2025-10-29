<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mailing List</title>
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
                        <li><a href="index.php?page=mailingList" class="active">Mailing List</a></li>
                        <li><a href="index.php?page=programmes">View Site</a></li>
                        <li><a href="index.php?page=adminLogout">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main class="main-content">
        <div class="container">
            <h2>Mailing List</h2>
            <p><a class="add-btn" href="index.php?page=downloadCSV">Download CSV</a></p>
            <table class="admin-table">
                <tr>
                    <th>Programme</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Registered At</th>
                </tr>
                <?php foreach ($students as $s): ?>
                    <tr>
                        <td><?= htmlspecialchars($s['ProgrammeName']) ?></td>
                        <td><?= htmlspecialchars($s['StudentName']) ?></td>
                        <td><?= htmlspecialchars($s['Email']) ?></td>
                        <td><?= htmlspecialchars($s['RegisteredAt']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
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