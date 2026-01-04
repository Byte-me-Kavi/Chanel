document.addEventListener('DOMContentLoaded', () => {
    const signInTab = document.getElementById('sign-in-tab');
    const registerTab = document.getElementById('register-tab');
    const signInForm = document.getElementById('sign-in-form');
    const registerForm = document.getElementById('register-form');

    if (signInTab && registerTab && signInForm && registerForm) {
        signInTab.addEventListener('click', (e) => {
            e.preventDefault();
            signInTab.classList.add('active');
            registerTab.classList.remove('active');
            signInForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
        });

        registerTab.addEventListener('click', (e) => {
            e.preventDefault();
            registerTab.classList.add('active');
            signInTab.classList.remove('active');
            registerForm.classList.remove('hidden');
            signInForm.classList.add('hidden');
        });
    }
});

document.addEventListener('DOMContentLoaded', () => {
    // --- LOGIC FOR THE PRODUCT PAGE ---
    const addToWishlistBtn = document.querySelector('.add-to-wishlist-btn');
    if (addToWishlistBtn) {
        addToWishlistBtn.addEventListener('click', () => {
            const productCard = addToWishlistBtn.closest('.product-card');
            const product = {
                id: productCard.dataset.id,
                name: productCard.dataset.name,
                price: productCard.dataset.price,
                image: productCard.dataset.image,
            };

            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const isAlreadyInWishlist = wishlist.some(item => item.id === product.id);

            if (!isAlreadyInWishlist) {
                wishlist.push(product);
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                alert(product.name + ' has been added to your wishlist!');
            } else {
                alert(product.name + ' is already in your wishlist.');
            }
        });
    }

    // --- LOGIC FOR THE WISHLIST PAGE ---
    const wishlistContainer = document.getElementById('wishlist-container');
    if (wishlistContainer) {
        const renderWishlist = () => {
            wishlistContainer.innerHTML = '';
            const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];

            if (wishlist.length === 0) {
                wishlistContainer.innerHTML = '<p>Your wishlist is currently empty.</p>';
                return;
            }

            wishlist.forEach(item => {
                const wishlistItem = document.createElement('div');
                wishlistItem.classList.add('wishlist-item');
                wishlistItem.innerHTML = `
                    <img src="${item.image}" alt="${item.name}" class="product-image">
                    <h2 class="product-name">${item.name}</h2>
                    <p class="product-price">$${item.price}</p>
                    <button class="btn btn-remove" data-id="${item.id}">Remove</button>
                `;
                wishlistContainer.appendChild(wishlistItem);
            });
        };
        
        wishlistContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-remove')) {
                const productId = e.target.dataset.id;
                let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
                wishlist = wishlist.filter(item => item.id !== productId);
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                renderWishlist();
            }
        });
        renderWishlist();
    }
});

/*Abou us page */
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.{html,js,php}", // This line is crucial! It tells Tailwind to scan PHP files.
    "./src/**/*.{html,js,php}"
    // Add paths to all of your template files here
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}