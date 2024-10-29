<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploader CV</title>
</head>
<body>
    <h1>Uploader votre CV</h1>

    <?php if (isset($successMessage)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($successMessage); ?></p>
    <?php elseif (isset($errorMessage)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
    <?php endif; ?>

    <form action="/upload" method="post" enctype="multipart/form-data">
        <label for="cvFile">Sélectionnez un fichier (PDF, DOC, etc.) :</label>
        <input type="file" name="cvFile" id="cvFile" required>
        <button type="submit">Télécharger</button>
    </form>
</body>
</html>
