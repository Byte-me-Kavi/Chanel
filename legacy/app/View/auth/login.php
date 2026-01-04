<?php
session_start();

// --- Database Connection ---
$host = "localhost";
$dbname = "chanel_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: ". $e->getMessage());
}

// --- Initialize Messages ---
$error_message = '';
$success_message = '';
$validation_code_for_display = ''; // Used to simulate the email

// --- RESEND VALIDATION CODE LOGIC ---
if (isset($_GET['resend_code']) && isset($_SESSION['awaiting_validation_email'])) {
    $email = $_SESSION['awaiting_validation_email'];
    $new_validation_code = rand(100000, 999999);

    // Update the user's validation code in the database for the inactive account
    $stmt = $pdo->prepare("UPDATE users SET validation_code = ? WHERE email = ? AND is_active = 0");
    $stmt->execute([$new_validation_code, $email]);

    // For the demo, prepare to show the new code
    $validation_code_for_display = $new_validation_code;
    $success_message = "A new validation code has been generated.";
}


// --- SIGNUP LOGIC (with re-validation) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $existing_user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_user) {
        if ($existing_user['is_active'] == 1) {
            $error_message = "This email is already registered. Please log in.";
        } else {
            $validation_code = rand(100000, 999999);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $update_stmt = $pdo->prepare("UPDATE users SET username = ?, password = ?, validation_code = ? WHERE email = ?");
            $update_stmt->execute([$username, $hashed_password, $validation_code, $email]);
            
            $_SESSION['awaiting_validation_email'] = $email;
            $validation_code_for_display = $validation_code;
            $success_message = "Verification required! A new validation code has been generated.";
        }
    } else {
        $validation_code = rand(100000, 999999);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, validation_code, is_active) VALUES (?, ?, ?, ?, 0)");
        $stmt->execute([$username, $email, $hashed_password, $validation_code]);

        $_SESSION['awaiting_validation_email'] = $email;
        $validation_code_for_display = $validation_code;
        $success_message = "Account created! Please enter the validation code shown below.";
    }
}


// --- VALIDATION LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['validate'])) {
    $submitted_code = trim($_POST['validation_code']);
    $email = $_SESSION['awaiting_validation_email'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND validation_code = ?");
    $stmt->execute([$email, $submitted_code]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $stmt = $pdo->prepare("UPDATE users SET is_active = 1, validation_code = NULL WHERE email = ?");
        $stmt->execute([$email]);

        unset($_SESSION['awaiting_validation_email']);
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['username'];
        
        header("Location: ". $_SERVER['PHP_SELF']);
        exit;
    } else {
        $error_message = "Invalid validation code. Please re-enter the code.";
    }
}

// --- LOGIN LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        if ($user['is_active'] == 1) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username'];
            header("Location: ". $_SERVER['PHP_SELF']);
            exit;
        } else {
            $error_message = "Your account is not activated. Please validate your account.";
            $_SESSION['awaiting_validation_email'] = $email;
        }
    } else {
        $error_message = "Invalid email or password.";
    }
}

