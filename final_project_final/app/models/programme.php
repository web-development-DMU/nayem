<?php

class Programme
{
    // return all programmes for admin
    public static function all($pdo)
    {
        $sql = "SELECT p.ProgrammeID, p.ProgrammeName, p.Description, p.Image, p.is_published,
                   l.LevelName,
                   s.Name AS LeaderName
            FROM Programmes p
            JOIN Levels l ON p.LevelID = l.LevelID
            LEFT JOIN Staff s ON p.ProgrammeLeaderID = s.StaffID
            ORDER BY p.ProgrammeID DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // return published programmes for public listing
    public static function published($pdo)
    {
        // Include the LevelID so the front‑end can filter programmes by level.
        // We only expose columns needed for the public listing.  Additional
        // columns (e.g. LevelName) can be joined if required later.
        $sql = "SELECT ProgrammeID, ProgrammeName, Description, Image, LevelID
                FROM Programmes
                WHERE is_published = 1
                ORDER BY ProgrammeID DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // find one programme by id
    public static function find($pdo, $id)
    {
        $sql = "SELECT * FROM Programmes WHERE ProgrammeID = :id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // create a programme, returns new id or false
    public static function create($pdo, $name, $description, $image = null, $leaderId = null)
    {
        $sql = "INSERT INTO Programmes (ProgrammeName, Description, Image, ProgrammeLeaderID, is_published)
                VALUES (:name, :description, :image, :leaderId, 0)";
        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':image' => $image,
            ':leaderId' => $leaderId
        ]);

        if ($ok) {
            return (int) $pdo->lastInsertId();
        }
        return false;
    }

    // update programme, returns bool
    public static function update($pdo, $id, $name, $description, $image, $leaderId, $isPublished)
    {
        $sql = "UPDATE Programmes
            SET ProgrammeName = :name,
                Description = :description,
                Image = :image,
                ProgrammeLeaderID = :leaderId,
                is_published = :isPublished
            WHERE ProgrammeID = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'image' => $image,
            'leaderId' => $leaderId,
            'isPublished' => $isPublished
        ]);
    }
    // delete method (delete)
    //This will also delete related modeules + interested students
    public static function delete($pdo, $id)
    {
        $sql = "DELETE FROM Programmes WHERE ProgrammeID = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    // toggle publish
    public static function togglePublish($pdo, $id)
    {
        $id = (int) $id;
        if ($id <= 0) return false;

        $stmt = $pdo->prepare("UPDATE Programmes SET is_published = 1 - is_published WHERE ProgrammeID = :id");
        return $stmt->execute([':id' => $id]);
    }

    // modules grouped by year
    public static function modulesByYear($pdo, $programmeId)
    {
        $programmeId = (int) $programmeId;
        if ($programmeId <= 0) return [];

        $sql = "SELECT pm.Year, m.ModuleID, m.ModuleName, m.Description
                FROM ProgrammeModules pm
                JOIN Modules m ON pm.ModuleID = m.ModuleID
                WHERE pm.ProgrammeID = :programmeId
                ORDER BY pm.Year, m.ModuleName";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':programmeId' => $programmeId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $out = [];
        foreach ($rows as $r) {
            $year = $r['Year'] ?? 'Unknown';
            if (!isset($out[$year])) $out[$year] = [];
            $out[$year][] = [
                'ModuleID' => $r['ModuleID'],
                'ModuleName' => $r['ModuleName'],
                'Description' => $r['Description']
            ];
        }
        return $out;
    }

    // get leader info
    public static function leader($pdo, $staffId)
    {
        $staffId = (int) $staffId;
        if ($staffId <= 0) return null;

        $stmt = $pdo->prepare("SELECT StaffID, Name FROM Staff WHERE StaffID = :id LIMIT 1");
        $stmt->execute([':id' => $staffId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row === false ? null : $row;
    }

    public static function getLevels($pdo)
    {
        $stmt = $pdo->query("SELECT * FROM Levels ORDER BY LevelID");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getStaff($pdo)
    {
        $stmt = $pdo->query("SELECT * FROM Staff ORDER BY StaffID");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insert($pdo, $name, $description, $image, $levelId, $leaderId, $isPublished)
    {
        $sql = "INSERT INTO Programmes (ProgrammeName, Description, Image, LevelID, ProgrammeLeaderID, is_published)
            VALUES (:name, :description, :image, :levelId, :leaderId, :isPublished)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'image' => $image,
            'levelId' => $levelId,
            'leaderId' => $leaderId,
            'isPublished' => $isPublished
        ]);
    }

    public static function interestedStudents($pdo)
    {
        $sql = "SELECT i.StudentName, i.Email, i.RegisteredAt, p.ProgrammeName
            FROM InterestedStudents i
            JOIN Programmes p ON i.ProgrammeID = p.ProgrammeID
            ORDER BY i.RegisteredAt DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getModules($pdo, $programmeId)
    {
        $sql = "SELECT pm.Year, m.ModuleName, m.ModuleID,
       s.Name AS LeaderName, s.Email, s.Bio
FROM ProgrammeModules pm
JOIN Modules m ON pm.ModuleID = m.ModuleID
LEFT JOIN Staff s ON m.ModuleLeaderID = s.StaffID
WHERE pm.ProgrammeID = :id
ORDER BY pm.Year, m.ModuleName;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $programmeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieve modules taught by a particular staff member.  Each result
     * includes the programme name, year, module name and description.  Use
     * this for staff backend views.  If a staff member does not lead any
     * modules, an empty array will be returned.
     *
     * @param PDO $pdo
     * @param int $staffId
     * @return array
     */
    public static function modulesForStaff($pdo, $staffId)
    {
        $staffId = (int) $staffId;
        if ($staffId <= 0) {
            return [];
        }
        $sql = "SELECT p.ProgrammeID, p.ProgrammeName, pm.Year, m.ModuleID, m.ModuleName, m.Description
                FROM ProgrammeModules pm
                JOIN Modules m ON pm.ModuleID = m.ModuleID
                JOIN Programmes p ON pm.ProgrammeID = p.ProgrammeID
                WHERE m.ModuleLeaderID = :staffId
                ORDER BY p.ProgrammeName, pm.Year, m.ModuleName";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['staffId' => $staffId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function allModules($pdo)
    {
        $stmt = $pdo->query("SELECT * FROM Modules ORDER BY ModuleName");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function assignModule($pdo, $programmeId, $moduleId, $year)
    {
        $sql = "INSERT INTO ProgrammeModules (ProgrammeID, ModuleID, Year)
            VALUES (:programmeId, :moduleId, :year)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'programmeId' => $programmeId,
            'moduleId' => $moduleId,
            'year' => $year
        ]);
    }

    public static function removeModule($pdo, $programmeId, $moduleId)
    {
        $sql = "DELETE FROM ProgrammeModules
            WHERE ProgrammeID = :programmeId AND ModuleID = :moduleId";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'programmeId' => $programmeId,
            'moduleId' => $moduleId
        ]);
    }

    public static function findModule($pdo, $id)
    {
        $sql = "SELECT m.*, s.Name AS LeaderName
            FROM Modules m
            LEFT JOIN Staff s ON m.ModuleLeaderID = s.StaffID
            WHERE m.ModuleID = :id LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateModuleLeader($pdo, $moduleId, $leaderId)
    {
        $sql = "UPDATE Modules SET ModuleLeaderID = :leaderId WHERE ModuleID = :moduleId";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'moduleId' => $moduleId,
            'leaderId' => $leaderId
        ]);
    }

    public static function getAllStaffForModuleLeader($pdo)

    {
        $stmt = $pdo->query("SELECT StaffID, Name, Email FROM Staff ORDER BY Name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //shared module usage count
public static function getProgrammesUsingModule($pdo, $moduleId)
{
    $sql = "SELECT p.ProgrammeID, p.ProgrammeName
            FROM ProgrammeModules pm
            JOIN Programmes p ON pm.ProgrammeID = p.ProgrammeID
            WHERE pm.ModuleID = :moduleId
            ORDER BY p.ProgrammeName";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['moduleId' => $moduleId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public static function moduleUsageCount($pdo, $moduleId)
{
    $sql = "SELECT COUNT(DISTINCT ProgrammeID) FROM ProgrammeModules WHERE ModuleID = :moduleId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['moduleId' => $moduleId]);
    return (int) $stmt->fetchColumn();
}
}
