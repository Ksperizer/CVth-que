<?php
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ .'/../../config/database.php';


class AuthController
{
    private $userModel;
    private $errors;
    private $bdd;

    public function __construct($bdd){
        $this->userModel = new User($bdd);
        $this->errors = [];
        $this->bdd = $bdd;
    }

    public function login() {
        if (session_status() === PHP_SESSION_NONE) { 
            session_start();
        }

        $error = '';
        $success = false;
        $passwordError = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $stmt = $this->bdd->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $success = true;
                header("Location: /home"); 
                exit();
            } else {
                $error = "Email ou mot de passe incorrect.";
                $passwordError = true;
            }
        }

        require_once __DIR__ . '/../Views/login.html'; 
    }

    
    
    public function logout(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();
        header("Location: /login");
        exit();
    }

    public function isLoggedIn(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['userId']);
    }

    public function register(){
        $this->errors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordConfirm = $_POST['passwordConfirm'];

            if (empty($username) || empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($passwordConfirm)) {
                $this->errors[] = "Tous les champs sont obligatoires";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->errors[] = "L'adresse email n'est pas valide";
            } elseif ($password != $passwordConfirm) {
                $this->errors[] = "Les mots de passe ne correspondent pas";
            } elseif ($this->userModel->isEmailTaken($email)) {
                $this->errors[] = "L'adresse email est déjà utilisée";
            }

            if (empty($this->errors)) {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $result = $this->userModel->createUser($username, $firstName, $lastName, $email, $hashedPassword);

                if ($result) {
                    header("Location: /login");
                    exit();
                } else {
                    $this->errors[] = "Erreur lors de l'inscription. Veuillez réessayer.";
                }
            }
        }

        require __DIR__ . '/../Views/register.html';
    }

    public function getErrors(){
        return $this->errors;
    }
}
