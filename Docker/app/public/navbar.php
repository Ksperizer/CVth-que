<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css"> 
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="cv.php">CV</a></li> 
            <li><a href="contact.php">Contact</a></li> 
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="login.php">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <style>
        .navbar {
            background-color: #0056b3;
            padding: 10px 20px;
        }
        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: flex-start;
        }
        .navbar ul li {
            margin-right: 20px;
        }
        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .navbar ul li a:hover {
            text-decoration: underline;
        }
    </style>
</body>
</html>
