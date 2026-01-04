<?php
session_start();

require_once __DIR__ . '/../layouts/header.php';

// --- DB Connection ---
$host = "localhost";
$dbname = "chanel_db";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

// --- Helpers ---
function columnExists($pdo, $table, $column) {
    try {
        $stmt = $pdo->prepare("SHOW COLUMNS FROM `$table` LIKE :column");
        $stmt->execute([':column' => $column]);
        return $stmt->rowCount() > 0;
    } catch (Exception $e) {
        return false;
    }
}

// Tabs & filters
$tab = $_GET['tab'] ?? 'deliveries';
$status_filter = $_GET['status'] ?? 'All';

// --- Delivery metadata ---
$has_created_at = columnExists($pdo, 'deliveries', 'created_at');
$has_status = columnExists($pdo, 'deliveries', 'status');

if ($has_created_at) {
    $today_delivery = (int)$pdo->query("SELECT COUNT(*) FROM deliveries WHERE DATE(created_at) = CURDATE()")->fetchColumn();
    $monthly_delivery = (int)$pdo->query("SELECT COUNT(*) FROM deliveries WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())")->fetchColumn();
} else {
    $today_delivery = '-';
    $monthly_delivery = '-';
}

$delivery_issues = $has_status ? (int)$pdo->query("SELECT COUNT(*) FROM deliveries WHERE status IN ('On Hold','Canceled','Refunded')")->fetchColumn() : '-';
$total_delivery = (int)$pdo->query("SELECT COUNT(*) FROM deliveries")->fetchColumn();

// --- Messages ---
$deliveryMessage = '';
$productMessage = '';
$userMessage = '';

// --- Handle Delivery Delete ---
if (isset($_GET['delete_delivery'])) {
    $delDeliveryId = intval($_GET['delete_delivery']);
    try {
        $pdo->prepare("DELETE FROM deliveries WHERE id = ?")->execute([$delDeliveryId]);
        header("Location: admin.php?tab=deliveries&message=deleted");
        exit;
    } catch (PDOException $e) {
        header("Location: admin.php?tab=deliveries&error=" . urlencode("Error deleting delivery."));
        exit;
    }
}

// Display messages from redirects
if ($tab === 'deliveries') {
    if (isset($_GET['message']) && $_GET['message'] === 'deleted') {
        $deliveryMessage = "✅ Delivery deleted successfully.";
    }
    if (isset($_GET['error'])) {
        $deliveryMessage = "❌ " . htmlspecialchars($_GET['error']);
    }
}


