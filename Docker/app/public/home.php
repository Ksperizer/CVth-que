<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est déjà connecté
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/home.css"> 

    <title>CVthèque - Accueil</title>
</head> 
<body>
    <!--  Navigation -->
    <nav>
        <ul>
            <li><a href="#accueil">Accueil</a></li>
            <li><a href="#cv">CV</a></li>
            <?php if ($isLoggedIn): ?>
                <li><a href="logout.php">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="#connexion" id="connexionBtn">Connexion</a></li>
            <?php endif; ?>
            <li><a href="#contact">Contact</a></li>
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
    </section>

    <!-- Connexion Modal (Visible seulement si l'utilisateur n'est pas connecté) -->
    <?php if (!$isLoggedIn): ?>
        <div id="connexionModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Connexion</h2>
                <form action="login.php" method="POST">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>

                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>

                    <button type="submit">Se connecter</button>
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

    <!-- Script JS pour gérer les modals -->
    <script>
        // Modal Connexion
        var modal = document.getElementById("connexionModal");
        var btn = document.getElementById("connexionBtn");
        var span = document.getElementsByClassName("close")[0];

        // Ouvrir le modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // Fermer le modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Fermer le modal si l'utilisateur clique en dehors
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>
</html>
