<?php

require_once(__DIR__ . '/../models/programme.php');
require_once(__DIR__ . '/../models/interestedStudent.php');

/**
 * Controller handling all student‑facing actions for the course hub.  This class
 * contains methods for listing programmes, showing programme details,
 * registering interest (with account creation), authenticating a student,
 * displaying the student dashboard, logging out and viewing a staff list.  All
 * output is delegated to view templates under app/views/students.  Note
 * that sessions must be started in the front controller (public/index.php)
 * before these methods are invoked in order to use $_SESSION for login.
 */
class StudentController
{
    /**
     * Show a list of all published programmes to prospective students.  This
     * method retrieves published programmes from the Programme model and
     * includes the programme list view.  No authentication is required.
     */
    public static function index($pdo)
    {
        // Fetch the list of published programmes and all levels.  The levels
        // array contains LevelID and LevelName so the view can build a
        // filtering UI.  We deliberately query Levels here rather than in
        // Programme::published() to keep concerns separate.
        $programmes = Programme::published($pdo);
        $levels     = Programme::getLevels($pdo);
        include(__DIR__ . '/../views/students/programme_lists.php');
    }

    /**
     * Show details for a single programme, including modules grouped by year
     * and the programme leader.  Unpublished programmes result in a 404.
     *
     * @param PDO    $pdo Database connection
     * @param int    $id  Programme ID from the query string
     */
    public static function show($pdo, $id)
    {
        $id = (int) $id;
        $programme = Programme::find($pdo, $id);
        // Prevent access to unpublished or missing programmes
        if (!$programme || !$programme['is_published']) {
            http_response_code(404);
            include(__DIR__ . '/../views/error/404.php');
            return;
        }

        $modules = Programme::modulesByYear($pdo, $id);
        $leader = Programme::leader($pdo, $programme['ProgrammeLeaderID'] ?? null);
        include(__DIR__ . '/../views/students/programme_details.php');
    }

    /**
     * Handle registering interest in a programme.  This method validates
     * incoming form data, creates a student account if one does not exist,
     * records the student’s programme interest, logs them in by setting
     * session variables and then redirects to the dashboard.  Errors during
     * validation will redirect back to the register interest form with an
     * appropriate error code in the query string.
     *
     * The registration form should include fields: name, email,
     * password, confirm_password and programmeId.  The view layer is
     * responsible for sending these fields via POST.
     *
     * @param PDO $pdo Database connection
     */
    public static function registerInterest($pdo)
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $programmeId = $_POST['programmeId'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // CSRF token validation: ensure the token from the form matches
        // the one stored in the session.  If the token is missing or does
        // not match, halt the request.  Using hash_equals prevents timing
        // attacks on the comparison.
        $token = $_POST['csrf_token'] ?? '';
        if (empty($token) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            // Token invalid; respond with a generic error message.  We do not
            // reveal details to the user to avoid leaking information.
            http_response_code(400);
            echo 'Invalid form submission. Please reload the page and try again.';
            exit;
        }

        // Basic validation: ensure all required fields are present
        if (!$name || !$email || !$programmeId || !$password || !$confirmPassword) {
            header("Location: index.php?page=registerInterestForm&error=missing_fields");
            exit;
        }

        // Password confirmation must match
        if ($password !== $confirmPassword) {
            header("Location: index.php?page=registerInterestForm&error=password_mismatch");
            exit;
        }

        // Check if the student already exists
        $stmt = $pdo->prepare("SELECT * FROM Students WHERE Email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$existing) {
            // Create a new student record with a hashed password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare(
                "INSERT INTO Students (Name, Email, PasswordHash) VALUES (:name, :email, :password)"
            );
            $stmt->execute([
                'name'     => $name,
                'email'    => $email,
                'password' => $hashedPassword
            ]);
            $studentId = $pdo->lastInsertId();
        } else {
            // If the student already exists, use their ID
            $studentId = $existing['StudentID'];
        }

        // Record the interest.  Use a simple insert; if you wish to
        // prevent duplicate interest entries, add a unique constraint in
        // the database on (Email, ProgrammeID) or modify this query.
        $stmt = $pdo->prepare(
            "INSERT INTO InterestedStudents (StudentName, Email, ProgrammeID, RegisteredAt) 
             VALUES (:name, :email, :programmeId, NOW())"
        );
        $stmt->execute([
            'name'        => $name,
            'email'       => $email,
            'programmeId' => $programmeId
        ]);

