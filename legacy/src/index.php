<?php
$request = strtok($_SERVER['REQUEST_URI'], '?');

switch ($request) {
    // ... your other routes like '/' ...

    case '/login':
        require_once 'app/Controllers/AuthController.php';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new AuthController())->login();
        } else {
            (new AuthController())->showLoginForm();
        }
        break;

    case '/register':
        require_once 'app/Controllers/AuthController.php';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new AuthController())->register();
        } else {
            header('Location: /login');
        }
        break;

    case '/logout':
        require_once 'app/Controllers/AuthController.php';
        (new AuthController())->logout();
        break;

    // ... other routes ...
}

