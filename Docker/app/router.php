<?php

require_once __DIR__ . '/Controllers/AuthController.php';
require_once __DIR__ . '/Controllers/ProfileController.php';
require_once __DIR__ . '/Controllers/HomeController.php';
require_once __DIR__ . '/Controllers/CvController.php'; 

$authController = new AuthController($bdd);
$profileController = new ProfileController($bdd);
$homeController = new HomeController($bdd);
$cvController = new CvController($bdd);

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Routage
switch ($request) {
    case '/' :
    case '/home' : 
        $homeController->index();  
        break;
    case '/register' :
        $authController->register(); 
        break;
    case '/login' :
        $authController->login(); 
        break;
    case '/profile' :
        $profileController->showProfile();  
        break;
    case '/logout' :
        $authController->logout();  
        break;
    case '/cv' :
        $cvController->showUserCV($_SESSION['user_id']); 
        break;
    case '/upload' :
        $cvController->upload(); 
        break;
    case '/cvForm':
        require_once __DIR__ . '/Views/cvForm.html';
        break;      
        case '/saveCV':
            $cvController = new CvController($bdd);
            $cvController->saveCV();
            break;
    default:
        http_response_code(404);
        require __DIR__ . '/Views/404.html';
        break;
}
