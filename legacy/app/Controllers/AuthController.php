<?php
require_once __DIR__ . '/../View/auth/login.php';

class AuthController {

    public function showLoginForm() {
        require __DIR__ . '/../View/auth/login.php';
    }

    public function login() {
        $userModel = new User();
        $user = $userModel->findByEmail($_POST['email']);

        if ($user && password_verify($_POST['password'], $user['password'])) {
            if (session_status() === PHP_SESSION_NONE) { session_start(); }
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            
            if ($user['role'] === 'admin') {
                header('Location: /admin/dashboard'); // Redirect admin
            } else {
                header('Location: /'); // Redirect regular user
            }
            exit();
        } else {
            header('Location: /login?error=1');
            exit();
        }
    }
    
    public function register() {
        $userModel = new User();
        $userModel->register($_POST['name'], $_POST['email'], $_POST['password']);
        // After registering, automatically try to log them in
        $this->login();
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        session_destroy();
        header('Location: /');
        exit();
    }
}






















