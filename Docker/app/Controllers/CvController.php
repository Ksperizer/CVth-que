<?php

require_once __DIR__ . '/../Models/CvModel.php';

class CvController {
    private $cvModel;

    public function __construct($bdd) {
        $this->cvModel = new CV($bdd);
    }

    public function upload() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['cvFile'])) {
            $userId = $_SESSION['user_id']; // get the user id from the session
            $fileName = $_FILES['cvFile']['name'];
            $fileTmpName = $_FILES['cvFile']['tmp_name'];
            $fileType = $_FILES['cvFile']['type'];
            $uploadDir = '/uploads/'; 

            // 
            if (!is_dir(__DIR__ . '/../../public' . $uploadDir)) {
                mkdir(__DIR__ . '/../../public' . $uploadDir, 0777, true);
            }

        
            $filePath = $uploadDir . basename($fileName);
            $destinationPath = __DIR__ . '/../../public' . $filePath;

            // move the file to the upload directory
            if (move_uploaded_file($fileTmpName, $destinationPath)) {
                // register the cv file in the database
                $this->cvModel->uploadCV($userId, $fileName, $filePath, $fileType);
                $successMessage = "Votre CV a été téléchargé avec succès.";
            } else {
                $errorMessage = "Erreur lors du téléchargement du fichier.";
            }
        }

        // uploder cv file
        require __DIR__ . '/../Views/upload_cv.php';
    }

    public function showUserCV($userId) {
        $cv = $this->cvModel->getCVByUserId($userId);
        require __DIR__ . '/../Views/user_cv.php';
    }
}
