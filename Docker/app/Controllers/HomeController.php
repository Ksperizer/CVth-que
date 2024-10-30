<?php
class HomeController {
    private $cvModel;

    public function __construct($bdd) {
        $this->cvModel = new CvModel($bdd);
    }

    public function index() {
        // Vérifier la connexion de l'utilisateur
        $isLoggedIn = isset($_SESSION['user_id']);

        // Récupérer les CV récents
        $recentCvs = $this->cvModel->getRecentCvs() ?? []; // Assurez-vous que getRecentCvs() existe et retourne un tableau ou null

        // Calculer le nombre de boîtes vides
        $emptyBoxes = max(0, 3 - count($recentCvs)); // Ajuster selon vos besoins

        // Inclure la vue
        require __DIR__ . '/../Views/home.html';
    }
}