// --- Handle Delivery Add/Edit/Fetch ---
//Delivery CRUD Starts
$editDelivery = null;
if (isset($_GET['edit_delivery'])) {
    $editDeliveryId = intval($_GET['edit_delivery']);
    try {
        $stmt = $pdo->prepare("SELECT * FROM deliveries WHERE id = ?");
        $stmt->execute([$editDeliveryId]);
        $editDelivery = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $deliveryMessage = "❌ Error fetching delivery: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delivery_action'])) {
    $deliveryId = $_POST['delivery_id'] ?? null;
    $customer = trim($_POST['customer_name'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $product  = trim($_POST['product'] ?? '');
    $quantity = intval($_POST['quantity'] ?? 1);
    $status   = $_POST['status'] ?? 'Successful';
    
    if ($customer && $address && $product) {
        try {
            if ($deliveryId) {
                $sql = "UPDATE deliveries SET customer_name = :customer, address = :address, product = :product, quantity = :quantity, status = :status WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':customer' => $customer, ':address' => $address, ':product' => $product, ':quantity' => $quantity, ':status' => $status, ':id' => $deliveryId]);
                $deliveryMessage = "✅ Delivery updated successfully.";
                $editDelivery = null; // Clear edit state after update
            } else {
                $order_number = 'ORD-' . time(); 
                $sql = "INSERT INTO deliveries (order_number, customer_name, address, product, quantity, status, created_at) VALUES (:order_number, :customer, :address, :product, :quantity, :status, NOW())";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':order_number' => $order_number, ':customer' => $customer, ':address' => $address, ':product' => $product, ':quantity' => $quantity, ':status' => $status]);
                $deliveryMessage = "✅ Delivery added successfully.";
            }
        } catch (PDOException $e) {
            $deliveryMessage = "❌ Error: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $deliveryMessage = "❌ Please fill all required fields.";
    }
}


// --- Fetch deliveries ---
$deliveries = [];
if ($tab === 'deliveries') {
    try {
        $orderBy = $has_created_at ? 'created_at DESC' : 'id DESC';
        if (!$has_status || $status_filter === 'All') {
            $stmt = $pdo->prepare("SELECT * FROM deliveries ORDER BY $orderBy");
            $stmt->execute();
        } else {
            $stmt = $pdo->prepare("SELECT * FROM deliveries WHERE status = :status ORDER BY $orderBy");
            $stmt->execute([':status' => $status_filter]);
        }
        $deliveries = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $deliveries = [];
    }
}

// --- Analytics data ---
$analyticsData = [];
if ($has_status) {
    try {
        $analyticsData = $pdo->query("SELECT status, COUNT(*) as count FROM deliveries GROUP BY status")->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $analyticsData = [];
    }
}

// --- Products: add / edit / delete ---
//Products CRUD Starts
$editProduct = null;
if (isset($_GET['edit_product'])) {
    $editId = intval($_GET['edit_product']);
    try {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$editId]);
        $editProduct = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $productMessage = "❌ Error fetching product: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $id = $_POST['product_id'] ?? null;
    $name = trim($_POST['product_name'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    
    $imagePath = $_POST['original_image'] ?? '';
    if (!empty($_FILES['image']['name'])) {
        $uploadDirServer = __DIR__ . '/uploads/';
        if (!is_dir($uploadDirServer)) mkdir($uploadDirServer, 0777, true);
        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', basename($_FILES['image']['name']));
        $targetFile = $uploadDirServer . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = 'uploads/' . $filename;
        }
    }

    try {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE products SET name=:name, price=:price, description=:description, image=:image WHERE id=:id");
            $stmt->execute([':name'=>$name, ':price'=>$price, ':description'=>$description, ':image'=>$imagePath, ':id'=>$id]);
            $productMessage = "✅ Product updated successfully.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO products (name, price, description, image) VALUES (:name, :price, :description, :image)");
            $stmt->execute([':name'=>$name, ':price'=>$price, ':description'=>$description, ':image'=>$imagePath]);
            $productMessage = "✅ Product added successfully.";
        }
    } catch (PDOException $e) {
        $productMessage = "❌ Error saving product: " . $e->getMessage();
    }
}

if (isset($_GET['delete_product'])) {
    $delId = intval($_GET['delete_product']);
    try {
        $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$delId]);
        header("Location: admin.php?tab=products");
        exit;
    } catch (PDOException $e) {
        $productMessage = "❌ Error deleting product: " . $e->getMessage();
    }
}

// --- User Management: add / edit / delete ---
//Users CRUD Starts
$editUser = null;

if (isset($_GET['edit_user'])) {
    $editUserId = intval($_GET['edit_user']);
    try {
        $stmt = $pdo->prepare("SELECT id, username, email, role FROM users WHERE id = ?");
        $stmt->execute([$editUserId]);
        $editUser = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $userMessage = "❌ Error fetching user: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $userId = $_POST['user_id'] ?? null;
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'Editor';

    try {
        if ($userId) {
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email, password = :password, role = :role WHERE id = :id");
                $stmt->execute([':username' => $username, ':email' => $email, ':password' => $hashedPassword, ':role' => $role, ':id' => $userId]);
            } else {
                $stmt = $pdo->prepare("UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id");
                $stmt->execute([':username' => $username, ':email' => $email, ':role' => $role, ':id' => $userId]);
            }
            $userMessage = "✅ User updated successfully.";
        } else {
            if (empty($password)) {
                 $userMessage = "❌ Password is required for a new user.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
                $stmt->execute([':username' => $username, ':email' => $email, ':password' => $hashedPassword, ':role' => $role]);
                $userMessage = "✅ User added successfully.";
            }
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $userMessage = "❌ Error: An account with this email already exists.";
        } else {
            $userMessage = "❌ Error saving user: " . $e->getMessage();
        }
    }
}

