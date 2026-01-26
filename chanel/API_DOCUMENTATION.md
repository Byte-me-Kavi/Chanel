# Chanel API Documentation for Postman

## 1. Authentication Setup (Sanctum)

Since we are using Laravel Sanctum with SPA mode for the web, testing via Postman requires simulating a "Mobile App" login or using the session cookie.
**For this assignment context**, we will assume you logged in via the Web UI or we can create a temporary token route.

**Simplest Method for Postman (Cookie Auth):**

1.  Open Postman Settings -> General -> turn OFF "SSL certificate verification".
2.  Make a `GET` request to `http://127.0.0.1:8000/sanctum/csrf-cookie` to set cookies.
3.  Login via `POST http://127.0.0.1:8000/login` with `email` and `password`.
4.  Postman will save the session cookies. Subsequent API calls will work.

**Token Method (If you implemented /api/login):**
_Currently, your app uses Web Login. If you need a raw token for testing, you can use `php artisan tinker`:_

```php
$user = App\Models\User::first();
echo $user->createToken('Postman')->plainTextToken;
```

**Then in Postman:**

- **Auth Type**: Bearer Token
- **Token**: `[PASTE_TOKEN_HERE]`
- **Headers**: `Accept: application/json`

---

## 2. Public Endpoints (No Auth Required)

### Get All Products

- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/products`
- **Params:**
    - `search` (Optional): String (e.g., `?search=Bleu`)

### Get Single Product

- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/products/{id}`
- **Example:** `http://127.0.0.1:8000/api/products/1`

### Submit Review

- **Method:** `POST`
- **URL:** `http://127.0.0.1:8000/api/products/{id}/reviews`
- **Headers:** `Content-Type: application/json`
- **Body (JSON):**
    ```json
    {
        "author_name": "John Doe",
        "rating": 5,
        "review_text": "Excellent perfume!"
    }
    ```

---

## 3. Authenticated Endpoints (Requires Auth)

### View Wishlist

- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/wishlist`

### Add to Wishlist

- **Method:** `POST`
- **URL:** `http://127.0.0.1:8000/api/wishlist`
- **Body (JSON):**
    ```json
    {
        "product_id": 1
    }
    ```

### Remove from Wishlist

- **Method:** `DELETE`
- **URL:** `http://127.0.0.1:8000/api/wishlist/{id}`

### Place Order (Checkout)

- **Method:** `POST`
- **URL:** `http://127.0.0.1:8000/api/checkout`
- **Body (JSON):**
    ```json
    {
        "items": [
            {
                "name": "Bleu de Chanel",
                "price": 165.0,
                "quantity": 1,
                "image": "/img/bleu.jpg"
            }
        ],
        "delivery_method": "standard",
        "wrapping": true,
        "gift_message": "Happy Birthday!"
    }
    ```

### My Orders

- **Method:** `GET`
- **URL:** `http://127.0.0.1:8000/api/orders`

---

## 4. Admin Endpoints (Requires Admin User)

### Create Delivery

- **Method:** `POST`
- **URL:** `http://127.0.0.1:8000/api/admin/deliveries`
- **Body (JSON):**
    ```json
    {
        "customer_name": "Alice Smith",
        "address": "123 Main St",
        "product": "Chanel No. 5",
        "quantity": 1,
        "status": "Pending"
    }
    ```
