<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require './config.php';

$isLoggedIn = isset($_SESSION['user_id']);
$userId = $_SESSION['user_id']?? null;

if ($userId) {
  
    $stmt = $bdd->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $user = $stmt->fetch();

    $cvStmt = $bdd->prepare("SELECT * FROM CV WHERE user_id = :user_id");
    $cvStmt->execute(['user_id' => $userId]);
    $cv = $cvStmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="home.php">Accueil</a></li>
            <li><a href="cv.php">CV</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <!-- Profil de l'utilisateur -->
    <div class="container">
        <h2>Profil</h2>
        <p>Consultez votre profil.</p>

        <section>
            <h3>Informations personnelles</h3>
            <p>Nom: <?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></p>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        </section>

        <!-- Section CV de l'utilisateur -->
        <section>
            <h3>Votre CV</h3>
            <?php if ($cv): ?>
                <p>Consultez votre CV.</p>
                <a href="<?php echo htmlspecialchars($cv['filePath']); ?>" download="<?php echo htmlspecialchars($cv['fileName']); ?>">Télécharger</a>
            <?php else: ?>
                <p>Vous n'avez pas encore téléchargé de CV.</p>
                <a href="cv.php">Télécharger un CV</a>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
