<?php
session_start();

require_once __DIR__ . '/../layouts/header.php';

// --- DATABASE CONNECTION ---
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

// --- LOGIC TO GET THE CURRENT PRODUCT ID (from URL: details.php?id=1) ---
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 1; // Default to product 1 if no ID is passed

// --- HANDLE REVIEW FORM SUBMISSION ---
$review_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $author_name = trim($_POST['author_name']);
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $review_text = trim($_POST['review_text']);

    if (!empty($author_name) && $rating > 0 && !empty($review_text)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO reviews (product_id, author_name, rating, review_text) VALUES (?, ?, ?, ?)");
            $stmt->execute([$product_id, $author_name, $rating, $review_text]);
            
            header("Location: details.php?id=" . $product_id . "&review_success=1#reviews-section");
            exit;
        } catch (PDOException $e) {
            $review_message = "Error: Could not submit your review.";
        }
    } else {
        $review_message = "Error: Please fill out all fields, including a rating.";
    }
}

// --- FETCH REVIEWS FOR THIS PRODUCT ---
$reviews = [];
try {
    $stmt = $pdo->prepare("SELECT * FROM reviews WHERE product_id = ? ORDER BY created_at DESC");
    $stmt->execute([$product_id]);
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $reviews = []; // On error, just show no reviews
}

