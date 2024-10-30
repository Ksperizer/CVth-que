<?php

$dsn = 'mysql:host=db;dbname=cv_db;charset=utf8';  
$username = 'root';
$password = 'root';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $bdd = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage()); 
}
