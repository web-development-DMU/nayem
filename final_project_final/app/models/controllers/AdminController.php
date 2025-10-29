<?php
require_once(__DIR__ . '/../models/programme.php');

class AdminController
{
    /**
     * Ensure that an admin is logged in.  If no admin session is present,
     * redirect to the admin login page.  This helper should be called at the
     * beginning of all admin‑restricted actions.
     */
    private static function requireLogin()
    {
        if (empty($_SESSION['admin'])) {
            header('Location: index.php?page=adminLogin');
            exit;
        }
    }

    /**
     * Show the admin login form.  If an admin is already authenticated,
     * redirect to the dashboard.  The view uses a CSRF token for security.
     */
    public static function loginForm($pdo)
    {
        if (!empty($_SESSION['admin'])) {
            header('Location: index.php?page=adminDashboard');
            exit;
        }
        // Provide CSRF token for the login form
        $csrf_token = $_SESSION['csrf_token'] ?? '';
        include(__DIR__ . '/../views/admin/login.php');
    }

    /**
     * Handle admin login form submission.  Look up the admin by email and
     * validate the provided password against the stored hash.  On success,
     * set session variables and redirect to the dashboard; otherwise
     * redirect back with an error flag.
     */
    public static function handleLogin($pdo)
    {
        // Validate CSRF token
        $token = $_POST['csrf_token'] ?? '';
        if (empty($token) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(400);
            echo 'Invalid form submission. Please reload the page and try again.';
            exit;
        }
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Look up the admin record by email
        $stmt = $pdo->prepare('SELECT * FROM Admins WHERE Email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // Compare supplied password to stored hash using md5.  In a full
        // production system you would use password_hash() and password_verify(),
        // but for this demo the hashes are stored as MD5.  hash_equals()
        // mitigates timing attacks.
        if ($admin && hash_equals($admin['PasswordHash'], md5($password))) {
            $_SESSION['admin'] = [
                'id'    => $admin['AdminID'],
                'name'  => $admin['Name'],
                'email' => $admin['Email']
            ];
            header('Location: index.php?page=adminDashboard');
            exit;
        }
        // Invalid credentials; redirect back to login with error
        header('Location: index.php?page=adminLogin&error=1');
        exit;
    }

    /**
     * Log out the current admin user.  Clears the admin session and
     * redirects to the admin login page.
     */
    public static function logout()
    {
        unset($_SESSION['admin']);
        header('Location: index.php?page=adminLogin');
        exit;
    }
    public static function dashboard($pdo)
    {
        self::requireLogin();
        $programmes = Programme::all($pdo);
        $modules = Programme::allModules($pdo);
        include(__DIR__ . '/../views/admin/admin_dashboard.php');
    }



    public static function editProgramme($pdo, $id)
    {
        self::requireLogin();
        $programme = Programme::find($pdo, $id);
        if (!$programme) {
            http_response_code(404);
            include(__DIR__ . '/../views/error/404.php');
            return;
        }

        include(__DIR__ . '/../views/admin/editProgrammeForm.php');
    }

    public static function updateProgramme($pdo)
    {
        self::requireLogin();
        // Use programmeId (hidden input name) rather than id so the update
        // receives the correct record.  The edit form names this field
        // 'programmeId'.  If id were used, it would default to 0, causing
        // updates to fail.
        $id = (int) ($_POST['programmeId'] ?? $_POST['id'] ?? 0);
        // Accept 'programmeName' from our edit form or fall back to
        // legacy 'name'.
        $name = trim($_POST['programmeName'] ?? ($_POST['name'] ?? ''));
        $description = trim($_POST['description'] ?? '');
        $image = trim($_POST['image'] ?? '');
        $leaderId = (int) ($_POST['leaderId'] ?? null);
        $isPublished = (int) ($_POST['is_published'] ?? 0);

        if ($id <= 0 || !$name || !$description) {
            header("Location: index.php?page=editProgramme&id=$id&error=invalid");
            exit;
        }

        Programme::update($pdo, $id, $name, $description, $image, $leaderId, $isPublished);
        header('Location: index.php?page=adminDashboard');
        exit;
    }

    public static function deleteProgramme($pdo, $id)
    {
        self::requireLogin();
        Programme::delete($pdo, $id);
        header('Location: index.php?page=adminDashboard');
        exit;
    }

    public static function addProgrammeForm($pdo)
    {
        self::requireLogin();
        // Optional: fetch levels and staff for dropdowns
        $levels = Programme::getLevels($pdo);
        $staff = Programme::getStaff($pdo);
        include(__DIR__ . '/../views/admin/addProgrammeForm.php');
    }

    public static function addProgramme($pdo)
    {
        self::requireLogin();
        // Accept either 'programmeName' (from our warm theme form) or
        // legacy 'name' fields for backward compatibility.
        $name = trim($_POST['programmeName'] ?? ($_POST['name'] ?? ''));
        $description = trim($_POST['description'] ?? '');
        $image = trim($_POST['image'] ?? '');
        $levelId = (int) ($_POST['levelId'] ?? 0);
        // For the warm theme form there is no leaderId or publish
        // control; default to 0.  If supplied (from old forms), use
        // those values.  leaderId may be optional.
        $leaderId = (int) ($_POST['leaderId'] ?? 0);
        $isPublished = (int) ($_POST['is_published'] ?? 0);

        if (!$name || !$description || $levelId <= 0 || $leaderId <= 0) {
            header("Location: index.php?page=addProgrammeForm&error=invalid");
            exit;
        }

        Programme::insert($pdo, $name, $description, $image, $levelId, $leaderId, $isPublished);
        header('Location: index.php?page=adminDashboard');
        exit;
    }

    public static function mailingList($pdo)
    {
        self::requireLogin();
        $students = Programme::interestedStudents($pdo);
        include(__DIR__ . '/../views/admin/admin_mailing_list.php');
    }

    public static function downloadCSV($pdo)
    {
        self::requireLogin();
        $students = Programme::interestedStudents($pdo);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="mailing_list.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Programme', 'Student Name', 'Email', 'Registered At']);

        foreach ($students as $s) {
            fputcsv($output, [$s['ProgrammeName'], $s['StudentName'], $s['Email'], $s['RegisteredAt']]);
        }

        fclose($output);
        exit;
    }
    public static function programmeModules($pdo, $programmeId)
{
        self::requireLogin();
    $programme = Programme::find($pdo, $programmeId);

    if (!$programme) {
        header("Location: index.php?page=adminDashboard&error=programmeNotFound");
        exit;
    }

    $assigned = Programme::getModules($pdo, $programmeId);

    // Enrich each module with usage count and programme list
    foreach ($assigned as &$module) {
        $module['UsageCount'] = Programme::moduleUsageCount($pdo, $module['ModuleID']);
        $module['UsedInProgrammes'] = Programme::getProgrammesUsingModule($pdo, $module['ModuleID']);
    }
    unset($module); // break reference

    $allModules = Programme::allModules($pdo);
    include(__DIR__ . '/../views/admin/programme_modules.php');
}


    public static function assignModule($pdo)
    {
        self::requireLogin();
        $programmeId = (int) ($_POST['programmeId'] ?? 0);
        $moduleId = (int) ($_POST['moduleId'] ?? 0);
        $year = (int) ($_POST['year'] ?? 1);

        if ($programmeId && $moduleId && $year) {
            Programme::assignModule($pdo, $programmeId, $moduleId, $year);
        }

        header("Location: index.php?page=programmeModules&id=$programmeId");
        exit;
    }

    public static function removeModule($pdo, $programmeId, $moduleId)
    {
        self::requireLogin();
        Programme::removeModule($pdo, $programmeId, $moduleId);
        header("Location: index.php?page=programmeModules&id=$programmeId");
        exit;
    }

    public static function assignModuleLeaderForm($pdo, $moduleId)
    {
        self::requireLogin();
        $module = Programme::findModule($pdo, $moduleId);
        $staff = Programme::getAllStaffForModuleLeader($pdo);
        include(__DIR__ . '/../views/admin/assign_module_leader.php');
    }

    public static function assignModuleLeader($pdo)
    {
        self::requireLogin();
        $moduleId = (int) ($_POST['moduleId'] ?? 0);
        $leaderId = (int) ($_POST['staffId'] ?? 0); // ✅ staffId, not leaderId
        $programmeId = (int) ($_POST['programmeId'] ?? 0); // ✅ retrieve programmeId

        if ($moduleId && $leaderId) {
            Programme::updateModuleLeader($pdo, $moduleId, $leaderId);
        }

        //  Redirect to the correct programmeModules page
        header("Location: index.php?page=programmeModules&id=" . $programmeId . "&success=1");
        exit;
    }

    //Register Interest - View Interested Students

    public static function viewInterestedStudents($pdo, $programmeId)
    {
        self::requireLogin();
        // Query interested students for the given programme from the
        // InterestedStudents table.  The Students table does not contain
        // ProgrammeID or RegisteredAt columns, so we must use the
        // InterestedStudents table instead.  Each row stores the
        // StudentName, Email and when they registered interest.  Order by
        // registration date so the most recent appear first.
        $sql = "SELECT StudentName, Email, RegisteredAt
            FROM InterestedStudents
            WHERE ProgrammeID = :id
            ORDER BY RegisteredAt DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $programmeId]);
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Pass the programme ID to the view so the back link and export
        // form can include it.  Including this variable here makes it
        // available in the included PHP file.
        $programmeId = (int) $programmeId;
        include(__DIR__ . '/../views/admin/interested_students.php');
    }

    public static function exportEmails($pdo)
    {
        self::requireLogin();
        $programmeId = (int) ($_POST['programmeId'] ?? 0);

        // Extract email addresses of all interested students for the
        // programme.  The Students table does not record programme
        // enrolments; instead we use InterestedStudents.  This ensures
        // that emails correspond to the students who registered interest
        // in the specified programme.
        $sql = "SELECT Email FROM InterestedStudents WHERE ProgrammeID = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $programmeId]);
        $emails = $stmt->fetchAll(PDO::FETCH_COLUMN);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="interested_emails.csv"');

        $output = fopen('php://output', 'w');
        foreach ($emails as $email) {
            fputcsv($output, [$email]);
        }
        fclose($output);
        exit;
    }
    //TogglePublish
    public static function togglePublish($pdo, $id)
    {
        self::requireLogin();
        $id = (int) $id;
        if ($id > 0) {
            Programme::togglePublish($pdo, $id);
        }
        header('Location: index.php?page=adminDashboard');
        exit;
    }
}
