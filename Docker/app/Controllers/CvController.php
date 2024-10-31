<?php

require_once __DIR__ . '/../Models/CvModel.php';

class CvController {
    private $cvModel;

    public function __construct($bdd) {
        $this->cvModel = new CvModel($bdd);
    }

    public function saveCV() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
    
        $userId = $_SESSION['user_id'];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $city = isset($_POST['city']) ? $_POST['city'] : '';
            $postalCode = isset($_POST['postalCode']) ? $_POST['postalCode'] : '';
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    
            // Save personal information in `coordonnees`
            $this->cvModel->savePersonalInfo($userId, $address, $city, $postalCode, $phone);
    
            // *** Créez un nouveau CV et obtenez l'ID du CV ***
            $cvId = $this->cvModel->createCV($userId); // Implémentez cette méthode dans votre modèle
    
            if (!$cvId) {
                // Gérer l'erreur si le CV n'a pas pu être créé
                die("Erreur lors de la création du CV");
            }
    
            // Save education information in `educations`
            if (isset($_POST['degree']) && is_array($_POST['degree'])) {
                foreach ($_POST['degree'] as $index => $degree) {
                    $institution = $_POST['institution'][$index] ?? '';
                    $fieldOfStudy = $_POST['fieldOfStudy'][$index] ?? '';
                    $startDate = !empty($_POST['startDate'][$index]) ? $_POST['startDate'][$index] : null;
                    $endDate = !empty($_POST['endDate'][$index]) ? $_POST['endDate'][$index] : null;
    
                    $this->cvModel->saveEducation($cvId, $institution, $degree, $fieldOfStudy, $startDate, $endDate);
                }
            }
    
            // Save experience information in `experiences`
            if (isset($_POST['role']) && is_array($_POST['role'])) {
                foreach ($_POST['role'] as $index => $role) {
                    $company = $_POST['company'][$index] ?? '';
                    $startDate = !empty($_POST['jobStartDate'][$index]) ? $_POST['jobStartDate'][$index] : null;
                    $endDate = !empty($_POST['jobEndDate'][$index]) ? $_POST['jobEndDate'][$index] : null;
                    $description = $_POST['jobDescription'][$index] ?? '';
    
                    $this->cvModel->saveExperience($cvId, $company, $role, $startDate, $endDate, $description);
                }
            }
    
            // Save hobbies in `loisirs`
            if (isset($_POST['hobbies']) && is_array($_POST['hobbies'])) {
                foreach ($_POST['hobbies'] as $hobby) {
                    $this->cvModel->saveHobby($cvId, $hobby);
                }
            }
    
            // Redirect after saving
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
        // Vérifiez si l'utilisateur est connecté
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
    
        $userId = $_SESSION['user_id'];
    
        // Récupérez les données à partir du modèle
        $cv = $this->cvModel->getCVByUserId($userId);
        $coordonnees = $this->cvModel->getPersonalInfo($userId); // Implémentez cette méthode dans votre modèle si nécessaire
        $educations = $this->cvModel->getEducationsByCVId($cv['id'] ?? null);
        $experiences = $this->cvModel->getExperiencesByCVId($cv['id'] ?? null);
        $loisirs = $this->cvModel->getHobbiesByCVId($cv['id'] ?? null);
    
        // Passez les données à la vue
        require_once __DIR__ . '/../Views/cv.html';
    }
}
