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
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLEU DE CHANEL - Eau de Parfum Spray | CHANEL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script>
        // Optional: You can configure Tailwind to use the Roboto font
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Roboto', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-white text-gray-900 font-sans">

    <div id="sticky-bar" class="fixed top-0 left-0 right-0 bg-black text-white h-20 z-40 flex items-center justify-between px-6 shadow-md transition-transform duration-300 ease-in-out -translate-y-full">
        <div class="flex items-center">
            <img src="/Website/img/chance eau tendre.webp" alt="CHANCE EAU TENDRE" class="w-12 h-12 object-cover">
            <div class="ml-4">
                <h2 class="font-bold text-sm uppercase">CHANCE EAU TENDRE</h2>
                <p class="text-xs text-gray-400">Eau de Parfum Spray - 1.7 FL. OZ.</p>
            </div>
        </div>
        <div class="flex items-center">
            <p class="text-lg font-medium mr-6">$176</p>
            <button class="bg-white text-black py-2 px-8 uppercase text-xs font-bold tracking-wider transition hover:bg-gray-200">Add to Bag</button>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 mt-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-16">
            <div class="space-y-8">
                <img src="/Website/img/chance eau tendre.webp" alt="CHANCE EAU TENDRE Bottle" class="w-full">
                <img src="/Website/img/c2.webp" alt="CHANCE EAU TENDRE Cap Detail" class="w-full">
            </div>
            
            <div class="lg:mt-0 mt-10 lg:sticky top-10 self-start">
                <div id="product-details-container">
                    <h1 class="text-3xl font-light tracking-wider uppercase border-b border-black pb-2">CHANCE EAU TENDRE</h1>
                    <p class="mt-4 text-sm text-gray-500">Eau de Parfum Spray</p>
                    <a href="#" class="text-xs underline text-black">More details</a>
                    <p class="mt-4 text-sm text-gray-400">Ref. 107350</p>
                    <div class="flex justify-between items-center mt-6">
                        <p class="text-2xl font-medium">$176</p>
                    </div>
                    <div class="mt-8">
                        <label for="size-select" class="text-xs font-bold tracking-wider">3 SIZES AVAILABLE</label>
                        <select id="size-select" class="block w-full mt-2 p-3 border border-gray-400 text-sm appearance-none focus:outline-none focus:ring-2 focus:ring-black focus:border-black bg-no-repeat bg-right-4 bg-center bg-[length:1.25em] bg-[url('data:image/svg+xml;charset=UTF-8,<svg%20xmlns=%22http://www.w3.org/2000/svg%22%20fill=%22none%22%20viewBox=%220%200%2024%2024%22%20stroke-width=%222%22%20stroke=%22currentColor%22><path%20stroke-linecap=%22round%22%20stroke-linejoin=%22round%22%20d=%22M19.5%208.25l-7.5%207.5-7.5-7.5%22%20/></svg>')]">
                            <option>1.7 FL. OZ.</option>
                            <option>3.4 FL. OZ.</option>
                            <option>5.0 FL. OZ.</option>
                        </select>
                    </div>
                    <button class="w-full bg-black text-white py-4 mt-8 uppercase text-sm tracking-widest transition hover:bg-gray-800">Add to Bag</button>
                </div>

                <div class="mt-16 text-center border-t border-gray-200 pt-10">
                    <div class="inline-flex w-full items-center justify-center">
                        <hr class="w-16 h-px bg-gray-300 border-0">
                        <h2 class="px-4 font-normal text-lg uppercase tracking-widest text-center whitespace-nowrap">The Perfect Match</h2>
                        <hr class="w-16 h-px bg-gray-300 border-0">
                    </div>
                    <div class="relative overflow-hidden mt-10">
                        <div class="carousel-track flex transition-transform duration-500 ease-in-out">
                            <div class="slide min-w-full grid grid-cols-2 gap-4">
                                <div class="text-center"><img src="/Website/img/p1.jpg" alt="Shower Gel" class="w-4/5 max-w-[200px] h-auto mb-4 mx-auto"><p class="font-bold uppercase text-sm my-2">CHANCE EAU TENDRE</p><p class="text-sm text-gray-500">Hair Mist</p><p class="font-medium mt-2">$55</p></div>
                                <div class="text-center"><img src="/Website/img/p2.jpg" alt="All-Over Spray" class="w-4/5 max-w-[200px] h-auto mb-4 mx-auto"><p class="font-bold uppercase text-sm my-2">CHANCE EAU TENDRE</p><p class="text-sm text-gray-500">Body Cream</p><p class="font-medium mt-2">$110</p></div>
                            </div>
                            <div class="slide min-w-full grid grid-cols-2 gap-4">
                                <div class="text-center"><img src="/Website/img/p3.jpg" alt="2-in-1 Cleansing Gel" class="w-4/5 max-w-[200px] h-auto mb-4 mx-auto"><p class="font-bold uppercase text-sm my-2">CHANCE EAU TENDRE</p><p class="text-sm text-gray-500">Sheer Moisture Mist</p><p class="font-medium mt-2">$75</p></div>
                                <div class="text-center"><img src="/Website/img/p4.jpg" alt="3-in-1 Moisturizer" class="w-4/5 max-w-[200px] h-auto mb-4 mx-auto"><p class="font-bold uppercase text-sm my-2">CHANCE</p><p class="text-sm text-gray-500">Perfumed Hand Creams</p><p class="font-medium mt-2">$80</p></div>
                            </div>
                            <div class="slide min-w-full grid grid-cols-2 gap-4">
                                <div class="text-center"><img src="/Website/img/p5.jpg" alt="Deodorant Stick" class="w-4/5 max-w-[200px] h-auto mb-4 mx-auto"><p class="font-bold uppercase text-sm my-2">CHANCE EAU TENDRE</p><p class="text-sm text-gray-500">Eau de Perfumed Spray</p><p class="font-medium mt-2">$45</p></div>
                                <div class="text-center"><img src="/Website/img/p6.jpg" alt="After Shave Lotion" class="w-4/5 max-w-[200px] h-auto mb-4 mx-auto"><p class="font-bold uppercase text-sm my-2">CHANCE EAU TENDRE</p><p class="text-sm text-gray-500">Body Oil</p><p class="font-medium mt-2">$80</p></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center items-center mt-6">
                        <button id="prevBtn" class="p-2 disabled:opacity-50"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-black"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg></button>
                        <span class="page-info text-sm mx-4 text-gray-500" id="pageInfo">1 / 3</span>
                        <button id="nextBtn" class="p-2 disabled:opacity-50"><svg xmlns="http://www.w.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-black"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg></button>
                    </div>
                </div>
            </div>
        </div>

        <section id="reviews-section" class="mt-20">
            <h2 class="text-center text-xl font-medium tracking-[0.2em] uppercase mb-10">PRODUCT INFORMATION</h2>
            <div class="border-t border-b border-black max-w-3xl mx-auto">
                <div class="group border-b border-gray-200">
                    <button class="accordion-button w-full flex justify-between items-center py-5 text-left text-sm cursor-pointer">
                        <span class="font-semibold uppercase tracking-wider">DESCRIPTION</span>
                        <svg class="w-5 h-5 transition-transform duration-300 ease-out group-[.open]:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="accordion-content max-h-0 overflow-hidden transition-[max-height] duration-300 ease-in-out">
                        <div class="pb-5 pt-2 text-sm text-gray-700 leading-relaxed">
                            <p class="mb-4"><strong class="block mb-1 text-black font-bold">Product</strong>Unexpected and undeniably bold. Fresh, clean and profoundly sensual, the woody, aromatic fragrance reveals the spirit of a man who chooses his own destiny with independence and determination—a man who defies convention.</p>
                            <p class="last:mb-0"><strong class="block mb-1 text-black font-bold">Composition</strong>The fragrance features a fresh citrus accord followed by ambery cedar. Woody notes are amplified by tonka bean and vanilla for heightened sensuality. New Caledonian sandalwood unfolds at the base for greater depth, leaving a captivating trail.</p>
                        </div>
                    </div>
                </div>
                <div class="group border-b border-gray-200">
                    <button class="accordion-button w-full flex justify-between items-center py-5 text-left text-sm cursor-pointer">
                        <span class="font-semibold uppercase tracking-wider">MORE DETAILS</span>
                        <svg class="w-5 h-5 transition-transform duration-300 ease-out group-[.open]:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="accordion-content max-h-0 overflow-hidden transition-[max-height] duration-300 ease-in-out">
                        <div class="pb-5 pt-2 text-sm text-gray-700 leading-relaxed">
                             <p class="last:mb-0"><strong class="block mb-1 text-black font-bold">List of Ingredients</strong>ALCOHOL | PARFUM (FRAGRANCE) | AQUA (WATER) | LIMONENE | LINALOOL | CITRONELLOL | ALPHA-ISOMETHYL IONONE | COUMARIN | CITRAL | GERANIOL | EVERNIA PRUNASTRI (OAK MOSS) EXTRACT | BENZYL BENZOATE | FARNESOL</p>
                        </div>
                    </div>
                </div>
                <div class="group border-b-0">
                    <button class="accordion-button w-full flex justify-between items-center py-5 text-left text-sm cursor-pointer">
                        <span class="font-semibold uppercase tracking-wider">REVIEWS</span>
                        <svg class="w-5 h-5 transition-transform duration-300 ease-out group-[.open]:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="accordion-content max-h-0 overflow-hidden transition-[max-height] duration-300 ease-in-out">
                        <div class="p-5">
                            <?php if (empty($reviews)): ?>
                                <p class="text-sm text-gray-600">Be the first to review this product.</p>
                            <?php else: ?>
                                <?php foreach ($reviews as $review): ?>
                                <div class="border-b border-gray-200 pb-6 mb-6 last:border-b-0 last:mb-0 last:pb-0">
                                    <div class="flex justify-between items-center">
                                        <h4 class="font-bold text-gray-800"><?php echo htmlspecialchars($review['author_name']); ?></h4>
                                        <span class="text-xs text-gray-500"><?php echo date('m/d/Y', strtotime($review['created_at'])); ?></span>
                                    </div>
                                    <div class="flex mt-1">
                                        <?php for ($i = 0; $i < 5; $i++): ?>
                                            <svg class="w-4 h-4 <?php echo $i < $review['rating'] ? 'text-amber-400' : 'text-gray-300'; ?>" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <?php endfor; ?>
                                    </div>
                                    <p class="mt-3 text-sm text-gray-700 leading-relaxed"><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="mt-20 mb-20 max-w-2xl mx-auto bg-gray-50 p-8 border border-gray-200 rounded-lg">
            <h2 class="text-center text-xl font-medium tracking-[0.2em] uppercase mt-0 mb-10">WRITE A REVIEW</h2>
            <?php if ($review_message): ?>
                <div class="mb-4 text-center p-3 rounded-md text-sm <?php echo strpos($review_message, 'Error') === false ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                    <?php echo $review_message; ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="details.php?id=<?php echo $product_id; ?>#reviews-section">
                <div class="mb-5">
                    <label for="author_name" class="block text-sm font-medium text-gray-700 mb-2">Your Name</label>
                    <input type="text" name="author_name" id="author_name" required class="block w-full p-3 border border-gray-300 rounded-md bg-white transition focus:outline-none focus:ring-2 focus:ring-black focus:border-black">
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                    <div class="flex flex-row-reverse justify-end items-center">
                        <input type="radio" id="5-stars" name="rating" value="5" class="peer hidden" /><label for="5-stars" class="text-4xl text-gray-300 cursor-pointer hover:text-amber-400 peer-checked:text-amber-400">&#9733;</label>
                        <input type="radio" id="4-stars" name="rating" value="4" class="peer hidden" /><label for="4-stars" class="text-4xl text-gray-300 cursor-pointer hover:text-amber-400 peer-checked:text-amber-400">&#9733;</label>
                        <input type="radio" id="3-stars" name="rating" value="3" class="peer hidden" /><label for="3-stars" class="text-4xl text-gray-300 cursor-pointer hover:text-amber-400 peer-checked:text-amber-400">&#9733;</label>
                        <input type="radio" id="2-stars" name="rating" value="2" class="peer hidden" /><label for="2-stars" class="text-4xl text-gray-300 cursor-pointer hover:text-amber-400 peer-checked:text-amber-400">&#9733;</label>
                        <input type="radio" id="1-star" name="rating" value="1" required class="peer hidden" /><label for="1-star" class="text-4xl text-gray-300 cursor-pointer hover:text-amber-400 peer-checked:text-amber-400">&#9733;</label>
                    </div>
                </div>
                <div class="mb-5">
                    <label for="review_text" class="block text-sm font-medium text-gray-700 mb-2">Review</label>
                    <textarea name="review_text" id="review_text" rows="4" required class="block w-full p-3 border border-gray-300 rounded-md bg-white transition focus:outline-none focus:ring-2 focus:ring-black focus:border-black"></textarea>
                </div>
                <div>
                    <button type="submit" name="submit_review" class="w-full bg-black text-white py-3.5 uppercase text-sm tracking-widest cursor-pointer transition hover:bg-gray-800 rounded">Submit Review</button>
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
                const isVisible = !entry.isIntersecting;
                stickyBar.classList.toggle('translate-y-0', isVisible);
                stickyBar.classList.toggle('-translate-y-full', !isVisible);
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
                    nextButton.disabled = currentIndex === totalSlides - 1;
                };
                
                nextButton.addEventListener('click', () => { if (currentIndex < totalSlides - 1) { currentIndex++; updateCarousel(); } });
                prevButton.addEventListener('click', () => { if (currentIndex > 0) { currentIndex--; updateCarousel(); } });
                
                if(slides.length > 0) updateCarousel();
            }
            
            // --- Accordion Logic ---
            const accordionButtons = document.querySelectorAll('.accordion-button');
            accordionButtons.forEach(button => {
                const item = button.parentElement; // The parent .group element
                const content = button.nextElementSibling;
                
                // Open reviews section if URL hash matches
                if (window.location.hash === '#reviews-section' && button.textContent.trim().includes('REVIEWS')){
                    item.classList.add('open');
                    content.style.maxHeight = content.scrollHeight + "px";
                }

                button.addEventListener('click', () => {
                    const isOpen = item.classList.toggle('open');
                    content.style.maxHeight = isOpen ? content.scrollHeight + "px" : null;
                });
            });
        });
    </script>
    
</body>
</html>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>