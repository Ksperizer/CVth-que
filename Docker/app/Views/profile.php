<!-- app/Views/profile.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Vitae</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><?php echo htmlspecialchars($user['name']); ?></h1>
            <p><?php echo htmlspecialchars($user['title']); ?></p>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?> | Téléphone: <?php echo htmlspecialchars($user['phone']); ?></p>
            <button id="editBtn">Modifier mes informations</button>
            <a href="logout.php">Se déconnecter</a>
        </header>

        <section class="profile">
            <h2>Profil</h2>
            <p><?php echo htmlspecialchars($user['profile_description']); ?></p>
        </section>

        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Modifier mes informations personnelles</h2>
                <form method="POST" action="">
                    <label for="name">Nom:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

                    <label for="firstName">Prénom:</label>
                    <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>

                    <label for="title">Titre:</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($user['title']); ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                    <label for="phone">Téléphone:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>

                    <label for="profileDescription">Description du profil:</label>
                    <textarea id="profileDescription" name="profileDescription" required><?php echo htmlspecialchars($user['profile_description']); ?></textarea>

                    <input type="submit" value="Enregistrer les modifications">
                </form>
            </div>
        </div>
    </div>
    <script src="home.js"></script>
</body>
</html>
