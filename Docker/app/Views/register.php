<!-- app/Views/register.php -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <title>Inscription</title>
</head>
<body>
    <h2>Enregistrement</h2>
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/register" method="post">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required>

        <label for="firstName">Prénom:</label>
        <input type="text" id="firstName" name="firstName" required>

        <label for="lastName">Nom:</label>
        <input type="text" id="lastName" name="lastName" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe:</label>  
        <input type="password" id="password" name="password" required>

        <label for="passwordConfirm">Confirmer le mot de passe:</label>
        <input type="password" id="passwordConfirm" name="passwordConfirm" required>

        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
