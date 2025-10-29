<?php
class InterestedStudent {
    public static function exists($pdo, $email, $programmeId) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM InterestedStudents WHERE Email = ? AND ProgrammeID = ?");
        $stmt->execute([$email, $programmeId]);
        return $stmt->fetchColumn() > 0;
    }

    public static function register($pdo, $name, $email, $programmeId) {
        $stmt = $pdo->prepare("
            INSERT INTO InterestedStudents (StudentName, Email, ProgrammeID, RegisteredAt)
            VALUES (?, ?, ?, NOW())
        ");
        $stmt->execute([$name, $email, $programmeId]);
    }
}
?>