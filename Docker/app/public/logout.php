<?php
session_start();

// Détruire la session pour déconnecter l'utilisateur
session_unset();
session_destroy();

$success = true; // Déclenche le modal de succès
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
    <style>
 
        .modal {
            display: none; /* hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: modalOpen 0.3s ease-out;
        }

        @keyframes modalOpen {
            from {
                transform: scale(0.7);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <!-- Modal success -->
        <div id="successModal" class="modal">
            <div class="modal-content">
                <h2>Déconnexion réussie !</h2>
                <p>Vous serez redirigé vers la page de connexion dans quelques secondes...</p>
            </div>
        </div>
    </div>

    <script>
        <?php if ($success): ?>
            
            document.getElementById("successModal").style.display = "flex";

            // await 5 seconds before redirecting to login page
            setTimeout(function() {
                window.location.href = "login.php";
            }, 5000);
        <?php endif; ?>
    </script>
</body>
</html>
