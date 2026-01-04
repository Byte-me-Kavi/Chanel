

<?php
session_start();

// This line is commented out as the file is not provided, but you would uncomment it in your project.
// require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/header.php';

// Handle Add to Bag (This block executes when a product is added to the cart, typically via 
// a form submission on a product page.)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_name'])) {

    //Creates an array containing the item's details (name, price, image) pulled 
    // directly from the $_POST data.
    $product = [
        "name" => $_POST['product_name'],
        "price" => $_POST['price'],
        "image" => $_POST['image']
    ];

    //Adds the new product array to the end of the $_SESSION['cart'] array.
    $_SESSION['cart'][] = $product;

     // Redirect to the same page to prevent form resubmission on refresh
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// This block executes when the user clicks the "Remove" button next to an item, 
if (isset($_GET['remove'])) {
    $removeIndex = $_GET['remove'];
    if (isset($_SESSION['cart'][$removeIndex])) {
        unset($_SESSION['cart'][$removeIndex]);

        //Removes the item from the session's cart array using its index.
        $_SESSION['cart'] = array_values($_SESSION['cart']); // reindex array
    }
     // Redirect to the same page to clean the URL
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shopping Bag</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // This small script handles the visual selection of the wrapping options,
        // which was previously done with the .selected CSS class.
        document.addEventListener('DOMContentLoaded', function () {
            const wrapOptions = document.querySelectorAll('input[name="wrap"]');

            function applySelectedStyle() {
                // First, remove the selected style from all boxes
                document.querySelectorAll('.option-box').forEach(box => {
                    box.classList.remove('border-black');
                    box.classList.add('border-gray-300'); // Default border
                });
                // Then, add it to the checked one's parent
                const checkedRadio = document.querySelector('input[name="wrap"]:checked');
                if (checkedRadio) {
                    const parentBox = checkedRadio.closest('.option-box');
                    parentBox.classList.add('border-black');
                    parentBox.classList.remove('border-gray-300');
                }
            }
            
            // Apply style on initial page load
            applySelectedStyle();

            // Apply style whenever a new option is chosen
            wrapOptions.forEach(radio => {
                radio.addEventListener('change', applySelectedStyle);
            });
        });
    </script>
</head>
<body class="font-sans bg-white text-gray-900">

    <div class="max-w-5xl mx-auto my-12 px-4">
        <h1 class="text-4xl font-light tracking-widest text-center">My Shopping Bag</h1>
        <h2 class="text-center text-sm font-normal text-gray-600 mt-2">CHANEL presents each purchase in signature packaging</h2>

        <div class="mt-10">
            <?php if (!empty($_SESSION['cart'])): ?>
                <?php 
                    $total = 0;
                    foreach ($_SESSION['cart'] as $index => $item): 
                        $total += $item['price'];
                ?>
                    <div class="flex justify-between items-center border-b border-gray-200 py-4">
                        <div class="flex items-center gap-4">
                           <img src="<?php echo htmlspecialchars(isset($item['image']) ? $item['image'] : 'img/placeholder.png'); ?>" 
                                 alt="<?php echo htmlspecialchars($item['name']); ?>" class="w-20 h-20 object-cover rounded">
                            <div>
                                <span class="text-lg font-medium"><?php echo htmlspecialchars($item['name']); ?></span>
                            </div>
                        </div>
                        <div class="flex items-center gap-8">
                            <span class="text-base font-medium">$<?php echo number_format($item['price'], 2); ?></span>
                            <form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="m-0">
                                <input type="hidden" name="remove" value="<?php echo $index; ?>">
                                <button type="submit" class="bg-none border-none text-red-700 cursor-pointer text-sm uppercase tracking-wider font-medium hover:underline">Remove</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="mt-8 text-xl font-bold text-right">Total: $<?php echo number_format($total, 2); ?></div>

                <!-- WRAPPING OPTIONS -->
                <div class="mt-16">
                    <h2 class="uppercase font-bold tracking-wider text-lg">WRAPPING OPTIONS</h2>
                    <hr class="mt-2 mb-6 border-0 border-t border-black">
                    <div class="space-y-4">
                        <div class="option-box border border-gray-300 p-5 cursor-pointer">
                            <label class="flex items-start">
                                <input type="radio" name="wrap" checked class="mt-5 mr-5 h-5 w-5 accent-black">
                                <div class="flex-grow flex justify-between items-start">
                                    <div class="flex items-start">
                                        <img src="/Website/img/es.webp" alt="The Essential" class="w-20 mr-5">
                                        <div>
                                            <div class="title font-bold uppercase">THE ESSENTIAL</div>
                                            <div class="desc max-w-lg text-gray-700 mt-1">An organic cotton pouch placed directly in a shipping box. This option is not available for Click & Collect.</div>
                                            <a href="#" class="text-gray-600 underline text-sm mt-2 inline-block">Learn more</a>
                                        </div>
                                    </div>
                                    <div class="right font-bold">COMPLIMENTARY</div>
                                </div>
                            </label>
                        </div>
                        <div class="option-box border border-gray-300 p-5 cursor-pointer">
                            <label class="flex items-start">
                                <input type="radio" name="wrap" class="mt-5 mr-5 h-5 w-5 accent-black">
                                <div class="flex-grow flex justify-between items-start">
                                    <div class="flex items-start">
                                        <img src="/Website/img/cl.webp" alt="The Classic" class="w-20 mr-5">
                                        <div>
                                            <div class="title font-bold uppercase">THE CLASSIC</div>
                                            <div class="desc max-w-lg text-gray-700 mt-1">Presented in a signature black-and-white box or bag.</div>
                                            <a href="#" class="text-gray-600 underline text-sm mt-2 inline-block">Learn more</a>
                                        </div>
                                    </div>
                                    <div class="right font-bold">COMPLIMENTARY</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- GIFT MESSAGE -->
                <div class="max-w-4xl mx-auto mt-16 p-8 bg-gray-50">
                    <h3 class="font-bold uppercase tracking-wider">GIFT MESSAGE</h3>
                    <hr class="border-0 border-t border-black mt-2 mb-5">
                    <p class="text-gray-700 mb-6 max-w-3xl">Add a personal touch with a complimentary gift message. Choose to receive a blank card with your purchase, or write your message here and receive it printed.</p>
                    <form class="space-y-3">
                        <label class="flex items-center cursor-pointer"><input type="radio" name="gift" checked class="h-4 w-4 mr-3 accent-black">Do not include a card</label>
                        <label class="flex items-center cursor-pointer"><input type="radio" name="gift" class="h-4 w-4 mr-3 accent-black">Include a blank card</label>
                        <label class="flex items-center cursor-pointer"><input type="radio" name="gift" class="h-4 w-4 mr-3 accent-black">Write a message</label>
                    </form>
                </div>
                
                <!-- EXCLUSIVE SAMPLES -->
                <div class="max-w-6xl mx-auto my-20 p-5">
                    <h3 class="uppercase font-bold tracking-wider">EXCLUSIVE SAMPLES</h3>
                    <hr class="border-0 border-t border-black mt-1 mb-5">
                    <p class="text-gray-700 mb-5">Choose up to 2 complimentary samples with every order. For Click & Collect, product samples are subject to availability at the boutique.</p>
                    <form class="mb-8"><label class="cursor-pointer"><input type="radio" name="sample_option" checked class="h-4 w-4 mr-2 accent-black">Select your samples (0/2)</label></form>
                    <div class="flex gap-5 overflow-x-auto pb-4">
                        <div class="flex-shrink-0 w-64 border border-gray-300 p-5 text-center rounded-md"><img src="/Website/img/s1.webp" alt="CHANCE EAU SPLENDIDE" class="h-40 mx-auto mb-4"><h4 class="text-sm font-bold uppercase">CHANCE EAU SPLENDIDE</h4><p class="text-sm text-gray-700 my-1">Eau de Parfum Spray</p><a href="#" class="text-sm underline text-black">View details →</a></div>
                        <div class="flex-shrink-0 w-64 border border-gray-300 p-5 text-center rounded-md"><img src="/Website/img/s2.webp" alt="COCO MADEMOISELLE" class="h-40 mx-auto mb-4"><h4 class="text-sm font-bold uppercase">COCO MADEMOISELLE</h4><p class="text-sm text-gray-700 my-1">Eau de Parfum Spray</p><a href="#" class="text-sm underline text-black">View details →</a></div>
                        <div class="flex-shrink-0 w-64 border border-gray-300 p-5 text-center rounded-md"><img src="/Website/img/s3.webp" alt="BLEU DE CHANEL" class="h-40 mx-auto mb-4"><h4 class="text-sm font-bold uppercase">BLEU DE CHANEL</h4><p class="text-sm text-gray-700 my-1">Parfum Spray</p><a href="#" class="text-sm underline text-black">View details →</a></div>
                        <div class="flex-shrink-0 w-64 border border-gray-300 p-5 text-center rounded-md"><img src="/Website/img/s4.webp" alt="HYDRA BEAUTY MICRO SÉRUM" class="h-40 mx-auto mb-4"><h4 class="text-sm font-bold uppercase">HYDRA BEAUTY MICRO SÉRUM</h4><p class="text-sm text-gray-700 my-1">Rebalancing<br>Replenishing<br>Hydration</p><a href="#" class="text-sm underline text-black">View details →</a></div>
                    </div>
                    <div class="text-center mt-6 text-lg"><span>1 / 2</span><span class="arrow text-2xl ml-2 cursor-pointer">›</span></div>
                </div>

                <!-- CHECKOUT & PAYPAL -->
                <div class="text-center mt-8">
                    <a href="checkout.php" class="inline-block bg-black text-white py-3 px-8 uppercase tracking-wider text-base hover:bg-gray-800 rounded-sm">Checkout</a>
                    <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-4KG88191XU6437624" class="block w-48 p-2 border border-black bg-white mx-auto mt-8"><img src="/Website/img/pay.png" alt="PayPal" class="h-5 mx-auto"></a>
                </div>

            <?php else: ?>
                <div class="text-center py-12">
                    <div class="text-lg text-gray-500">Your bag is empty.</div>
                </div>
            <?php endif; ?>
        </div>

        <div class="text-center my-8">
            <a href="/Website/app/View/pages/product.php" class="inline-block px-8 py-4 text-center bg-gradient-to-r from-black to-gray-700 border-none rounded-md text-white font-bold uppercase tracking-wider text-base cursor-pointer transition-transform duration-200 hover:scale-105">Continue Shopping</a>
        </div>
    </div>

    <!-- PAYMENT SECTION -->
    <div class="bg-gray-100 text-center py-10 px-5 mt-10">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-xl font-bold mb-5 tracking-wider">PAYMENT METHODS</h2>
            <div class="flex justify-center flex-wrap gap-4 items-center mb-8">
                <img src="/Website/img/visa.png" alt="Visa" class="h-8 object-contain border border-gray-300 rounded bg-white p-1">
                <img src="/Website/img/am.png" alt="American Express" class="h-8 object-contain border border-gray-300 rounded bg-white p-1">
                <img src="/Website/img/mas.png" alt="MasterCard" class="h-8 object-contain border border-gray-300 rounded bg-white p-1">
                <img src="/Website/img/dis.png" alt="Discover" class="h-8 object-contain border border-gray-300 rounded bg-white p-1">
                <img src="/Website/img/din.png" alt="Diners Club" class="h-8 object-contain border border-gray-300 rounded bg-white p-1">
                <img src="/Website/img/jcb.jpg" alt="JCB" class="h-8 object-contain border border-gray-300 rounded bg-white p-1">
                <img src="/Website/img/pa.png" alt="PayPal" class="h-8 object-contain border border-gray-300 rounded bg-white p-1">
                <img src="/Website/img/p.png" alt="Apple Pay" class="h-8 object-contain border border-gray-300 rounded bg-white p-1">
            </div>
            <div>
                <h3 class="text-base font-bold mb-2">SECURE PAYMENT</h3>
                <p class="text-sm text-gray-700">Your credit card details are safe with us.</p>
                <p class="text-sm text-gray-700 my-1">All the information is protected using Secure Sockets Layer (SSL) technology.</p>
                <a href="#" class="inline-block mt-3 underline text-black text-sm">Privacy Policy</a>
            </div>
        </div>
    </div>

    <?php // require_once __DIR__ . '/../layouts/footer.php'; ?>
</body>
</html>

<?php 
// Include the footer file to close the page structure
require_once __DIR__ . '/../layouts/footer.php'; 
?>

