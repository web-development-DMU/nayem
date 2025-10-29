<?php
// Start the session so student authentication can persist across requests
session_start();

// Generate a CSRF token if one does not already exist in the session.  This
// token will be used in forms throughout the application to prevent
// cross‑site request forgery.  We do this here so it is available to
// controllers and views.  The token remains the same for the duration of the
// session but could be regenerated on each request if desired.
if (empty($_SESSION['csrf_token'])) {
    // Use random_bytes for a cryptographically secure random token
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once(__DIR__ . '/../config/db.php');
require_once(__DIR__ . '/../app/controllers/StudentController.php');
require_once(__DIR__ . '/../app/controllers/AdminController.php');
require_once(__DIR__ . '/../app/controllers/StaffController.php');

$page = $_GET['page'] ?? 'home';

switch ($page) {
    // Student authentication routes
    case 'studentLogin':
        // Show the student login form
        StudentController::loginForm($pdo);
        break;
    case 'studentAuth':
        // Handle login form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            StudentController::handleLogin($pdo);
        }
        break;
    case 'studentDashboard':
        // Display the student dashboard for logged‑in users
        StudentController::studentDashboard($pdo);
        break;
    case 'logout':
        // Log the student out and redirect to login
        StudentController::logout();
        break;
    // Admin authentication routes
    case 'adminLogin':
        // Show the admin login form
        AdminController::loginForm($pdo);
        break;
    case 'adminAuth':
        // Handle admin login form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            AdminController::handleLogin($pdo);
        }
        break;
    case 'adminLogout':
        // Log the admin out
        AdminController::logout();
        break;
    case 'home':
        // Default homepage shows the list of published programmes
        StudentController::index($pdo);
        break;
    // Staff backend routes (optional staff login)
    case 'staffModules':
        // Display modules taught by the staff member specified by id
        StaffController::modules($pdo);
        break;
    case 'staffImpact':
        // Display programme impact for the staff member specified by id
        StaffController::impact($pdo);
        break;
    case 'programmes':
        StudentController::index($pdo);
        break;

    case 'programme':
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            StudentController::show($pdo, $id);
        }
        break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            StudentController::registerInterest($pdo);
        }
        break;

    case 'registerInterest':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            StudentController::registerInterest($pdo);
        }
        break;

    case 'staff':
        // Show the staff list to students
        StudentController::staffList($pdo);
        break;
        
    case 'thankYou':
    include(__DIR__ . '/../app/views/students/thank_you.php');  
    break;

    case 'adminDashboard':
        AdminController::dashboard($pdo);
        break;

    case 'editProgramme':
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            AdminController::editProgramme($pdo, $id);
        }
        break;

    case 'updateProgramme':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            AdminController::updateProgramme($pdo);
        }
        break;

    case 'deleteProgramme':
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            AdminController::deleteProgramme($pdo, $id);
        }
        break;

    case 'togglePublish':
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            AdminController::togglePublish($pdo, $id);
        }
        break;

    case 'addProgrammeForm':
        AdminController::addProgrammeForm($pdo);
        break;

    case 'addProgramme':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            AdminController::addProgramme($pdo);
        }
        break;

    case 'mailingList':
        AdminController::mailingList($pdo);
        break;

    case 'downloadCSV':
        AdminController::downloadCSV($pdo);
        break;

    case 'exportEmails':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            AdminController::exportEmails($pdo);
        }
        break;

    // Show list of interested students for a specific programme (admin)
    case 'viewInterestedStudents':
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            AdminController::viewInterestedStudents($pdo, $id);
        }
        break;

    case 'programmeModules':
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            AdminController::programmeModules($pdo, $id);
        }
        break;

    case 'assignModule':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            AdminController::assignModule($pdo);
        }
        break;

    case 'removeModule':
        if (isset($_GET['programmeId'], $_GET['moduleId'])) {
            AdminController::removeModule($pdo, $_GET['programmeId'], $_GET['moduleId']);
        }
        break;

    case 'assignModuleLeaderForm':
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            AdminController::assignModuleLeaderForm($pdo, $id);
        }
        break;

    case 'assignModuleLeader':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            AdminController::assignModuleLeader($pdo);
        }
        break;

    case 'registerInterestForm':
        StudentController::showRegisterForm($pdo);
        break;

    case 'registerInterest':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            StudentController::registerInterest($pdo);
        }
        break;
    default:
        // For unknown pages, fall back to the homepage instead of a 404
        StudentController::index($pdo);
        break;
}
