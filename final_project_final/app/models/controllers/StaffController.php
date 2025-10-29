<?php

require_once(__DIR__ . '/../models/programme.php');

/**
 * Controller providing simple staff backend views.  These pages allow a
 * staff member to see which modules they teach and which programmes
 * contain those modules.  Authentication for staff is optional; this
 * implementation accepts a staff ID via the query string for
 * demonstration purposes.
 */
class StaffController
{
    /**
     * Display a list of modules taught by the specified staff member.  The
     * staff ID is read from the query parameter `id`.  Each module is
     * accompanied by the programme name and year.  If no modules are
     * found, the view will display a corresponding message.
     *
     * @param PDO $pdo
     */
    public static function modules($pdo)
    {
        $staffId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        // Fetch modules taught by this staff member
        $modules = Programme::modulesForStaff($pdo, $staffId);
        // Get staff name for display (optional)
        $staffInfo = Programme::leader($pdo, $staffId);
        $staffName = $staffInfo['Name'] ?? '';
        include(__DIR__ . '/../views/staff/module_list.php');
    }

    /**
     * Display a summary of the impact a staff member has on programmes.  The
     * impact view counts how many modules a staff member teaches in each
     * programme and lists the affected programmes.  A staff ID must be
     * provided via query parameter `id`.  The view will handle the case
     * where no programmes are found.
     *
     * @param PDO $pdo
     */
    public static function impact($pdo)
    {
        $staffId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $rows = Programme::modulesForStaff($pdo, $staffId);
        // Summarise the impact by counting modules per programme
        $impact = [];
        foreach ($rows as $r) {
            $pid = $r['ProgrammeID'];
            if (!isset($impact[$pid])) {
                $impact[$pid] = [
                    'ProgrammeName' => $r['ProgrammeName'],
                    'ModuleCount'   => 0
                ];
            }
            $impact[$pid]['ModuleCount']++;
        }
        // Get staff name for display
        $staffInfo = Programme::leader($pdo, $staffId);
        $staffName = $staffInfo['Name'] ?? '';
        include(__DIR__ . '/../views/staff/programme_impact.php');
    }
}