<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../vendor/autoload.php';
use Mpdf\Mpdf;
use PhpOffice\PhpWord\IOFactory;

$isLoggedIn = isset($_SESSION['user_id']);
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['cvFile'])) {
    
    $uploadDir = './uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir);
    }

    
    $fileTmpPath = $_FILES['cvFile']['tmp_name'];
    $fileName = $_FILES['cvFile']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Accepter uniquement les fichiers PDF
    if ($fileExtension === 'pdf') {
        $newFileName = uniqid() . '.pdf';  
        $destPath = $uploadDir . $newFileName;

       
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $success = 'Votre CV a été téléchargé avec succès.';
        } else {
            $error = 'Une erreur est survenue lors du téléchargement de votre CV.';
        }
    } else {
        $error = 'Seuls les fichiers PDF sont autorisés.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="home.php">Accueil</a></li>
            <li><a href="cv.php">CV</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="<?php echo $isLoggedIn ? 'logout.php' : 'login.php'; ?>">
                <?php echo $isLoggedIn ? 'Déconnexion' : 'Connexion'; ?>
            </a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Télécharger votre CV</h2>

        <!-- Affichage des erreurs -->
        <?php if (!empty($error)): ?>
            <div class="errors">
                <p><?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>

        <!-- Formulaire de téléchargement -->
        <form action="cv.php" method="POST" enctype="multipart/form-data">
            <label for="cvFile">Téléchargez votre CV (PDF uniquement) :</label>
            <input type="file" id="cvFile" name="cvFile" accept=".pdf" required>
            <button type="submit">Télécharger</button>
        </form>

        <!-- Message de succès -->
        <?php if (!empty($success)): ?>
            <div class="success">
                <p><?php echo htmlspecialchars($success); ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
