<?php
class UserController {
    private $userModel;

    public function __construct($bdd) {
        $this->userModel = new User($bdd); // Utilisation correcte de UserModel
    }

    public function showProfile() {
        // Démarrer la session si elle n'est pas déjà active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérification de la session utilisateur
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login"); // Redirection vers une page de connexion appropriée
            exit;
        }

        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($userId);

        if (!$user) {
            echo "Utilisateur non trouvé.";
            exit;
        }

        require_once __DIR__ . '/../Views/profile.php';
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

            // Récupération et validation des données du formulaire
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
