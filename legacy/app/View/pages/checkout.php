<?php
session_start();
require_once __DIR__ . '/../layouts/header.php';

// --- DATABASE AND CART LOGIC ---
$host = "localhost";
$dbname = "chanel_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

$cartItems = $_SESSION['cart'] ?? [];
$subtotal = 0;
$tax = 0;
$taxRate = 0.10; // 10% tax rate

// Calculate subtotal from cart
foreach ($cartItems as $item) {
    $subtotal += (float)($item['price'] ?? 0) * (int)($item['quantity'] ?? 1);
}

// Apply tax if subtotal > $200 (Implements a conditional tax rule: the 10% tax is only applied if 
// the order subtotal is greater than $200.)
if ($subtotal > 200) {
    $tax = $subtotal * $taxRate;
}

//Calculates the final total price.
$total = $subtotal + $tax;

// --- ORDER PROCESSING LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
    if (!empty($cartItems)) {
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("INSERT INTO orders (product_name, price, image, quantity) VALUES (?, ?, ?, ?)");
            foreach ($cartItems as $item) {
                $productName = $item['name'] ?? 'Unknown Product';
                $price = (float)($item['price'] ?? 0.0);
                $image = $item['image'] ?? '';
                $quantity = (int)($item['quantity'] ?? 1);
                $stmt->execute([$productName, $price, $image, $quantity]);
            }
            $pdo->commit();
            $_SESSION['cart'] = [];
            $cartItems = []; 
        } catch (PDOException $e) {
            $pdo->rollBack();
            die("Error: Could not place the order. " . $e->getMessage());
        }
    }
}

