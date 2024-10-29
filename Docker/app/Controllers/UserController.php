<?php
require_once __DIR__ . '/../Models/UserModel.php';

class UserController {
    private $userModel;

    public function __construct($bdd) {
        $this->userModel = new User($bdd);
    }

    public function showProfile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /home.php");
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
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userId = $_SESSION['user_id'];
            $name = $_POST['name'];
            $firstName = $_POST['firstName'];
            $title = $_POST['title'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $profileDescription = $_POST['profileDescription'];

            if ($this->userModel->updateUser($userId, $name, $firstName, $title, $email, $phone, $profileDescription)) {
                header("Location: /profile.php");
                exit;
            } else {
                echo "Erreur lors de la mise à jour des informations.";
            }
        }
    }
}

?>