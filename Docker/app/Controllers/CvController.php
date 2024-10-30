<?php

require_once __DIR__ . '/../Models/CvModel.php';

class CvController {
    private $cvModel;

    public function __construct($bdd) {
        $this->cvModel = new CvModel($bdd);
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
        require __DIR__ . '/../Views/user_cv.php';
    }
}
