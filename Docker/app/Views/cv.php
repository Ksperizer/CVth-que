<!-- app/Views/user_cv.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon CV</title>
</head>
<body>
    <h1>Mon CV</h1>

    <?php if ($cv): ?>
        <p>Nom du fichier : <?php echo htmlspecialchars($cv['fileName']); ?></p>
        <a href="<?php echo htmlspecialchars($cv['filePath']); ?>" target="_blank">Voir le CV</a>
        <p>Type de fichier : <?php echo htmlspecialchars($cv['fileType']); ?></p>
        <p>Date d'upload : <?php echo htmlspecialchars($cv['uploaded_at']); ?></p>
    <?php else: ?>
        <p>Vous n'avez pas encore téléchargé de CV.</p>
        <a href="/upload">Télécharger un CV</a>
    <?php endif; ?>
</body>
</html>
