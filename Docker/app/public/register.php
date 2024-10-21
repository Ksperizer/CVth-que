<?php
require 'config.php';

$error = [];

if ($_SERVER['REQUEST_METHOD']== "POST"){
    $username = $_POST['username'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];


    if (empty($username) || empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($passwordConfirm)){
        $error[] = "Tous les champs sont obligatoires";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error[] = "L'adresse email n'est pas valide";
    }elseif ($password != $passwordConfirm){
        $error[] = "Les mots de passe ne correspondent pas";
    }else{
        $stmt = $bdd->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user){
            $error[] = "L'adresse email est déjà utilisée";
        }
    }
    if (empty($error)){

        $hasedPassword = password_hash($password, PASSWORD_DEFAULT);

        try{
            $stmt = $bdd->prepare("INSERT INTO users(username, firstName, lastName, email, password) VALUES(:username, :firstName, :lastName, :email, :password)");
            $stmt->execute([
            'username' => $username,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'password' => $hasedPassword
        ]);

        //Redirect 
        $_SESSION['message'] = 'Inscription réussie! Vous pouvez vous connecter';
        header("Location: login.php");
        exit;
    }catch (PDOException $e){
        $error[] = "Erreur lors de l'inscription: " . $e->getMessage();
    }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - CVth-que</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="register.css">
</head>
<body>
<div class="container">
        <h2>Enregistrement</h2>
        <!-- Error Spec -->
        <?php if (!empty($error)): ?>
            <div class="errors">
                <ul>
                    <?php foreach ($error as $e): ?>
                        <li><?php echo htmlspecialchars($e); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Register form -->
        <form action="register.php" method="post">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" required>

            <label for="firstName">Prénom</label>
            <input type="text" id="firstName" name="firstName" required>

            <label for="lastName">Nom</label>
            <input type="text" id="lastName" name="lastName" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe</label>  
            <input type="password" id="password" name="password" required>

            <label for="passwordConfirm">Confirmer le mot de passe</label>
            <input type="password" id="passwordConfirm" name="passwordConfirm" required>

            <button type="submit">S'inscrire</button>
        </form>
    </div>
</body>
</html>