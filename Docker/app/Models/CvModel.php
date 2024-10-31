<?php
class CvModel {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    // create CV
    public function createCV($userId) {
        $stmt = $this->bdd->prepare("INSERT INTO cv (user_id, fileName, filePath, fileType) VALUES (:user_id, '', '', '')");
        $stmt->execute(['user_id' => $userId]);
        return $this->bdd->lastInsertId();
    }

    public function uploadCV($userId, $fileName, $filePath, $fileType) {
        $stmt = $this->bdd->prepare("
            INSERT INTO cv (user_id, fileName, filePath, fileType) 
            VALUES (:user_id, :fileName, :filePath, :fileType)
        ");
        return $stmt->execute([
            'user_id' => $userId,
            'fileName' => $fileName,
            'filePath' => $filePath,
            'fileType' => $fileType
        ]);
    }
    
    // get CV by user ID
    public function getCVByUserId($userId) {
        if ($userId === null) {
            throw new Exception("L'utilisateur n'est pas connecté.");
        }

        $stmt = $this->bdd->prepare("SELECT * FROM cv WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $cv = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cv) {
            return $cv['id'];
        } else {
            // Si le CV n'existe pas, en crée un nouveau
            return $this->createCV($userId);
        }
    }

    // delete CV
    public function deleteCV($userId, $fileName) {
        $stmt = $this->bdd->prepare("
            DELETE FROM cv
            WHERE user_id = :user_id AND fileName = :fileName
        ");
        $stmt->execute(['user_id' => $userId, 'fileName' => $fileName]);
        return $stmt->rowCount();
    }

    // get recent CVs
    public function getRecentCVs($limit = 5) {
        $stmt = $this->bdd->prepare("SELECT * FROM cv ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Save personal information
    public function savePersonalInfo($userId, $address, $city, $postalCode, $phone) {
        $stmt = $this->bdd->prepare("
            INSERT INTO coordonnees (user_id, address, city, postal_code, phone) 
            VALUES (:user_id, :address, :city, :postal_code, :phone)
            ON DUPLICATE KEY UPDATE
            address = VALUES(address), 
            city = VALUES(city), 
            postal_code = VALUES(postal_code), 
            phone = VALUES(phone)
        ");
        return $stmt->execute([
            'user_id' => $userId,
            'address' => $address,
            'city' => $city,
            'postal_code' => $postalCode,
            'phone' => $phone
        ]);
    }

    // Save education
    public function saveEducation($cvId, $institution, $degree, $fieldOfStudy, $startDate, $endDate) {
        $stmt = $this->bdd->prepare("
            INSERT INTO educations (cv_id, institution, degree, field_of_study, start_date, end_date) 
            VALUES (:cv_id, :institution, :degree, :field_of_study, :start_date, :end_date)
        ");
        return $stmt->execute([
            'cv_id' => $cvId,
            'institution' => $institution,
            'degree' => $degree,
            'field_of_study' => $fieldOfStudy,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }

    // Save experience
    public function saveExperience($cvId, $company, $role, $startDate, $endDate, $description) {
        $stmt = $this->bdd->prepare("
            INSERT INTO experiences (cv_id, company, role, start_date, end_date, description) 
            VALUES (:cv_id, :company, :role, :start_date, :end_date, :description)
        ");
        return $stmt->execute([
            'cv_id' => $cvId,
            'company' => $company,
            'role' => $role,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'description' => $description
        ]);
    }

    // Save hobbies
    public function saveHobby($cvId, $hobby) {
        $stmt = $this->bdd->prepare("
            INSERT INTO loisirs (cv_id, hobby) 
            VALUES (:cv_id, :hobby)
        ");
        return $stmt->execute([
            'cv_id' => $cvId,
            'hobby' => $hobby
        ]);
    }

    public function getPersonalInfo($userId) {
        $stmt = $this->bdd->prepare("SELECT * FROM coordonnees WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getEducationsByCVId($cvId) {
        if ($cvId) {
            $stmt = $this->bdd->prepare("SELECT * FROM educations WHERE cv_id = :cv_id");
            $stmt->execute(['cv_id' => $cvId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }
    
    public function getExperiencesByCVId($cvId) {
        if ($cvId) {
            $stmt = $this->bdd->prepare("SELECT * FROM experiences WHERE cv_id = :cv_id");
            $stmt->execute(['cv_id' => $cvId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }
    
    public function getHobbiesByCVId($cvId) {
        if ($cvId) {
            $stmt = $this->bdd->prepare("SELECT * FROM loisirs WHERE cv_id = :cv_id");
            $stmt->execute(['cv_id' => $cvId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }
    
}
