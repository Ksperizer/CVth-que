<?php
// Démarrage de session pour suivre les utilisateurs connectés
session_start();

// Connexion à la base de données (ajuste les informations de connexion à ton environnement)
$bdd = new PDO('mysql:host=localhost;dbname=CV');

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifier si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['user_id']);


if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si l'utilisateur existe, on récupère ses données
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $name = $user['name'];
        $firstName = $user['first_name'];
        $title = $user['title'];
        $email = $user['email'];
        $phone = $user['phone'];
        $profileDescription = $user['profile_description'];
    } else {
        // Gestion d'erreur si l'utilisateur n'existe pas
        echo "User not found.";
        exit;
    }

    // Si l'utilisateur soumet le formulaire pour mettre à jour ses informations
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $firstName = $_POST['firstName'];
        $title = $_POST['title'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $profileDescription = $_POST['profileDescription'];

        // Mise à jour des informations dans la base de données
        $sql = "UPDATE users SET name = ?, lastname= ?,  title = ?, email = ?, phone = ?, profile_description = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $title, $email, $phone, $profileDescription, $userId);

        if ($stmt->execute()) {
            // Redirection pour éviter la soumission multiple
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
} else {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Vitae</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <header>
            <h1><?php echo htmlspecialchars($name); ?></h1>
            <p><?php echo htmlspecialchars($title); ?></p>
            <p>Email: <?php echo htmlspecialchars($email); ?> | Phone: <?php echo htmlspecialchars($phone); ?></p>
            <?php if ($isLoggedIn): ?>
                <button id="editBtn">Modifier mes informations</button>
                <a href="logout.php">Se déconnecter</a>
            <?php else: ?>
                <a href="login.php">Connexion</a>
            <?php endif; ?>
        </header>

        <!-- Profile Section -->
        <section class="profile">
            <h2>Profil</h2>
            <p><?php echo htmlspecialchars($profileDescription); ?></p>
        </section>

        <!-- Modal pour la modification des informations de profil (seulement visible si connecté) -->
        <?php if ($isLoggedIn): ?>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Modifier mes informations personnelles</h2>
                <form method="POST" action="">
                    <label for="name">Nom:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

                    <label for="firstName">Prénom:</label>
                    <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>" required>


                    <label for="title">Titre:</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

                    <label for="phone">Téléphone:</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>

                    <label for="profileDescription">Description du profil:</label>
                    <textarea id="profileDescription" name="profileDescription" required><?php echo htmlspecialchars($profileDescription); ?></textarea>

                    <input type="submit" value="Enregistrer les modifications">
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script>
        // Modal JavaScript pour afficher et masquer la fenêtre modale
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("editBtn");
        var span = document.getElementsByClassName("close")[0];

        if (btn) {
            btn.onclick = function() {
                modal.style.display = "block";
            }
        }

        if (span) {
            span.onclick = function() {
                modal.style.display = "none";
            }
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
