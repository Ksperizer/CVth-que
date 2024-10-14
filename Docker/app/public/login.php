<?php
session_start();
require 'data.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"]== "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare a select statement
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(params:[$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])){
            $_SESSION['user_id'] = $admin['id'];
            header("Location: index.php");
        } else {
            echo "Nom d'utilisateur ou mot de passe incorrect";
        }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=7, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Admin Connexion</h2>
        <?php if (!empty($error)): ?>
            <p style="color:red;"><?php echo $error?></p>
        <?php endif; ?>

        <form action="login.php" method="post">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Connexion">
        </form>