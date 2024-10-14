<?php
// start new session
session_start();

// Include the database connection file
try {
    $bdd = new PDO('mysql:host=localhost;dbname=CV', 'username', 'password');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Error: ' . $e->getMessage());
}


// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
    $userId = $_SESSION['user_id'];

    $stmt = $bdd->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $name = $user['name'];
        $firstName = $user['first_name'];
        $title = $user['title'];
        $email = $user['email'];
        $phone = $user['phone'];
        $profileDescription = $user['profile_description'];
    } else {
        echo "Utilisateur non trouvé.";
        exit;
    }

    // Update user information
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $firstName = $_POST['firstName'];
        $title = $_POST['title'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $profileDescription = $_POST['profileDescription'];

        // update user information
        $sql = "UPDATE users SET name = ?, lastname= ?,  title = ?, email = ?, phone = ?, profile_description = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $title, $email, $phone, $profileDescription, $userId);

        if ($stmt->execute()) {
            // Redirect to the same page to display the updated information
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error updating record: " . $conn->error;
        
    }
} else {
    // Redirect to the login page if the user is not logged in
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