        // Log the student in by storing their info in the session
        $_SESSION['student'] = [
            'id'    => $studentId,
            'name'  => $name,
            'email' => $email
        ];

        // Redirect to their personal dashboard
        header("Location: index.php?page=studentDashboard");
        exit;
    }

    /**
     * Display the register interest form with a list of programmes.  This
     * method retrieves all programmes and includes the form view.  It
     * does not require authentication.
     */
    public static function showRegisterForm($pdo)
    {
        $programmes  = Programme::all($pdo);
        // Pull the CSRF token from the session so the view can embed it in
        // the registration form.  If the token is missing, an empty string
        // will be used; the controller will validate it on submission.
        $csrf_token = $_SESSION['csrf_token'] ?? '';
        include(__DIR__ . '/../views/students/register_interest_form.php');
    }

    /**
     * Show the login form for students.  If a student is already
     * authenticated, they will be redirected to their dashboard instead.
     *
     * @param PDO $pdo Database connection (unused here but kept for consistency)
     */
    public static function loginForm($pdo)
    {
        if (!empty($_SESSION['student'])) {
            header('Location: index.php?page=studentDashboard');
            exit;
        }
        // Provide CSRF token to the login view.  Even though login
        // credentials are not persisted beyond the session, a CSRF token
        // protects the login form from cross‑site request forgery.
        $csrf_token = $_SESSION['csrf_token'] ?? '';
        include(__DIR__ . '/../views/students/login.php');
    }

    /**
     * Handle student login.  Validates the provided email and password
     * against the Students table, sets session values on success and
     * redirects appropriately.  On failure, redirects back to the login
     * page with an error flag.
     */
    public static function handleLogin($pdo)
    {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        // Validate CSRF token to mitigate cross‑site request forgery attacks
        $token = $_POST['csrf_token'] ?? '';
        if (empty($token) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(400);
            echo 'Invalid form submission. Please reload the page and try again.';
            exit;
        }
        if ($email && $password) {
            $stmt = $pdo->prepare("SELECT * FROM Students WHERE Email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($student && password_verify($password, $student['PasswordHash'] ?? '')) {
                // Successful login sets session and redirects to dashboard
                $_SESSION['student'] = [
                    'id'    => $student['StudentID'] ?? null,
                    'name'  => $student['Name'] ?? '',
                    'email' => $student['Email']
                ];
                header('Location: index.php?page=studentDashboard');
                exit;
            }
        }
        // Failed login redirects back with an error parameter
        header('Location: index.php?page=studentLogin&error=1');
        exit;
    }

    /**
     * Display the student dashboard listing all programmes the logged‑in
     * student has expressed interest in.  If the student is not logged
     * in, this method will redirect them to the login form.
     */
    public static function studentDashboard($pdo)
    {
        if (empty($_SESSION['student'])) {
            header('Location: index.php?page=studentLogin');
            exit;
        }
        $email = $_SESSION['student']['email'];
        $stmt = $pdo->prepare(
            "SELECT i.*, p.ProgrammeName, p.Description
             FROM InterestedStudents i
             JOIN Programmes p ON i.ProgrammeID = p.ProgrammeID
             WHERE i.Email = :email"
        );
        $stmt->execute(['email' => $email]);
        $registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        include(__DIR__ . '/../views/students/student_dashboard.php');
    }

    /**
     * Log the student out by removing their details from the session and
     * redirecting them back to the login form.  This method has no
     * database interactions.
     */
    public static function logout()
    {
        if (isset($_SESSION['student'])) {
            unset($_SESSION['student']);
        }
        header('Location: index.php?page=studentLogin');
        exit;
    }

    /**
     * Display a list of all staff members, showing their names, email
     * addresses and bios.  This method uses the Programme model to
     * retrieve staff and then includes the staff list view.  It is
     * accessible to any visitor (no authentication required).
     */
    public static function staffList($pdo)
    {
        $staffList = Programme::getStaff($pdo);
        include(__DIR__ . '/../views/students/staff_list.php');
    }
}