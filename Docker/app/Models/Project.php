<?php
class Project {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    public function addProject($title, $description, $date, $userId) {
        $stmt = $this->bdd->prepare("INSERT INTO Projects (title, description, date, user_id) VALUES (:title, :description, :date, :user_id)");
        return $stmt->execute([
            'title' => $title,
            'description' => $description,
            'date' => $date,
            'user_id' => $userId
        ]);
    }

    public function getUserProjects($userId) {
        $stmt = $this->bdd->prepare("SELECT * FROM Projects WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }
}
