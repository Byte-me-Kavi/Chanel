<?php
// ... existing User class code ...

class Product {
    // ... existing constructor ...

    // Fetches ALL products
    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM products ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // NEW: Fetches products by a specific category
    public function getByCategory($category) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE category = :category ORDER BY created_at DESC");
        $stmt->execute(['category' => $category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ... (We will add create, update, delete methods later for the admin part)
}



