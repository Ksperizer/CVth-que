<?php
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/CvModel.php';

class ProfileController {
    private $userModel;
    private $cvModel;

    public function __construct($bdd) {
        $this->userModel = new User($bdd);
        $this->cvModel = new CvModel($bdd);
    }

    public function showProfile() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
        
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($userId);
        $cv = $this->cvModel->getCVByUserId($userId);

        require_once __DIR__ . '/../Views/profile.php';
    }
}
