<?php
class UserController {
    private $userModel;

    public function __construct($bdd) {
        $this->userModel = new User($bdd);
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

        if (!$user) {
            echo "Utilisateur non trouvé.";
            exit;
        }

        require_once __DIR__ . '/../Views/profile.html';
    }

    public function updateProfile() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $userId = $_SESSION['user_id'] ?? null;
            if (!$userId) {
                header("Location: /login");
                exit;
            }

            $name = $_POST['name'] ?? '';
            $firstName = $_POST['firstName'] ?? '';
            $title = $_POST['title'] ?? '';
            $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $phone = $_POST['phone'] ?? '';
            $profileDescription = $_POST['profileDescription'] ?? '';

            if (!$email) {
                echo "Adresse email invalide.";
                return;
            }

            if ($this->userModel->updateUser($userId, $name, $firstName, $title, $email, $phone, $profileDescription)) {
                header("Location: /profile");
                exit;
            } else {
                echo "Erreur lors de la mise à jour des informations.";
            }
        }
    }
}
