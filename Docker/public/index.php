<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
echo "Démarrage de index.php";

require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../app/router.php';
