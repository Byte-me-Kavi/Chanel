<?php
// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Defines the cart item count. Sets it to 0 if the cart is empty.
$cart_item_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHANEL</title>
    <link href="/Website/src/style.css" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <div class="header-top">
            <div class="container">
                <div class="header-top-inner">
                    <div class="header-placeholder"></div>
                    <a href="/Website/app/View/pages/home.php" class="logo">CHANEL</a>
                    <div class="header-icons">
                        <a href="#" aria-label="Search">
                            <svg viewBox="0 0 24 24"><path d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" /></svg>
                        </a>
                        <a href="/Website/app/View/auth/login.php" aria-label="Account">
                             <svg viewBox="0 0 24 24"><path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" /></svg>
                        </a>
                        <a href="/Website/ex1.html" aria-label="Wishlist">
                            <svg viewBox="0 0 24 24"><path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.45,13.97L5.82,21L12,17.27Z" /></svg>
                        </a>
                        <a href="/Website/app/View/pages/admin.php" aria-label="Admin">
        <svg viewBox="0 0 24 24">
            <path d="M12,2A10,10 0 1,0 22,12A10,10 0 0,0 12,2ZM12,6A6,6 0 0,1 18,12H16A4,4 0 0,0 12,8V6ZM12,20A8,8 0 0,1 4,12H6A6,6 0 0,0 12,18V20Z"/>
        </svg>
    </a>







                        <a href="/Website/app/View/pages/cart.php" class="shopping-bag" aria-label="Shopping Bag">
                            <svg viewBox="0 0 24 24"><path d="M12,2A3,3 0 0,0 9,5V7H15V5A3,3 0 0,0 12,2M9,8A1,1 0 0,0 8,9V11H6V9A3,3 0 0,1 9,6H15A3,3 0 0,1 18,9V11H16V9A1,1 0 0,0 15,8H9M18,12H6C4.89,12 4,12.9 4,14V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V14C20,12.9 19.1,12 18,12Z" /></svg>
                            <?php if ($cart_item_count > 0): ?>
                                <span class="bag-count"><?= $cart_item_count ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-bottom">
            <nav class="category-nav container">
                <ul>
                    <li><a href="/Website/app/View/pages/home.php">Home</a></li>
                    <li><a href="/Website/app/View/pages/product.php">Product</a></li>
                    <li><a href="/Website/app/View/pages/product_details.php">Exclusives</a></li>
                    <li><a href="/Website/app/View/pages/about.php">ABOUT CHANEL</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        