// --- LOGOUT LOGIC ---
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ". $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHANEL - Account</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root { --main-bg: #f8fafc; --card-bg: #ffffff; --text-primary: #111827; --text-secondary: #4b5563; --brand-color: #000000; --accent-color: #e5e7eb; --error-bg: #fee2e2; --error-text: #b91c1c; --success-bg: #dcfce7; --success-text: #15803d; }
        body { font-family: 'Inter', sans-serif; background-color: var(--main-bg); margin: 0; }
        .container { display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 1rem; }
        .card { background-color: var(--card-bg); border-radius: 1.5rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); width: 100%; max-width: 30rem; padding: 3rem; }
        .card-header { text-align: center; }
        .card-header h1 { font-size: 2rem; font-weight: 700; color: var(--text-primary); letter-spacing: 0.1em; text-transform: uppercase; }
        .tab-nav { display: flex; background-color: #f3f4f6; border-radius: 0.75rem; padding: 0.25rem; margin-top: 2rem; }
        .tab-btn { flex: 1; padding: 0.75rem 1rem; border: none; background: none; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; color: var(--text-secondary); cursor: pointer; transition: all 0.2s ease-in-out; }
        .tab-btn.active-tab { background-color: var(--card-bg); color: var(--text-primary); box-shadow: 0 1px 3px 0 rgba(0,0,0,0.1), 0 1px 2px -1px rgba(0,0,0,0.1); }
        .form-content { margin-top: 2rem; padding-left: 1rem; padding-right: 1rem; }
        .form-group { position: relative; margin-bottom: 1.5rem; }
        .form-group .icon { position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); width: 1.25rem; height: 1.25rem; color: #9ca3af; }
        .form-input { width: 100%; padding: 0.75rem 0.75rem 0.75rem 2.5rem; border: 1px solid var(--accent-color); border-radius: 0.5rem; font-size: 0.875rem; transition: all 0.2s ease-in-out; }
        .form-input:focus { outline: none; border-color: var(--brand-color); box-shadow: 0 0 0 3px rgba(0,0,0,0.1); }
        .submit-btn { width: 100%; background-color: var(--brand-color); color: #ffffff; padding: 0.875rem 1rem; border: none; border-radius: 0.5rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer; transition: background-color 0.2s ease-in-out; text-decoration: none; display: inline-block; }
        .submit-btn:hover { background-color: #374151; }
        .alert { padding: 1rem; margin-top: 1.5rem; border-radius: 0.5rem; font-size: 0.875rem; text-align: center; }
        .alert-error { background-color: var(--error-bg); color: var(--error-text); }
        .alert-success { background-color: var(--success-bg); color: var(--success-text); }
        .welcome-card h1 { font-size: 1.875rem; }
        .welcome-card p { color: var(--text-secondary); margin-top: 1rem; }
        .welcome-card .button-group { margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem; }
        .logout-btn { background-color: #ef4444; }
        .logout-btn:hover { background-color: #dc2626; }
        .validation-code-display { margin-top: 1.5rem; padding: 1rem; background-color: #dbeafe; border-left: 4px solid #3b82f6; color: #1d4ed8; text-align: center; }
        .validation-code-display p:first-child { font-weight: 700; }
        .validation-code-display p:last-child { font-size: 1.5rem; letter-spacing: 0.2em; }
        .link { font-size: 0.875rem; color: var(--text-secondary); text-decoration: none; }
        .link:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <div class="card">

        <?php if (isset($_SESSION['loggedin'])): ?>
            <!-- WELCOME SCREEN -->
            <div class="welcome-card text-center">
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                <p>You have successfully logged in.</p>
                <div class="button-group">
                    <a href="app/View/pages/home.php" class="submit-btn">Continue Shopping</a>
                    <a href="?logout=true" class="submit-btn logout-btn">Logout</a>
                </div>
            </div>

        <?php elseif (isset($_SESSION['awaiting_validation_email'])): ?>
            <!-- VALIDATION SCREEN -->
            <div class="card-header"><h1>Validate Account</h1></div>
            <p style="text-align: center; color: var(--text-secondary); margin-top: 0.5rem; font-size: 0.875rem;">Please check your email and enter the code below.</p>
            
            <?php if ($validation_code_for_display): ?>
                <div class="validation-code-display">
                    <p>DEMO: Your Validation Code is</p>
                    <p><?php echo $validation_code_for_display; ?></p>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?><div class="alert alert-error"><?php echo $error_message; ?></div><?php endif; ?>
            <?php if ($success_message): ?><div class="alert alert-success"><?php echo $success_message; ?></div><?php endif; ?>

            <form method="POST" class="form-content">
                <div class="form-group">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <input id="validation_code" name="validation_code" type="text" required class="form-input" placeholder="Validation Code">
                </div>
                <button type="submit" name="validate" class="submit-btn">Validate Account</button>
            </form>
            
            <div style="text-align: center; margin-top: 1.5rem;">
                <p class="link">Didn't receive a code?</p>
                <a href="?resend_code=true" class="link" style="font-weight: 500; color: var(--text-primary);">Resend Code</a>
            </div>
             <div style="text-align: center; margin-top: 1rem;">
                <a href="?logout=true" class="link">Back to Login</a>
            </div>

        <?php else: ?>
            <!-- LOGIN & SIGNUP SCREEN -->
            <div class="card-header"><h1>CHANEL</h1></div>
            <div class="tab-nav">
                <button id="login-tab" class="tab-btn active-tab">Login</button>
                <button id="signup-tab" class="tab-btn">Sign Up</button>
            </div>

            <div class="form-content">
                <!-- Login Form -->
                <div id="login-form">
                    <?php if ($error_message && isset($_POST['login'])): ?><div class="alert alert-error"><?php echo $error_message; ?></div><?php endif; ?>
                    <form method="POST" style="margin-top: 1.5rem;">
                        <div class="form-group">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 10-2.636 6.364M16.5 12V8.25" /></svg>
                            <input id="login-email" name="email" type="email" required class="form-input" placeholder="Email address">
                        </div>
                        <div class="form-group">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                            <input id="login-password" name="password" type="password" required class="form-input" placeholder="Password">
                        </div>
                        <button type="submit" name="login" class="submit-btn">Login</button>
                    </form>
                </div>

                <!-- Signup Form -->
                <div id="signup-form" style="display: none;">
                    <?php if ($error_message && isset($_POST['signup'])): ?><div class="alert alert-error"><?php echo $error_message; ?></div><?php endif; ?>
                    <form method="POST" style="margin-top: 1.5rem;">
                        <div class="form-group">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                            <input id="signup-username" name="username" type="text" required class="form-input" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 10-2.636 6.364M16.5 12V8.25" /></svg>
                            <input id="signup-email" name="email" type="email" required class="form-input" placeholder="Email address">
                        </div>
                        <div class="form-group">
                             <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
                            <input id="signup-password" name="password" type="password" required class="form-input" placeholder="Password">
                        </div>
                        <button type="submit" name="signup" class="submit-btn">Sign Up</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loginTab = document.getElementById('login-tab');
        const signupTab = document.getElementById('signup-tab');
        const loginForm = document.getElementById('login-form');
        const signupForm = document.getElementById('signup-form');

        if (loginTab && signupTab && loginForm && signupForm) {
            loginTab.addEventListener('click', function() {
                loginTab.classList.add('active-tab');
                signupTab.classList.remove('active-tab');
                loginForm.style.display = 'block';
                signupForm.style.display = 'none';
            });

            signupTab.addEventListener('click', function() {
                signupTab.classList.add('active-tab');
                loginTab.classList.remove('active-tab');
                signupForm.style.display = 'block';
                loginForm.style.display = 'none';
            });
        }
    });
</script>

</body>
</html>

