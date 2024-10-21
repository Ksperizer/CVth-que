<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
        require __DIR__ . '/home.php';
        break;
    case '/register' :
        require __DIR__ . '/register.php';
        break;
    case '/login' :
        require __DIR__ . '/login.php';
        break;
    case '/profile' :
        require __DIR__ . '/profile.php';
        break;
    case '/logout' :
        require __DIR__ . '/logout.php';
        break;
    case '/404' :
        require __DIR__ . '/404.php';
        break;
    case '/cv' :
        require __DIR__ . 'cv.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/404.php';
        break;
}

// Connect to the database 
try {
    $bdd = new PDO('mysql:host=;dbname=cv_db;charset=utf8', 'root', 'root', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /home.php");
    exit;
}

$userId = $_SESSION['user_id'];

// user information
$stmt = $bdd->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $userId]);
$user = $stmt->fetch();

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

// update user information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $firstName = $_POST['firstName'];
    $title = $_POST['title'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $profileDescription = $_POST['profileDescription'];

    // update user information
    $sql = "UPDATE users SET name = ?, first_name = ?, title = ?, email = ?, phone = ?, profile_description = ? WHERE id = ?";
    $stmt = $bdd->prepare($sql);
    if ($stmt->execute([$name, $firstName, $title, $email, $phone, $profileDescription, $userId])) {
        // Rediriger pour éviter la soumission multiple
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Erreur lors de la mise à jour des informations.";
    }
}
?>

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
        <!-- Header Section -->
        <header>
            <h1><?php echo htmlspecialchars($name); ?></h1>
            <p><?php echo htmlspecialchars($title); ?></p>
            <p>Email: <?php echo htmlspecialchars($email); ?> | Téléphone: <?php echo htmlspecialchars($phone); ?></p>
            <button id="editBtn">Modifier mes informations</button>
            <a href="logout.php">Se déconnecter</a>
        </header>

        <!-- Section Profil -->
        <section class="profile">
            <h2>Profil</h2>
            <p><?php echo htmlspecialchars($profileDescription); ?></p>
        </section>

        <!-- Modal pour la modification des informations de profil -->
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
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("editBtn");
        var span = document.getElementsByClassName("close")[0];

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
