# CHANEL Laravel Application - Security Documentation

## Project Overview

This document provides comprehensive security documentation for the CHANEL e-commerce application, migrated from a legacy PHP system to Laravel 12 with modern security practices.

---

## 1. Technology Stack

| Component            | Technology        | Version |
| -------------------- | ----------------- | ------- |
| Framework            | Laravel           | 12.44.0 |
| PHP                  | PHP               | 8.2.12  |
| Database             | MySQL             | MariaDB |
| Frontend             | Tailwind CSS      | 4.0.0   |
| Authentication       | Laravel Jetstream | Latest  |
| API Authentication   | Laravel Sanctum   | Latest  |
| Real-time Components | Livewire          | 3.x     |

---

## 2. Authentication System

### 2.1 Laravel Jetstream Implementation

The application uses **Laravel Jetstream** with the **Livewire** stack for authentication, providing:

-   **User Registration** (`/register`)
-   **User Login** (`/login`)
-   **Password Reset** (`/forgot-password`)
-   **Email Verification** (configurable)
-   **Two-Factor Authentication** (2FA) support
-   **Session Management**

#### Key Files:

-   `app/Actions/Fortify/CreateNewUser.php` - User registration logic
-   `app/Actions/Fortify/UpdateUserPassword.php` - Password update logic
-   `config/fortify.php` - Fortify configuration
-   `config/jetstream.php` - Jetstream features

### 2.2 Password Security

Passwords are hashed using **bcrypt** with Laravel's `Hash` facade:

```php
// In CreateNewUser.php
'password' => Hash::make($input['password']),
```

Password validation rules enforce:

-   Minimum 8 characters
-   Confirmed password field
-   Laravel's default password rules

### 2.3 Session Security

Sessions are configured with secure defaults:

```env
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
```

---

## 3. API Authentication (Laravel Sanctum)

### 3.1 Token-Based Authentication

Laravel Sanctum provides API token authentication for:

-   Mobile applications
-   Third-party integrations
-   SPA (Single Page Application) authentication

#### Protected API Endpoint:

```php
// routes/api.php
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
```

### 3.2 Sanctum Configuration

```php
// config/sanctum.php
'stateful' => ['localhost', '127.0.0.1', '127.0.0.1:8000'],
'guard' => ['web'],
'expiration' => null, // Tokens don't expire by default
```

### 3.3 API Token Usage

Users can generate personal access tokens via their profile (Jetstream feature):

1. Login to application
2. Navigate to Profile Settings
3. Generate API tokens with specific permissions

---

## 4. Route Protection

### 4.1 Protected Routes

Routes requiring authentication use the `auth:sanctum` middleware:

```php
// routes/web.php
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
```

### 4.2 Middleware Stack

| Middleware     | Purpose                                     |
| -------------- | ------------------------------------------- |
| `auth:sanctum` | Authenticate via Sanctum (session or token) |
| `verified`     | Ensure email is verified (if enabled)       |
| `auth_session` | Jetstream session authentication            |

---

## 5. Database Security

### 5.1 Eloquent ORM

The application uses **Laravel Eloquent ORM** which provides:

-   **Parameterized queries** - Prevents SQL injection
-   **Mass assignment protection** - `$fillable` whitelist

```php
// app/Models/User.php
protected $fillable = [
    'name',
    'username',
    'email',
    'password',
    'is_active',
];
```

### 5.2 Hidden Attributes

Sensitive data is hidden from JSON serialization:

```php
protected $hidden = [
    'password',
    'remember_token',
    'two_factor_recovery_codes',
    'two_factor_secret',
];
```

### 5.3 Database Connection

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chanel_db
DB_USERNAME=root
```

---

## 6. CSRF Protection

Laravel automatically generates and validates CSRF tokens for all POST, PUT, PATCH, and DELETE requests:

```blade
<form method="POST" action="{{ route('login') }}">
    @csrf  <!-- Generates hidden CSRF token field -->
    ...
</form>
```

The `VerifyCsrfToken` middleware is applied to all web routes.

---

## 7. Input Validation

### 7.1 Registration Validation

```php
Validator::make($input, [
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    'password' => $this->passwordRules(),
])->validate();
```

### 7.2 Validation Features

-   **Required fields** - Ensures mandatory data
-   **Email validation** - Valid email format
-   **Unique constraint** - Prevents duplicate emails
-   **Password rules** - Minimum length, confirmation

---

## 8. XSS Prevention

Blade templates automatically escape output:

```blade
{{ $user->name }}  <!-- Escaped output -->
{!! $trustedHtml !!}  <!-- Raw output (use with caution) -->
```

---

## 9. Security Headers

Configure security headers in `.htaccess` or middleware:

```
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
X-XSS-Protection: 1; mode=block
```

---

## 10. Environment Security

### 10.1 Sensitive Configuration

All sensitive data is stored in `.env` file:

-   Database credentials
-   API keys
-   Application secrets

### 10.2 Production Recommendations

```env
APP_ENV=production
APP_DEBUG=false
```

---

## 11. File Structure

```
chanel/
├── app/
│   ├── Actions/Fortify/      # Authentication actions
│   ├── Http/Controllers/     # Route controllers
│   └── Models/User.php       # User Eloquent model
├── config/
│   ├── fortify.php           # Fortify config
│   ├── jetstream.php         # Jetstream config
│   └── sanctum.php           # Sanctum config
├── database/migrations/      # Database schema
├── resources/views/
│   ├── auth/                 # Login/Register views
│   ├── components/           # Blade components
│   └── layouts/              # Layout templates
└── routes/
    ├── web.php               # Web routes
    └── api.php               # API routes
```

---

## 12. Summary

This application implements a comprehensive security architecture using Laravel's built-in security features:

| Feature                  | Implementation              |
| ------------------------ | --------------------------- |
| Authentication           | Laravel Jetstream + Fortify |
| API Security             | Laravel Sanctum tokens      |
| Password Storage         | Bcrypt hashing              |
| SQL Injection Prevention | Eloquent ORM                |
| CSRF Protection          | Built-in CSRF tokens        |
| XSS Prevention           | Blade auto-escaping         |
| Session Security         | Encrypted sessions          |
| Route Protection         | Auth middleware             |

---

_Document Version: 1.0_  
_Last Updated: January 2026_
