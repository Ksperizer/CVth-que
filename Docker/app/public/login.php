<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require './config.php';

$isLoggedIn = isset($_SESSION['user_id']); 

$error = '';
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $bdd->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $success = true; // if successful, show success modal
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="cv.php">CV</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="<?php echo $isLoggedIn ? 'logout.php' : 'login.php'; ?>">
                <?php echo $isLoggedIn ? 'Déconnexion' : 'Connexion'; ?>
            </a></li>
        </ul>
    </div>

    <!-- Container for login -->
    <div class="container">
        <h2>Connexion</h2>
        
        <?php if (!empty($error)): ?>
            <div class="errors">
                <p><?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn">Se connecter</button>
        </form>

        <div class="signup-link">
            <p>Pas encore inscrit ? <a href="register.php">S'inscrire ici</a></p>
        </div>

        <!-- Modal de succès -->
        <div id="successModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeModal">&times;</span>
                <h2>Connexion réussie !</h2>
                <p>Vous serez redirigé vers l'accueil dans quelques secondes...</p>
            </div>
        </div>
    </div>

    <script>
        <?php if ($success): ?>
            document.getElementById("successModal").style.display = "flex";
            setTimeout(function() {
                window.location.href = "home.php";
            }, 5000);
        <?php endif; ?>
    </script>

</body>
</html>