$deliveryMethods = [
    "Standard Shipping",
    "Express Shipping",
    "Same-Day or Next-Day Delivery",
    "In-Store Pickup (Click and Collect)"
];
//Captures the user's selected delivery method from a form submission or defaults to 'Standard Shipping'.
$selectedDelivery = $_POST['delivery_method'] ?? 'Standard Shipping';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white font-sans">

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl lg:text-4xl text-center font-light tracking-[0.2em] my-12 uppercase">Checkout</h1>

        <?php if (!empty($cartItems)): ?>
            <form method="POST" action="checkout.php">
                <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-16">
                    <div class="lg:col-span-2">
                        <p class="text-sm mb-6">Continue as a guest or log in to your personal account.</p>
                        <button type="button" class="w-full sm:w-auto bg-black text-white py-3 px-12 uppercase text-xs tracking-widest hover:bg-gray-800 transition-colors">Continue</button>

                        <div class="mt-12">
                            <h2 class="text-sm font-semibold tracking-widest">DELIVERY METHOD</h2>
                            <hr class="border-black mt-3 mb-6">
                            
                            <select name="delivery_method" required class="w-full p-3 border border-gray-300 text-sm focus:outline-none focus:ring-1 focus:ring-black">
                                <?php foreach ($deliveryMethods as $method): ?>
                                    <option value="<?php echo htmlspecialchars($method); ?>" <?php if ($selectedDelivery == $method) echo 'selected'; ?>>
                                        <?php echo htmlspecialchars($method); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mt-12">
                            <h2 class="text-sm font-semibold tracking-widest">PAYMENT METHOD</h2>
                            <hr class="border-black mt-3 mb-6">
                            <p class="text-sm text-gray-500">Payment integration would appear here.</p>
                        </div>
                        
                        <div class="mt-8 flex items-center">
                            <input type="checkbox" id="privacy" name="privacy" class="h-4 w-4 text-black border-gray-400 focus:ring-black" required>
                            <label for="privacy" class="ml-3 text-sm">
                                By checking this box, I agree to CHANEL's <a href="#" class="underline">Privacy Policy and Legal Statement</a>.
                            </label>
                        </div>
                        
                        <button type="submit" name="confirm_order" class="mt-8 w-full bg-black text-white py-3 px-12 uppercase text-xs tracking-widest hover:bg-gray-800 transition-colors">
                            Confirm Order
                        </button>
                    </div>

                    <div class="w-full mt-12 lg:mt-0">
                        <div class="border-t border-b py-6">
                            <h2 class="text-sm font-semibold tracking-widest mb-4">ORDER SUMMARY</h2>
                            
                            <?php foreach ($cartItems as $item): ?>
                            <div class="flex items-center justify-between py-4">
                                <div class="flex items-start">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="w-20 h-20 object-cover mr-4">
                                    <div>
                                        <h3 class="font-bold uppercase text-sm"><?php echo htmlspecialchars($item['name']); ?></h3>
                                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars($item['description'] ?? 'Body Massage Oil'); ?></p>
                                        <p class="text-sm text-gray-600">8.5FL. OZ.</p>
                                        <p class="text-sm text-gray-800 mt-1">QTY <?php echo $item['quantity'] ?? 1; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            
                            <div class="space-y-3 text-sm mt-6 border-t pt-4">
                                <div class="flex justify-between">
                                    <span>Subtotal</span>
                                    <span>$<?php echo number_format($subtotal, 2); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Taxes* <a href="#" class="text-gray-500 underline ml-1">Information ></a></span>
                                    <span>$<?php echo number_format($tax, 2); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Delivery method <a href="#" class="text-gray-500 underline ml-1">Information ></a></span>
                                    <span>FREE</span>
                                </div>
                                <div class="flex justify-between font-bold text-base mt-4 pt-4 border-t">
                                    <span>TOTAL</span>
                                    <span>$<?php echo number_format($total, 2); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-sm font-semibold tracking-widest mb-4">WRAPPING</h3>
                            <div class="flex items-center text-sm">
                                <img src="/Website/img/cl.webp" alt="Wrapping" class="w-16 mr-4">
                                <div>
                                    <h4 class="font-bold">THE CLASSIC</h4>
                                    <p>Presented in a signature box or bag.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-sm font-semibold tracking-widest mb-4">COMPLIMENTARY SAMPLES</h3>
                            <div class="text-sm space-y-2">
                                <p class="font-bold">CHANCE EAU SPLENDIDE</p>
                                <p>Eau de Parfum Spray</p>
                                <p class="font-bold mt-2">COCO MADEMOISELLE</p>
                                <p>Eau de Parfum Spray</p>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h3 class="text-sm font-semibold tracking-widest mb-4">PAYMENT METHODS</h3>
                            <div class="flex items-center space-x-4 text-gray-500 text-xs">
                                <span>VISA</span> <span>MASTERCARD</span> <span>DISCOVER</span> <span>AMEX</span> <span>PAYPAL</span> <span>APPLE PAY</span>
                            </div>
                             <div class="mt-4">
                                <h4 class="text-sm font-bold tracking-widest">SECURE PAYMENT</h4>
                                <p class="text-xs mt-1">Your credit card details are safe with us.<br>All the information is protected using Secure Sockets Layer (SSL) technology.</p>
                                <a href="#" class="text-sm underline mt-2 inline-block">Privacy Policy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])): ?>
            <div class="text-center py-20">
                <h2 class="text-2xl font-light mb-4">✅ Thank You! Your order has been placed.</h2>
                <p class="text-gray-600 mb-8">You will receive a confirmation email shortly.</p>
                <a href="/Website/app/View/pages/product.php" class="bg-black text-white py-3 px-12 uppercase text-xs tracking-widest hover:bg-gray-800 transition-colors">
                    Continue Shopping
                </a>
            </div>
        <?php else: ?>
            <div class="text-center py-20">
                <p class="text-2xl font-light mb-8">❌ Your cart is empty!</p>
                <a href="/Website/app/View/pages/product.php" class="bg-black text-white py-3 px-12 uppercase text-xs tracking-widest hover:bg-gray-800 transition-colors">
                    Continue Shopping
                </a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
require_once __DIR__ . '/../layouts/footer.php'; 
?>







