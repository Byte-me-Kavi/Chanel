<?php
if (!isset($_GET['order_id'])) {
    die("Order ID missing!");
}
$order_id = intval($_GET['order_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Tracking</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6">Order Tracking</h2>
    <p class="mb-4">Order ID: <span class="font-semibold"><?php echo $order_id; ?></span></p>

    <div id="statusBox" class="p-4 border rounded-lg bg-gray-50 text-center text-lg font-semibold">
      Loading status...
    </div>
  </div>

  <script>
    const orderId = <?php echo $order_id; ?>;

    async function fetchStatus() {
      try {
        const response = await fetch("get_tracking_status.php?order_id=" + orderId);
        const data = await response.json();
        document.getElementById("statusBox").innerText = data.status + " (Updated: " + data.updated_at + ")";
      } catch (error) {
        document.getElementById("statusBox").innerText = "Error fetching status.";
      }
    }

    // Fetch immediately and then every 5 seconds
    fetchStatus();
    setInterval(fetchStatus, 5000);
  </script>
</body>
</html>
