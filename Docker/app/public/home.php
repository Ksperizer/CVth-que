<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require './config.php';

$isLoggedIn = isset($_SESSION['user_id']);

$stmt = $bdd->prepare( "SELECT CV.fileName, CV.filePath, users.username
                        FROM CV 
                        INNER JOIN users ON CV.user_id = users.id
                        ORDER BY CV.uploaded_at DESC
                        LIMIT 6");
$stmt->execute();
$recentCvs = $stmt->fetchAll();
$emptyBoxes = 6 - count($recentCvs);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="home.css"> 
    <script src="home.js"></script>

    <title>CVthèque - Accueil</title>
</head> 
<body>
    <!--  Navigation -->
<nav>
    <ul>
        <?php if ($isLoggedIn): ?>  <!-- Afficher uniquement si l'utilisateur est connecté -->
            <li><a href="profil.php">Profil</a></li>
        <?php endif; ?>
        
        <li><a href="home.php">Accueil</a></li>
        <li><a href="cv.php">CV</a></li>
        
        <?php if ($isLoggedIn): ?>
            <li><a href="logout.php">Déconnexion</a></li>
        <?php else: ?>
            <li><a href="login.php">Connexion</a></li>
        <?php endif; ?>
        
        <li><a href="contact.php">Contact</a></li>
    </ul>
</nav>


    <!--  Accueil -->
    <section id="accueil">
        <h1>Bienvenue sur la CVthèque</h1>
        <p>Découvrez les profils et CVs des candidats inscrits.</p>
    </section>

    <!-- CV -->
    <section id="cv">
    <h2>Consultez les CVs</h2>
    <p>Explorez les CVs des personnes enregistrées.</p>
    <!-- Carousel -->
    <div class="carousel">
        <button class="prev">Précédent</button>
        <div class="carouselTrack">
            <?php foreach ($recentCvs as $CV): ?>
                <div class="carouselItem">
                    <h3><?php echo htmlspecialchars($CV['username']); ?></h3>
                    <a href="<?php echo htmlspecialchars($CV['file_path']); ?>" target="_blank">
                        <img src="pdfIcon.png" alt="pdfIcon" class="cvIcon">
                    </a>
                    <p><a href="<?php echo htmlspecialchars($CV['file_path']); ?>" target="_blank">Télécharger</a></p>
                </div>
            <?php endforeach; ?>
            <?php for ($i = 0; $i < $emptyBoxes; $i++): ?>
                <div class="carouselItem empty">
                    <h3>CV indisponible</h3>
                    <div class="cvIcon empty"></div>
                    <p>Pas de CV à afficher</p>
                </div>
            <?php endfor; ?>
        </div>
        <button class="next">Suivant</button>
    </div>
</section>


  <!-- Connexion Modal -->
<?php if (!$isLoggedIn): ?>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Connexion</h2>
            <form method="POST" action="login.php">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" class="btn">Se connecter</button>

                <button type="submit" id="registerBtn" class="btn">S'inscrire</button>
            </form>
        </div>
    </div>
<?php endif; ?>

    <!-- Section Contact -->
    <section id="contact">
        <h2>Contactez-nous</h2>
        <form action="contact.php" method="POST">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message :</label>
            <textarea id="message" name="message" required></textarea>

            <button type="submit">Envoyer</button>
        </form>
    </section>

    
   

</body>
</html>
