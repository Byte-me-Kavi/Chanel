<?php
// Calculate the relative path from the script's directory
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$requestUri = $_SERVER['REQUEST_URI'];

// Remove the script directory from the request URI to get the relative route
if (strpos($requestUri, $scriptDir) === 0) {
    $request = substr($requestUri, strlen($scriptDir));
} else {
    $request = $requestUri;
}

// Remove query string
$request = strtok($request, '?');

// Remove trailing slash if it's not the root
if ($request !== '/' && substr($request, -1) === '/') {
    $request = rtrim($request, '/');
}

// Ensure root is just '/'
if ($request === '') {
    $request = '/';
}

switch ($request) {
    case '/':
    case '/home':
        require_once 'app/View/pages/home.php';
        break;

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
            header('Location: ' . $scriptDir . '/login');
        }
        break;

    case '/logout':
        require_once 'app/Controllers/AuthController.php';
        (new AuthController())->logout();
        break;

    default:
        // Optional: 404 Page
        http_response_code(404);
        echo "404 Not Found";
        break;
}

