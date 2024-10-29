<?php
class User {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function findUserByEmail($email) {
        $stmt = $this->bdd->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($email, $password) {
        $stmt = $this->bdd->prepare('
            UPDATE users
            SET password = :password
            WHERE email = :email
        ');
        $stmt->execute(['email'=> $email,'password'=> $password]);
    }
    
    public function deleteUser($email) {
        $stmt = $this->bdd->prepare('
            DELETE FROM users
            WHERE email = :email
        ');
        $stmt->execute(['email'=> $email]);
    }



    public function createUser($username, $firstName, $lastName, $email, $password) {
        $stmt = $this->bdd->prepare("INSERT INTO users (username, firstName, lastName, email, password) VALUES (:username, :firstName, :lastName, :email, :password)");
        return $stmt->execute([
            'username' => $username,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT)
        ]);
    }

    public function getUserById($userId) {
        $stmt = $this->bdd->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isEmailTaken($email) {
        $stmt = $this->bdd->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() !== false;
    }
}