if (isset($_GET['delete_user'])) {
    $delUserId = intval($_GET['delete_user']);
    try {
        $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$delUserId]);
        header("Location: admin.php?tab=users");
        exit;
    } catch (PDOException $e) {
        $userMessage = "❌ Error deleting user: " . $e->getMessage();
    }
}


// Fetch all products
$products = [];
try {
    $products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) { $products = []; }

// Fetch all users
$users = [];
try {
    $users = $pdo->query("SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) { $users = []; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-800">
<div class="max-w-6xl mx-auto p-6">

<header class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-extrabold">Chanel Admin Dashboard</h1>
    <nav class="space-x-3">
        <a href="?tab=deliveries" class="px-4 py-2 rounded-md <?= $tab==='deliveries' ? 'bg-black text-white' : 'bg-white border' ?>">Deliveries</a>
        <a href="?tab=analytics"  class="px-4 py-2 rounded-md <?= $tab==='analytics' ? 'bg-black text-white' : 'bg-white border' ?>">Analytics</a>
        <a href="?tab=products"   class="px-4 py-2 rounded-md <?= $tab==='products' ? 'bg-black text-white' : 'bg-white border' ?>">Products</a>
        <a href="?tab=users"      class="px-4 py-2 rounded-md <?= $tab==='users' ? 'bg-black text-white' : 'bg-white border' ?>">Users</a>
    </nav>
</header>

<!-- Dashboard cards -->
<section class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-4 rounded-lg shadow-sm border">
        <p class="text-sm text-gray-500">Today's</p>
        <p class="text-2xl font-bold"><?= htmlspecialchars((string)$today_delivery) ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow-sm border">
        <p class="text-sm text-gray-500">This Month</p>
        <p class="text-2xl font-bold"><?= htmlspecialchars((string)$monthly_delivery) ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow-sm border">
        <p class="text-sm text-gray-500">Delivery Issues</p>
        <p class="text-2xl font-bold"><?= htmlspecialchars((string)$delivery_issues) ?></p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow-sm border">
        <p class="text-sm text-gray-500">Total</p>
        <p class="text-2xl font-bold"><?= htmlspecialchars((string)$total_delivery) ?></p>
    </div>
</section>

<?php if ($tab === 'deliveries'): ?>
<!-- Add/Edit Delivery Form -->
<section class="bg-white p-6 rounded-xl shadow mb-6">
<h2 class="text-xl font-semibold mb-4"><?= $editDelivery ? '📝 Edit Delivery' : '➕ Add New Delivery' ?></h2>
<?php if (!empty($deliveryMessage)): ?>
<div class="mb-4 p-3 rounded <?= str_contains($deliveryMessage,'✅') ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800' ?>">
<?= htmlspecialchars($deliveryMessage) ?>
</div>
<?php endif; ?>
<form method="post" action="admin.php?tab=deliveries" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <input type="hidden" name="delivery_action" value="1">
    <?php if ($editDelivery): ?>
        <input type="hidden" name="delivery_id" value="<?= $editDelivery['id'] ?>">
    <?php endif; ?>
    <div>
        <label class="block text-sm font-medium mb-1">Customer Name</label>
        <input name="customer_name" required class="w-full px-4 py-2 border rounded-lg" value="<?= htmlspecialchars($editDelivery['customer_name'] ?? '') ?>">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Address</label>
        <input name="address" required class="w-full px-4 py-2 border rounded-lg" value="<?= htmlspecialchars($editDelivery['address'] ?? '') ?>">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Product</label>
        <input name="product" required class="w-full px-4 py-2 border rounded-lg" value="<?= htmlspecialchars($editDelivery['product'] ?? '') ?>">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Quantity</label>
        <input name="quantity" type="number" min="1" value="<?= htmlspecialchars($editDelivery['quantity'] ?? '1') ?>" required class="w-full px-4 py-2 border rounded-lg">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Status</label>
        <select name="status" class="w-full px-4 py-2 border rounded-lg">
            <?php $statuses = ['Successful', 'On Hold', 'Canceled', 'Refunded']; ?>
            <?php foreach ($statuses as $s): ?>
                <option <?= (($editDelivery['status'] ?? '') === $s) ? 'selected' : '' ?>><?= $s ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="md:col-span-2">
        <button type="submit" class="w-full bg-black text-white py-3 rounded-lg hover:bg-gray-800 transition"><?= $editDelivery ? 'Update Delivery' : 'Add Delivery' ?></button>
        <?php if ($editDelivery): ?>
            <a href="?tab=deliveries" class="block text-center mt-2 text-sm text-gray-600 hover:text-black">Cancel Edit</a>
        <?php endif; ?>
    </div>
</form>
</section>

<!-- Delivery Table -->
<section class="bg-white p-6 rounded-xl shadow">
<div class="flex items-center justify-between mb-4">
<h2 class="text-xl font-semibold">📦 Delivery Report</h2>
<form method="get" class="flex items-center gap-3">
<input type="hidden" name="tab" value="deliveries">
<select name="status" onchange="this.form.submit()" class="px-3 py-2 border rounded">
<option <?= $status_filter==='All' ? 'selected' : '' ?>>All</option>
<option <?= $status_filter==='Successful' ? 'selected' : '' ?>>Successful</option>
<option <?= $status_filter==='On Hold' ? 'selected' : '' ?>>On Hold</option>
<option <?= $status_filter==='Canceled' ? 'selected' : '' ?>>Canceled</option>
<option <?= $status_filter==='Refunded' ? 'selected' : '' ?>>Refunded</option>
</select>
</form>
</div>

<?php if (empty($deliveries)): ?>
<p class="text-center text-gray-500 py-4">No deliveries found for this filter.</p>
<?php else: ?>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-gray-100">
    <th class="px-3 py-2 border text-sm">Order #</th>
    <th class="px-3 py-2 border text-sm">Customer</th>
    <th class="px-3 py-2 border text-sm">Product</th>
    <th class="px-3 py-2 border text-sm">Qty</th>
    <th class="px-3 py-2 border text-sm">Status</th>
    <th class="px-3 py-2 border text-sm">Date</th>
    <th class="px-3 py-2 border text-sm">Actions</th>
</tr>
</thead>
<tbody>
<?php foreach ($deliveries as $row): ?>
<tr class="hover:bg-gray-50">
    <td class="px-3 py-2 border text-sm"><?= htmlspecialchars($row['order_number'] ?? '-') ?></td>
    <td class="px-3 py-2 border text-sm"><?= htmlspecialchars($row['customer_name'] ?? '-') ?></td>
    <td class="px-3 py-2 border text-sm"><?= htmlspecialchars($row['product'] ?? '-') ?></td>
    <td class="px-3 py-2 border text-sm"><?= htmlspecialchars($row['quantity'] ?? '-') ?></td>
    <td class="px-3 py-2 border text-sm"><?= htmlspecialchars($row['status'] ?? '-') ?></td>
    <td class="px-3 py-2 border text-sm"><?= isset($row['created_at']) ? date('M j, Y', strtotime($row['created_at'])) : '-' ?></td>
    <td class="px-3 py-2 border text-sm">
        <a href="?tab=deliveries&edit_delivery=<?= $row['id'] ?>" class="text-blue-600 hover:underline">Edit</a> |
        <a href="?tab=deliveries&delete_delivery=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this delivery?')" class="text-red-600 hover:underline">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php endif; ?>
</section>

<?php elseif ($tab === 'analytics'): ?>
<section class="bg-white p-6 rounded-xl shadow">
<h2 class="text-xl font-semibold mb-4">📊 Delivery Analytics</h2>
<?php if (empty($analyticsData)): ?>
<p class="text-gray-600">No status data to chart. (Make sure your `deliveries` table has a <code>status</code> column.)</p>
<?php else: ?>
<div class="max-w-2xl mx-auto">
<canvas id="singleAnalyticsChart" height="160"></canvas>
</div>
<script>
const labels = <?= json_encode(array_column($analyticsData, 'status')) ?>;
const data = <?= json_encode(array_column($analyticsData, 'count')) ?>;
const ctx = document.getElementById('singleAnalyticsChart').getContext('2d');
new Chart(ctx, {
type: 'bar',
data: {
labels: labels,
datasets: [{
label: 'Deliveries',
data: data,
backgroundColor: labels.map((l,i)=>['#4CAF50','#FFC107','#F44336','#2196F3','#9C27B0'][i%5]),
borderRadius: 6
}]
},
options: {
responsive:true,
plugins:{legend:{display:false}},
scales:{y:{beginAtZero:true,ticks:{precision:0}}}
}
});
</script>
<?php endif; ?>
</section>

<?php elseif ($tab === 'products'): ?>
<section class="bg-white p-8 rounded-xl shadow">
<h2 class="text-xl font-semibold mb-4">🛍️ <?= $editProduct ? "Edit Product" : "Add New Product" ?></h2>

<?php if ($productMessage): ?>
<div class="mb-4 p-3 rounded <?= str_contains($productMessage,'✅') ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800' ?>">
<?= htmlspecialchars($productMessage) ?>
</div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
<input type="hidden" name="add_product" value="1">
<?php if($editProduct): ?>
<input type="hidden" name="product_id" value="<?= $editProduct['id'] ?>">
<input type="hidden" name="original_image" value="<?= $editProduct['image'] ?>">
<?php endif; ?>

<div class="col-span-1 md:col-span-2">
<label class="block text-sm font-medium mb-1">Product Name</label>
<input name="product_name" required class="w-full px-4 py-2 border rounded-lg" value="<?= htmlspecialchars($editProduct['name'] ?? '') ?>" />
</div>

<div>
<label class="block text-sm font-medium mb-1">Price ($)</label>
<input name="price" type="number" step="0.01" required class="w-full px-4 py-2 border rounded-lg" value="<?= htmlspecialchars($editProduct['price'] ?? '') ?>" />
</div>

<div>
<label class="block text-sm font-medium mb-1">Image</label>
<input name="image" type="file" accept="image/*" class="w-full" />
</div>

<div class="md:col-span-2">
<label class="block text-sm font-medium mb-1">Description</label>
<textarea name="description" rows="4" class="w-full px-4 py-2 border rounded-lg"><?= htmlspecialchars($editProduct['description'] ?? '') ?></textarea>
</div>

<div class="md:col-span-2">
<button type="submit" class="w-full bg-black text-white py-3 rounded-lg hover:bg-gray-800 transition">
<?= $editProduct ? "Update Product" : "Add Product" ?>
</button>
</div>
</form>

<div class="mt-8">
<h3 class="text-lg font-semibold mb-3">All Products</h3>
<?php if (empty($products)): ?>
<p class="text-gray-600">No products yet.</p>
<?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
<?php foreach ($products as $p): ?>
<div class="bg-gray-50 p-4 rounded-lg flex flex-col">
    <div class="w-full h-40 bg-white rounded overflow-hidden border mb-3">
        <?php if (!empty($p['image'])): ?>
            <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="w-full h-full object-cover">
        <?php else: ?>
            <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
        <?php endif; ?>
    </div>
    <div class="flex-1 flex flex-col">
        <h4 class="font-semibold"><?= htmlspecialchars($p['name']) ?></h4>
        <p class="text-sm text-gray-600">$<?= number_format($p['price'],2) ?></p>
        <p class="text-sm text-gray-700 mt-2 flex-grow"><?= nl2br(htmlspecialchars($p['description'])) ?></p>
        <div class="mt-3 space-x-2">
            <a href="?tab=products&edit_product=<?= $p['id'] ?>" class="text-sm text-blue-600">Edit</a>
            <a href="?tab=products&delete_product=<?= $p['id'] ?>" onclick="return confirm('Delete product?')" class="text-sm text-red-600">Delete</a>
        </div>
    </div>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
</div>
</section>

<?php elseif ($tab === 'users'): ?>
<section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-semibold mb-4">👥 <?= $editUser ? "Edit User" : "Add New User" ?></h2>

        <?php if ($userMessage): ?>
        <div class="mb-4 p-3 rounded <?= str_contains($userMessage,'✅') ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800' ?>">
            <?= htmlspecialchars($userMessage) ?>
        </div>
        <?php endif; ?>

        <form method="post" action="admin.php?tab=users">
            <input type="hidden" name="add_user" value="1">
            <?php if($editUser): ?><input type="hidden" name="user_id" value="<?= $editUser['id'] ?>"><?php endif; ?>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Username</label>
                    <input name="username" required class="w-full px-4 py-2 border rounded-lg" value="<?= htmlspecialchars($editUser['username'] ?? '') ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input name="email" type="email" required class="w-full px-4 py-2 border rounded-lg" value="<?= htmlspecialchars($editUser['email'] ?? '') ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Password</label>
                    <input name="password" type="password" class="w-full px-4 py-2 border rounded-lg" placeholder="<?= $editUser ? 'Leave blank to keep same' : '' ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Role</label>
                    <select name="role" class="w-full px-4 py-2 border rounded-lg">
                        <option value="Admin" <?= (($editUser['role'] ?? '') === 'Admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="Editor" <?= (($editUser['role'] ?? 'Editor') === 'Editor') ? 'selected' : '' ?>>Editor</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="w-full bg-black text-white py-3 rounded-lg hover:bg-gray-800 transition">
                        <?= $editUser ? "Update User" : "Add User" ?>
                    </button>
                    <?php if($editUser): ?><a href="?tab=users" class="block text-center mt-2 text-sm text-gray-600 hover:text-black">Cancel Edit</a><?php endif; ?>
                </div>
            </div>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-semibold mb-4">User List</h2>
        <?php if (empty($users)): ?>
            <p class="text-gray-600">No users found. Add one using the form.</p>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border text-sm">Username</th>
                            <th class="px-4 py-2 border text-sm">Email</th>
                            <th class="px-4 py-2 border text-sm">Role</th>
                            <th class="px-4 py-2 border text-sm">Joined</th>
                            <th class="px-4 py-2 border text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border text-sm font-medium"><?= htmlspecialchars($user['username']) ?></td>
                                <td class="px-4 py-2 border text-sm"><?= htmlspecialchars($user['email']) ?></td>
                                <td class="px-4 py-2 border text-sm"><span class="px-2 py-1 text-xs rounded-full <?= $user['role'] === 'Admin' ? 'bg-blue-100 text-blue-800' : 'bg-gray-200 text-gray-800' ?>"><?= htmlspecialchars($user['role']) ?></span></td>
                                <td class="px-4 py-2 border text-sm"><?= date('M j, Y', strtotime($user['created_at'])) ?></td>
                                <td class="px-4 py-2 border text-sm">
                                    <a href="?tab=users&edit_user=<?= $user['id'] ?>" class="text-blue-600 hover:underline">Edit</a> |
                                    <a href="?tab=users&delete_user=<?= $user['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')" class="text-red-600 hover:underline">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>


</div> <!-- End container -->
</body>
</html>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>