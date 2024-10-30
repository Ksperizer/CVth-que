<?php

require_once __DIR__ . '/../Models/CvModel.php';

class CvController {
    private $cvModel;

    public function __construct($bdd) {
        $this->cvModel = new CvModel($bdd);
    }

    public function saveCV() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $postalCode = $_POST['postalCode'];
            $phone = $_POST['phone'];
            
            // Save personal information in `coordonnees`
            $this->cvModel->savePersonalInfo($userId, $address, $city, $postalCode, $phone);
    
            // Save education information in `formations`
            foreach ($_POST['degree'] as $index => $degree) {
                $institution = $_POST['institution'][$index];
                $fieldOfStudy = $_POST['fieldOfStudy'][$index];
                $startDate = $_POST['startDate'][$index];
                $endDate = $_POST['endDate'][$index];
                $this->cvModel->saveEducation($userId, $institution, $degree, $fieldOfStudy, $startDate, $endDate);
            }
    
            // Save experience information in `experiences`
            foreach ($_POST['role'] as $index => $role) {
                $company = $_POST['company'][$index];
                $startDate = $_POST['jobStartDate'][$index];
                $endDate = $_POST['jobEndDate'][$index];
                $description = $_POST['jobDescription'][$index];
                $this->cvModel->saveExperience($userId, $company, $role, $startDate, $endDate, $description);
            }
    
            // Save hobbies in `loisirs`
            foreach ($_POST['hobbies'] as $hobby) {
                $this->cvModel->saveHobby($userId, $hobby);
            }
    
            // redirect to the profile page
            header("Location: /cv");
            exit();
        }
    }
    

    public function upload() {
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['cvFile'])) {
            $userId = $_SESSION['user_id']; 
            $fileName = $_FILES['cvFile']['name'];
            $fileTmpName = $_FILES['cvFile']['tmp_name'];
            $fileType = $_FILES['cvFile']['type'];
            $uploadDir = '/uploads/'; 

            // Ensure the uploads directory exists
            $fullUploadDir = __DIR__ . '/../../public' . $uploadDir;
            if (!is_dir($fullUploadDir)) {
                mkdir($fullUploadDir, 0777, true);
            }

            $filePath = $uploadDir . basename($fileName);
            $destinationPath = $fullUploadDir . basename($fileName);

            if ($_FILES['cvFile']['error'] === UPLOAD_ERR_OK) {
                if (move_uploaded_file($fileTmpName, $destinationPath)) {
                    $this->cvModel->uploadCV($userId, $fileName, $filePath, $fileType);
                    $successMessage = "Votre CV a été téléchargé avec succès.";
                } else {
                    $errorMessage = "Erreur lors du déplacement du fichier téléchargé.";
                }
            } else {
                $errorMessage = "Erreur de téléchargement du fichier : " . $_FILES['cvFile']['error'];
            }
        }

        
        require __DIR__ . '/../Views/upload_cv.html';
    }

    public function showUserCV($userId) {
        $cv = $this->cvModel->getCVByUserId($userId);
        require __DIR__ . '/../Views/cv.html';
    }
}
