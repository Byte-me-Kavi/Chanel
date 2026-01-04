# CHANEL E-Commerce Project Documentation

## Project Overview

A full-featured Laravel e-commerce application built for CHANEL luxury products. The application includes user authentication, product management, shopping cart, checkout, order tracking, wishlist, and admin dashboard.

**Framework:** Laravel 12  
**Authentication:** Laravel Jetstream with Sanctum (Token-Based)  
**Database:** MySQL  
**Frontend:** Blade Templates with Tailwind CSS

---

## Table of Contents

1. [Authentication & Security](#1-authentication--security)
2. [Database Models](#2-database-models)
3. [Controllers](#3-controllers)
4. [Routes](#4-routes)
5. [Views](#5-views)
6. [Middleware](#6-middleware)
7. [Features Summary](#7-features-summary)

---

## 1. Authentication & Security

### Token-Based Authentication

-   **Laravel Sanctum** provides token-based authentication via Jetstream
-   Session-based authentication for web with `auth:sanctum` middleware
-   CSRF protection on all forms using `@csrf` directive

### Password Security

-   Passwords hashed using **bcrypt** algorithm
-   Password validation with minimum length requirements

### Role-Based Access Control

-   **User roles:** `user` (default), `admin`
-   Role stored in `users.role` column (enum)
-   Admin middleware protects admin routes

### Protected Routes

| Route Group   | Middleware        | Description     |
| ------------- | ----------------- | --------------- |
| `/orders/*`   | `auth:sanctum`    | User orders     |
| `/wishlist/*` | `auth:sanctum`    | User wishlist   |
| `/admin/*`    | `AdminMiddleware` | Admin dashboard |

---

## 2. Database Models

### User (`app/Models/User.php`)

| Column    | Type                 | Description     |
| --------- | -------------------- | --------------- |
| id        | int                  | Primary key     |
| username  | varchar              | Username        |
| name      | varchar              | Full name       |
| email     | varchar              | Email (unique)  |
| password  | varchar              | Hashed password |
| role      | enum('user','admin') | User role       |
| is_active | boolean              | Account status  |

### Product (`app/Models/Product.php`)

| Column      | Type    | Description         |
| ----------- | ------- | ------------------- |
| id          | int     | Primary key         |
| name        | varchar | Product name        |
| description | text    | Description         |
| price       | decimal | Price               |
| image       | varchar | Image path          |
| image_url   | varchar | Secondary image URL |

**Relationships:** `reviews()` - HasMany Review

### Order (`app/Models/Order.php`)

| Column       | Type    | Description          |
| ------------ | ------- | -------------------- |
| id           | int     | Primary key          |
| user_id      | int     | Foreign key to users |
| product_name | varchar | Product ordered      |
| price        | decimal | Order price          |
| quantity     | int     | Quantity             |
| order_status | varchar | Status               |

### Review (`app/Models/Review.php`)

| Column      | Type    | Description             |
| ----------- | ------- | ----------------------- |
| id          | int     | Primary key             |
| product_id  | int     | Foreign key to products |
| author_name | varchar | Reviewer name           |
| rating      | int     | 1-5 stars               |
| review_text | text    | Review content          |

**Relationships:** `product()` - BelongsTo Product

### Wishlist (`app/Models/Wishlist.php`)

| Column     | Type | Description             |
| ---------- | ---- | ----------------------- |
| id         | int  | Primary key             |
| user_id    | int  | Foreign key to users    |
| product_id | int  | Foreign key to products |

**Relationships:** `product()`, `user()`

### Delivery (`app/Models/Delivery.php`)

| Column        | Type    | Description     |
| ------------- | ------- | --------------- |
| id            | int     | Primary key     |
| order_number  | varchar | Order reference |
| customer_name | varchar | Customer name   |
| status        | enum    | Delivery status |

---

## 3. Controllers

### HomeController

-   `index()` - Display home page with products

### ProductController

-   `index()` - List all products
-   `show($id)` - Product details page
-   `exclusives()` - Exclusives page

### CartController

-   `index()` - Display cart
-   `add()` - Add product to cart
-   `remove($index)` - Remove item
-   `clear()` - Clear cart

### CheckoutController

-   `index()` - Checkout page (blocks admin users)
-   `store()` - Process order with database transaction
-   `success()` - Order confirmation

### OrderController (Auth-Protected)

-   `index()` - List user's orders
-   `track($id)` - Order tracking page
-   `status($id)` - API endpoint for AJAX polling

### WishlistController (Auth-Protected)

-   `index()` - Display wishlist
-   `add()` - Add to wishlist
-   `remove($id)` - Remove from wishlist

### SearchController

-   `index()` - Search products by name/description

### ReviewController

-   `store($id)` - Submit product review

### AdminController (Admin-Protected)

-   `index()` - Admin dashboard with tabs
-   CRUD operations for Deliveries, Products, Users

### AdminAuthController

-   `showLoginForm()` - Admin login page
-   `login()` - Authenticate admin
-   `logout()` - Admin logout

---

## 4. Routes

### Public Routes

| Method | URI                    | Name         | Controller                   |
| ------ | ---------------------- | ------------ | ---------------------------- |
| GET    | `/`                    | -            | HomeController@index         |
| GET    | `/product`             | product      | ProductController@index      |
| GET    | `/product/{id}`        | product.show | ProductController@show       |
| GET    | `/exclusives`          | exclusives   | ProductController@exclusives |
| GET    | `/about`               | about        | view('about')                |
| GET    | `/search`              | search       | SearchController@index       |
| POST   | `/product/{id}/review` | review.store | ReviewController@store       |

### Cart Routes

| Method | URI                    | Name        | Controller            |
| ------ | ---------------------- | ----------- | --------------------- |
| GET    | `/cart`                | cart.index  | CartController@index  |
| POST   | `/cart/add`            | cart.add    | CartController@add    |
| DELETE | `/cart/remove/{index}` | cart.remove | CartController@remove |
| POST   | `/cart/clear`          | cart.clear  | CartController@clear  |

### Checkout Routes

| Method | URI                 | Name             | Controller                 |
| ------ | ------------------- | ---------------- | -------------------------- |
| GET    | `/checkout`         | checkout.index   | CheckoutController@index   |
| POST   | `/checkout`         | checkout.store   | CheckoutController@store   |
| GET    | `/checkout/success` | checkout.success | CheckoutController@success |

### Auth-Protected Routes (auth:sanctum)

| Method | URI                   | Name            | Controller                |
| ------ | --------------------- | --------------- | ------------------------- |
| GET    | `/orders`             | orders.index    | OrderController@index     |
| GET    | `/orders/{id}/track`  | orders.track    | OrderController@track     |
| GET    | `/orders/{id}/status` | orders.status   | OrderController@status    |
| GET    | `/wishlist`           | wishlist.index  | WishlistController@index  |
| POST   | `/wishlist/add`       | wishlist.add    | WishlistController@add    |
| DELETE | `/wishlist/{id}`      | wishlist.remove | WishlistController@remove |

### Admin Routes (AdminMiddleware)

| Method | URI               | Name                 | Controller                        |
| ------ | ----------------- | -------------------- | --------------------------------- |
| GET    | `/admin/login`    | admin.login          | AdminAuthController@showLoginForm |
| POST   | `/admin/login`    | admin.login.submit   | AdminAuthController@login         |
| GET    | `/admin`          | admin.index          | AdminController@index             |
| POST   | `/admin/delivery` | admin.delivery.store | AdminController@storeDelivery     |
| POST   | `/admin/product`  | admin.product.store  | AdminController@storeProduct      |
| POST   | `/admin/user`     | admin.user.store     | AdminController@storeUser         |

---

## 5. Views

### Layouts

-   `layouts/frontend.blade.php` - Main layout with navbar/footer
-   `layouts/app.blade.php` - Jetstream app layout
-   `layouts/guest.blade.php` - Guest layout for auth pages

### Pages

| View                         | Description                     |
| ---------------------------- | ------------------------------- |
| `home.blade.php`             | Homepage with hero and products |
| `product.blade.php`          | Product listing                 |
| `product-details.blade.php`  | Single product with reviews     |
| `exclusives.blade.php`       | Exclusive products              |
| `cart.blade.php`             | Shopping cart                   |
| `checkout.blade.php`         | Checkout form                   |
| `checkout-success.blade.php` | Order confirmation              |
| `search.blade.php`           | Search results                  |
| `wishlist.blade.php`         | User wishlist                   |
| `about.blade.php`            | About page                      |

### Admin Views

| View                        | Description               |
| --------------------------- | ------------------------- |
| `admin/dashboard.blade.php` | Admin dashboard with tabs |
| `admin/login.blade.php`     | Admin login page          |

### Orders Views

| View                     | Description              |
| ------------------------ | ------------------------ |
| `orders/index.blade.php` | My Orders list           |
| `orders/track.blade.php` | Order tracking with AJAX |

### Components

-   `components/navbar.blade.php` - Navigation with auth-aware menu

---

## 6. Middleware

### AdminMiddleware (`app/Http/Middleware/AdminMiddleware.php`)

```php
// Checks if user is authenticated AND has role === 'admin'
if (Auth::user()->role !== 'admin') {
    return redirect('/')->with('error', 'Unauthorized access.');
}
```

### Built-in Middleware Used

-   `auth:sanctum` - Token-based authentication
-   `verified` - Email verification
-   `web` - Session, CSRF protection

---

## 7. Features Summary

| Feature           | Status | Security                       |
| ----------------- | ------ | ------------------------------ |
| User Registration | ✅     | Password hashing, validation   |
| User Login        | ✅     | Sanctum tokens, rate limiting  |
| Product Listing   | ✅     | Public access                  |
| Product Details   | ✅     | Public access                  |
| Product Reviews   | ✅     | CSRF protection                |
| Shopping Cart     | ✅     | Session-based                  |
| Checkout          | ✅     | DB transactions, admin blocked |
| Order History     | ✅     | Auth-protected, user-specific  |
| Order Tracking    | ✅     | Auth-protected, AJAX polling   |
| Wishlist          | ✅     | Auth-protected                 |
| Search            | ✅     | Public access                  |
| Admin Dashboard   | ✅     | Role-based protection          |
| Admin CRUD        | ✅     | AdminMiddleware                |

---

## Admin Credentials

| Email            | Password |
| ---------------- | -------- |
| admin@chanel.com | admin123 |

---

## Security Measures

1. **Token-Based Auth** - Laravel Sanctum via Jetstream
2. **CSRF Protection** - All forms include `@csrf` token
3. **Password Hashing** - Bcrypt algorithm
4. **Input Validation** - `$request->validate()` on all inputs
5. **Mass Assignment Protection** - `$fillable` defined on models
6. **SQL Injection Prevention** - Eloquent ORM parameterized queries
7. **XSS Protection** - Blade `{{ }}` auto-escaping
8. **Role-Based Access** - Admin middleware for `/admin` routes
9. **Rate Limiting** - Login attempts limited per minute
10. **Session Security** - Secure session configuration