if (isset($_GET['review_success'])) {
    $review_message = "Thank you! Your review has been submitted.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLEU DE CHANEL - Eau de Parfum Spray | CHANEL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        /* A few custom styles that are difficult to replicate with utility classes alone */
        body { font-family: 'Roboto', sans-serif; }
        .perfect-match-title::before, .perfect-match-title::after { 
            content: ''; position: absolute; top: 50%; width: 50px; height: 1px; background-color: #d1d5db; 
        }
        .perfect-match-title::before { right: 100%; margin-right: 15px; }
        .perfect-match-title::after { left: 100%; margin-left: 15px; }
        
        .star-rating input[type="radio"] { display: none; }
        .star-rating input[type="radio"]:checked ~ label, 
        .star-rating label:hover, 
        .star-rating label:hover ~ label { color: #f59e0b; /* text-amber-500 */ }
    </style>
</head>
<body class="bg-white">

    <div id="sticky-bar" class="fixed top-0 left-0 right-0 z-40 flex h-20 items-center justify-between bg-black px-6 text-white shadow-lg transition-transform duration-300 ease-in-out -translate-y-full">
        <div class="flex items-center">
            <img src="/Website/img/Blue de chanel.webp" alt="BLEU DE CHANEL" class="h-12 w-12 object-cover">
            <div class="ml-4">
                <h2 class="text-sm font-bold uppercase">BLEU DE CHANEL</h2>
                <p class="text-xs text-gray-300">Eau de Parfum Spray - 1.7 FL. OZ.</p>
            </div>
        </div>
        <div class="flex items-center">
            <p class="mr-6 text-lg font-medium">$132</p>
            <button class="bg-white py-2 px-8 text-xs font-bold uppercase tracking-wider text-black transition-colors hover:bg-gray-200">Add to Bag</button>
        </div>
    </div>

    <main class="mx-auto mt-10 max-w-7xl px-4">
        <div class="grid grid-cols-1 gap-x-16 lg:grid-cols-2">
            
            <div class="space-y-8">
                <img src="/Website/img/Blue de chanel.webp" alt="BLEU DE CHANEL Bottle" class="w-full">
                <img src="/Website/img/b2.webp" alt="BLEU DE CHANEL Cap Detail" class="w-full">
            </div>
            
            <div class="mt-10 lg:mt-0" style="position: sticky; top: 2.5rem; align-self: flex-start;">
                <div id="product-details-container">
                    <h1 class="border-b border-black pb-2 text-3xl font-light uppercase tracking-wider">BLEU DE CHANEL</h1>
                    <p class="mt-4 text-sm text-gray-500">Eau de Parfum Spray</p>
                    <a href="#" class="text-sm text-black underline">More details</a>
                    <p class="mt-4 text-sm text-gray-400">Ref. 107350</p>
                    <div class="mt-6 flex items-center justify-between">
                        <p class="text-2xl font-medium">$132</p>
                    </div>
                    <div class="mt-8">
                        <label for="size-select" class="text-xs font-bold tracking-wider">3 SIZES AVAILABLE</label>
                        <select id="size-select" class="mt-2 w-full appearance-none border border-gray-400 p-3 text-sm focus:border-black focus:outline-none focus:ring-2 focus:ring-black" style="background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns=\_http://www.w3.org/2000/svg\_ fill=\_none\_ viewBox=\_0 0 24 24\_ stroke-width=\_2\_ stroke=\_currentColor\_><path stroke-linecap=\_round\_ stroke-linejoin=\_round\_ d=\_M19.5 8.25l-7.5 7.5-7.5-7.5\_ /></svg>'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1.25em;">
                            <option>1.7 FL. OZ.</option>
                            <option>3.4 FL. OZ.</option>
                            <option>5.0 FL. OZ.</option>
                        </select>
                    </div>
                    <button class="mt-8 w-full bg-black py-4 text-sm uppercase tracking-widest text-white transition-colors hover:bg-gray-800">Add to Bag</button>
                </div>
                
                <div class="mt-16 border-t border-gray-200 pt-10 text-center">
                    <h2 class="perfect-match-title relative mb-10 inline-block text-lg font-normal uppercase tracking-widest">The Perfect Match</h2>
                    <div class="relative overflow-hidden">
                        <div class="carousel-track flex transition-transform duration-500 ease-in-out">
                            <div class="slide grid min-w-full grid-cols-2 gap-4"><div class="text-center"><img src="/Website/img/Blue de chanel.webp" alt="Shower Gel" class="mx-auto mb-4 h-auto w-4/5 max-w-[200px]"><p class="my-2 text-sm font-bold uppercase">BLEU DE CHANEL</p><p class="text-sm text-gray-500">Shower Gel</p><p class="mt-2 font-medium">$55</p></div><div class="text-center"><img src="/Website/img/b5.jpg" alt="All-Over Spray" class="mx-auto mb-4 h-auto w-4/5 max-w-[200px]"><p class="my-2 text-sm font-bold uppercase">BLEU DE CHANEL</p><p class="text-sm text-gray-500">All-Over Spray</p><p class="mt-2 font-medium">$110</p></div></div>
                            <div class="slide grid min-w-full grid-cols-2 gap-4"><div class="text-center"><img src="/Website/img/b6.jpg" alt="2-in-1 Cleansing Gel" class="mx-auto mb-4 h-auto w-4/5 max-w-[200px]"><p class="my-2 text-sm font-bold uppercase">BLEU DE CHANEL</p><p class="text-sm text-gray-500">2-in-1 Cleansing Gel</p><p class="mt-2 font-medium">$75</p></div><div class="text-center"><img src="/Website/img/b7.jpg" alt="3-in-1 Moisturizer" class="mx-auto mb-4 h-auto w-4/5 max-w-[200px]"><p class="my-2 text-sm font-bold uppercase">BLEU DE CHANEL</p><p class="text-sm text-gray-500">3-in-1 Moisturizer</p><p class="mt-2 font-medium">$80</p></div></div>
                            <div class="slide grid min-w-full grid-cols-2 gap-4"><div class="text-center"><img src="/Website/img/b8.jpg" alt="Deodorant Stick" class="mx-auto mb-4 h-auto w-4/5 max-w-[200px]"><p class="my-2 text-sm font-bold uppercase">BLEU DE CHANEL</p><p class="text-sm text-gray-500">Deodorant Stick</p><p class="mt-2 font-medium">$45</p></div><div class="text-center"><img src="/Website/img/deodrant.webp" alt="After Shave Lotion" class="mx-auto mb-4 h-auto w-4/5 max-w-[200px]"><p class="my-2 text-sm font-bold uppercase">BLEU DE CHANEL</p><p class="text-sm text-gray-500">After Shave Lotion</p><p class="mt-2 font-medium">$80</p></div></div>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-center">
                        <button id="prevBtn" class="cursor-pointer border-none bg-transparent p-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg></button>
                        <span class="page-info mx-4 text-sm text-gray-500" id="pageInfo">1 / 3</span>
                        <button id="nextBtn" class="cursor-pointer border-none bg-transparent p-2"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg></button>
                    </div>
                </div>
            </div>
        </div>

        <section id="reviews-section">
            <h2 class="my-20 text-center text-xl font-medium uppercase tracking-[0.2em]">PRODUCT INFORMATION</h2>
            <div class="mx-auto max-w-4xl border-b border-t border-black">
                <div class="border-b border-gray-200">
                    <button class="accordion-button flex w-full cursor-pointer items-center justify-between border-none bg-transparent py-5 text-left text-sm">
                        <span class="font-semibold uppercase tracking-wider">DESCRIPTION</span>
                        <svg class="accordion-arrow h-5 w-5 transition-transform duration-300 ease-out" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="accordion-content max-h-0 overflow-hidden transition-[max-height] duration-300 ease-in-out">
                        <div class="pb-5 text-sm leading-relaxed text-gray-700">
                            <p class="mb-4"><strong class="mb-1 block font-bold text-black">Product</strong><br>Unexpected and undeniably bold. Fresh, clean and profoundly sensual, the woody, aromatic fragrance reveals the spirit of a man who chooses his own destiny with independence and determination—a man who defies convention.</p>
                            <p class="mb-0"><strong class="mb-1 block font-bold text-black">Composition</strong><br>The fragrance features a fresh citrus accord followed by ambery cedar. Woody notes are amplified by tonka bean and vanilla for heightened sensuality. New Caledonian sandalwood unfolds at the base for greater depth, leaving a captivating trail.</p>
                        </div>
                    </div>
                </div>
                <div class="border-b border-gray-200">
                    <button class="accordion-button flex w-full cursor-pointer items-center justify-between border-none bg-transparent py-5 text-left text-sm">
                        <span class="font-semibold uppercase tracking-wider">MORE DETAILS</span>
                        <svg class="accordion-arrow h-5 w-5 transition-transform duration-300 ease-out" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="accordion-content max-h-0 overflow-hidden transition-[max-height] duration-300 ease-in-out">
                        <div class="pb-5 text-sm leading-relaxed text-gray-700">
                            <p class="mb-0"><strong class="mb-1 block font-bold text-black">List of Ingredients</strong><br>ALCOHOL | PARFUM (FRAGRANCE) | AQUA (WATER) | LIMONENE | LINALOOL | CITRONELLOL | ALPHA-ISOMETHYL IONONE | COUMARIN | CITRAL | GERANIOL | EVERNIA PRUNASTRI (OAK MOSS) EXTRACT | BENZYL BENZOATE | FARNESOL</p>
                        </div>
                    </div>
                </div>
                <div class="last:border-b-0">
                    <button class="accordion-button flex w-full cursor-pointer items-center justify-between border-none bg-transparent py-5 text-left text-sm">
                        <span class="font-semibold uppercase tracking-wider">REVIEWS</span>
                        <svg class="accordion-arrow h-5 w-5 transition-transform duration-300 ease-out" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="accordion-content max-h-0 overflow-hidden transition-[max-height] duration-300 ease-in-out">
                        <div class="p-5">
                            <?php if (empty($reviews)): ?>
                                <p>Be the first to review this product.</p>
                            <?php else: ?>
                                <?php foreach ($reviews as $review): ?>
                                <div class="mb-6 border-b border-gray-200 pb-6 last:mb-0 last:border-b-0 last:pb-0">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-bold"><?php echo htmlspecialchars($review['author_name']); ?></h4>
                                        <span class="text-xs text-gray-500"><?php echo date('m/d/Y', strtotime($review['created_at'])); ?></span>
                                    </div>
                                    <div class="mt-1 flex">
                                        <?php for ($i = 0; $i < 5; $i++): ?>
                                            <svg class="h-4 w-4 <?php echo $i < $review['rating'] ? 'text-amber-500' : 'text-gray-300'; ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <?php endfor; ?>
                                    </div>
                                    <p class="mt-3 leading-relaxed text-gray-700"><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="mx-auto mt-20 max-w-2xl rounded-lg border border-gray-200 bg-gray-50 p-8">
            <h2 class="mt-0 text-center text-xl font-medium uppercase tracking-[0.2em]">WRITE A REVIEW</h2>
            <?php if ($review_message): ?>
                <div class="mb-4 rounded-md p-3 text-center <?php echo strpos($review_message, 'Error') === false ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                    <?php echo $review_message; ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="details.php?id=<?php echo $product_id; ?>#reviews-section">
                <div class="mb-5">
                    <label for="author_name" class="mb-2 block text-sm font-medium">Your Name</label>
                    <input type="text" name="author_name" id="author_name" required class="block w-full rounded-md border border-gray-300 bg-white p-3 transition-shadow focus:border-black focus:outline-none focus:ring-2 focus:ring-black">
                </div>
                <div class="mb-5">
                    <label class="mb-2 block text-sm font-medium">Rating</label>
                    <div class="star-rating flex flex-row-reverse justify-end">
                        <input type="radio" id="5-stars" name="rating" value="5" /><label for="5-stars" class="cursor-pointer text-2xl text-gray-200 transition-colors">&#9733;</label>
                        <input type="radio" id="4-stars" name="rating" value="4" /><label for="4-stars" class="cursor-pointer text-2xl text-gray-200 transition-colors">&#9733;</label>
                        <input type="radio" id="3-stars" name="rating" value="3" /><label for="3-stars" class="cursor-pointer text-2xl text-gray-200 transition-colors">&#9733;</label>
                        <input type="radio" id="2-stars" name="rating" value="2" /><label for="2-stars" class="cursor-pointer text-2xl text-gray-200 transition-colors">&#9733;</label>
                        <input type="radio" id="1-star" name="rating" value="1" required /><label for="1-star" class="cursor-pointer text-2xl text-gray-200 transition-colors">&#9733;</label>
                    </div>
                </div>
                <div class="mb-5">
                    <label for="review_text" class="mb-2 block text-sm font-medium">Review</label>
                    <textarea name="review_text" id="review_text" rows="4" required class="block w-full rounded-md border border-gray-300 bg-white p-3 transition-shadow focus:border-black focus:outline-none focus:ring-2 focus:ring-black"></textarea>
                </div>
                <div>
                    <button type="submit" name="submit_review" class="w-full cursor-pointer rounded border-none bg-black py-3.5 text-sm uppercase tracking-widest text-white transition-colors hover:bg-gray-800">Submit Review</button>
                </div>
            </form>
        </div>
        
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Sticky Bar Pop-Up Logic ---
            const stickyBar = document.getElementById('sticky-bar');
            const productDetails = document.getElementById('product-details-container');
            const stickyObserver = new IntersectionObserver(([entry]) => {
                stickyBar.classList.toggle('visible', !entry.isIntersecting);
                // The 'visible' class will toggle between -translate-y-full and translate-y-0
                if (!entry.isIntersecting) {
                    stickyBar.classList.remove('-translate-y-full');
                    stickyBar.classList.add('translate-y-0');
                } else {
                    stickyBar.classList.remove('translate-y-0');
                    stickyBar.classList.add('-translate-y-full');
                }
            }, { rootMargin: "-80px 0px 0px 0px", threshold: 0 });
            if (productDetails) stickyObserver.observe(productDetails);

            // --- Perfect Match Carousel Logic ---
            const track = document.querySelector('.carousel-track');
            if(track) {
                const slides = Array.from(track.children);
                const nextButton = document.getElementById('nextBtn');
                const prevButton = document.getElementById('prevBtn');
                const pageInfo = document.getElementById('pageInfo');
                const slideWidth = slides.length > 0 ? slides[0].getBoundingClientRect().width : 0;
                let currentIndex = 0;
                const totalSlides = slides.length;

                const updateCarousel = () => {
                    if(slides.length === 0) return;
                    track.style.transform = 'translateX(-' + slideWidth * currentIndex + 'px)';
                    pageInfo.textContent = `${currentIndex + 1} / ${totalSlides}`;
                    prevButton.disabled = currentIndex === 0;
                    prevButton.style.opacity = currentIndex === 0 ? '0.5' : '1';
                    nextButton.disabled = currentIndex === totalSlides - 1;
                    nextButton.style.opacity = currentIndex === totalSlides - 1 ? '0.5' : '1';
                };
                
                nextButton.addEventListener('click', () => { if (currentIndex < totalSlides - 1) { currentIndex++; updateCarousel(); } });
                prevButton.addEventListener('click', () => { if (currentIndex > 0) { currentIndex--; updateCarousel(); } });
                
                if(slides.length > 0) updateCarousel();
            }
            
            // --- Accordion Logic ---
            const accordionButtons = document.querySelectorAll('.accordion-button');
            accordionButtons.forEach(button => {
                const content = button.nextElementSibling;
                const arrow = button.querySelector('.accordion-arrow');

                // Auto-open reviews section if coming from a review submission
                if (window.location.hash === '#reviews-section' && button.textContent.trim().includes('REVIEWS')){
                    button.classList.add('open');
                    arrow.classList.add('rotate-180');
                    content.style.maxHeight = content.scrollHeight + "px";
                }

                button.addEventListener('click', () => {
                    const isOpen = button.classList.toggle('open');
                    arrow.classList.toggle('rotate-180');
                    content.style.maxHeight = isOpen ? content.scrollHeight + "px" : null;
                });
            });
        });
    </script>
</body>
</html>

