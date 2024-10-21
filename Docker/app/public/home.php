<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="home.css"> 

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

    
    <script>
        // Modal Connexion
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("connexionBtn");
        var span = document.getElementsByClassName("close")[0];
        document.getElementById("registerBtn").onclick = function() {
            window.location.href = "register.php";
        }

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>
</html>
